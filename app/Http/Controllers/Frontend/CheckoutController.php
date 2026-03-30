<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Http\Request;
use App\Models\Product;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use SebastianBergmann\Environment\Console;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $qr = null;
        $md5 = null;

        // Generate QR if cart has items
        if ($cartItems->isNotEmpty() && $total > 0) {
            $bakongToken = env('BAKONG_TOKEN');

            $merchant = new IndividualInfo(
                bakongAccountID: env('BAKONG_MERCHANT', 'chanchav_som@bkrt'),
                merchantName: env('BAKONG_MERCHANT_NAME', 'VANNAK DIM'),
                merchantCity: env('BAKONG_MERCHANT_CITY', 'Phnom Penh'),
                currency: KHQRData::CURRENCY_USD,
                amount: round($total, 2)
            );

            try {
                if ($bakongToken) {
                    $bakong = new BakongKHQR($bakongToken);
                    $qrResponse = $bakong->generateIndividual($merchant);
                } else {
                    $qrResponse = BakongKHQR::generateIndividual($merchant);
                }

                if (isset($qrResponse->data['qr']) && !empty($qrResponse->data['qr'])) {
                    $qr = $qrResponse->data['qr'];
                    $md5 = $qrResponse->data['md5'] ?? null;
                }
            } catch (\Exception $e) {
                Log::error('QR Generation failed: ' . $e->getMessage());
            }
        }

        return view('frontend.checkout.index', compact('cartItems', 'total', 'qr', 'md5'));
    }

    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        // Your merchant info (replace with real Bakong account)
        $merchant = new IndividualInfo(
            bakongAccountID: 'chanchav_som@bkrt',
            merchantName: 'VANNAK DIM',
            merchantCity: 'Phnom Penh',
            currency: KHQRData::CURRENCY_KHR,
            amount: $product->price
        );
        $qrResponse = BakongKHQR::generateIndividual($merchant);
        return view('products.checkout', [
            'product' => $product,
            'qr' => $qrResponse->data['qr'] ?? null,
            'md5' => $qrResponse->data['md5'] ?? null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qr,cod',
            'phone' => 'required|string|max:20',

            // Location fields
            'location_type' => 'required|in:phnom_penh,province',
            // Phnom Penh fields
            'district' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:255',
            // Province fields
            'village' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
        ]);

        // Get cart items
        $cartItems = Cart::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Validate total amount
        if ($total <= 0) {
            return redirect()->back()->with('error', 'Invalid cart total');
        }

        $paymentMethod = $request->payment_method;
        $paymentQr = null;
        $paymentMd5 = null;
        $paymentStatus = 'pending';

        // Generate QR if payment method is QR
        if ($paymentMethod === 'qr') {
            $bakongToken = env('BAKONG_TOKEN');

            $merchant = new IndividualInfo(
                bakongAccountID: env('BAKONG_MERCHANT', 'chanchav_som@bkrt'),
                merchantName: env('BAKONG_MERCHANT_NAME', 'VANNAK DIM'),
                merchantCity: env('BAKONG_MERCHANT_CITY', 'Phnom Penh'),
                currency: KHQRData::CURRENCY_USD,
                amount: round($total, 2)
            );

            try {
                if ($bakongToken) {
                    $bakong = new BakongKHQR($bakongToken);
                    $qrResponse = $bakong->generateIndividual($merchant);
                } else {
                    $qrResponse = BakongKHQR::generateIndividual($merchant);
                }

                if (isset($qrResponse->data['qr']) && !empty($qrResponse->data['qr'])) {
                    $paymentQr = $qrResponse->data['qr'];
                    $paymentMd5 = $qrResponse->data['md5'] ?? null;
                } else {
                    $errorMsg = $qrResponse->message ?? $qrResponse->error ?? 'Unknown error';
                    return redirect()->back()->with('error', 'Failed to generate QR code: ' . $errorMsg);
                }
            } catch (\KHQR\Exceptions\KHQRException $e) {
                return redirect()->back()->with('error', 'Failed to generate payment QR: ' . $e->getMessage());
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Unexpected error: ' . $e->getMessage());
            }
        } else {
            // COD payment
            $paymentStatus = 'cod_pending';
        }

        // Prepare location data
        $locationData = [
            'location_type' => $request->location_type,
        ];

        if ($request->location_type === 'phnom_penh') {
            $locationData['district'] = $request->district;
            $locationData['street'] = $request->street;
            $locationData['house_number'] = $request->house_number;
        } else {
            $locationData['village'] = $request->village;
            $locationData['city'] = $request->city;
            $locationData['province'] = $request->province;
        }

        // Create order with pending status
        $order = Order::create(array_merge([
            'user_id' => Auth::id(),
            'total' => $total,
            'total_amount' => $total,
            'payment_token' => bin2hex(random_bytes(16)), // Generate unique payment token
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'shipping_phone' => $request->phone,
            'payment_qr' => $paymentQr,
            'payment_md5' => $paymentMd5,
        ], $locationData));

        // Save order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Reduce product stock
            $product = $item->product;
            if ($product && $product->stock >= $item->quantity) {
                $product->decrement('stock', $item->quantity);
            }
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        // Send notification to Telegram
        $this->sendTelegramNotification($order);

        // Send order confirmation email to user
        try {
            Mail::to($order->user->email)->send(new OrderSuccessMail($order));
            Log::info('Order confirmation email sent to: ' . $order->user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
        }

        // Redirect based on payment method
        if ($paymentMethod === 'qr') {
            // For QR payment, redirect directly to success page
            return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'ការទូទាត់បានជោគជ័យ! ការបញ្ជាទិញរបស់អ្នកត្រូវបានបញ្ជាក់។');
        } else {
            // For COD, redirect to success page
            return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'ការបញ្ជាទិញបានជោគជ័យ! សូមរៀបចំសាច់ប្រាក់សម្រាប់ទូទាត់ពេលទទួលបានទំនិញ។');
        }
    }

    /**
     * Send order notification to Telegram
     */
    private function sendTelegramNotification($order)
    {
        $telegramBotToken = '8626701865:AAHQ_GZWAj7nToDS4uNTk4fr5D15Ce5Sdeg';
        $telegramChatId = '5424661938';

        // Build order message
        $message = "🛒 **ការបញ្ជាទិញថ្មី**\n\n";
        $message .= "📦 **លេខកូដការបញ្ជាទិញ:** #{$order->id}\n";
        $message .= "👤 **ឈ្មោះ:** {$order->shipping_name}\n";
        $message .= "📱 **លេខទូរស័ព្ទ:** {$order->shipping_phone}\n";

        // Location info
        if ($order->location_type === 'phnom_penh') {
            $message .= "📍 **អាសយដ្ឋាន:** ខណ្ឌ {$order->district}, ផ្លូវ {$order->street}, លេខផ្ទះ {$order->house_number}\n";
        } else {
            $message .= "📍 **អាសយដ្ឋាន:** ភូមិ {$order->village}, ស្រុក/ក្រុង {$order->city}, ខេត្ត {$order->province}\n";
        }

        $message .= "💰 **សរុប:** $".number_format($order->total, 2)."\n";
        $message .= "💳 **វិធីទូទាត់:** ".($order->payment_method === 'qr' ? 'KHQR' : 'ទូទាត់ពេលទទួលបាន')."\n";
        $message .= "📊 **ស្ថានភាព:** {$order->status}\n\n";

        // Order items
        $message .= "**ព័ត៌មានទំនិញ:**\n";
        foreach ($order->items as $item) {
            $message .= "• {$item->product->name} x {$item->quantity} - $".number_format($item->price * $item->quantity, 2)."\n";
        }

        $message .= "\n🕒 **ពេលវេលា:** ".now()->format('d/m/Y H:i');

        // Send to Telegram
        $url = "https://api.telegram.org/bot{$telegramBotToken}/sendMessage";

        $data = [
            'chat_id' => $telegramChatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);

            Log::info('Telegram notification sent: ' . $result);
        } catch (\Exception $e) {
            Log::error('Failed to send Telegram notification: ' . $e->getMessage());
        }
    }

    public function payment($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.checkout.payment', [
            'order' => $order,
            'qr' => $order->payment_qr,
            'md5' => $order->payment_md5,
        ]);
    }

    public function status($order)
    {
        return view('frontend.checkout.status', compact('order'));
    }

    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.checkout.success', compact('order'));
    }
    public function verifyForm()
    {
        return view('payments.verify');
    }
    public function verifyTransaction(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);
        try {
            // Your Bakong API token from https://api-bakong.nbc.gov.kh/register
            $token = env('BAKONG_TOKEN'); // put it in .env
            $bakong = new \KHQR\BakongKHQR($token);
            $result = $bakong->checkTransactionByMD5($request->md5);
            return response()->json($result);
            // return view('payments.result', ['result' => $result]);
        } catch (\Exception $e) {
            // return back()->withErrors(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function paymentResult()
    {
        return view('payments.result');
    }
}
