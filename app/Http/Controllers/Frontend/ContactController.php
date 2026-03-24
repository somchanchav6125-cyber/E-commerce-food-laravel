<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display contact form
     */
    public function index()
    {
        return view('frontend.contact.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'សូមបញ្ចូលឈ្មោះរបស់អ្នក',
            'email.required' => 'សូមបញ្ចូលអ៊ីមែល',
            'email.email' => 'សូមបញ្ចូលអ៊ីមែលឱ្យបានត្រឹមត្រូវ',
            'message.required' => 'សូមបញ្ចូលសារ',
            'message.min' => 'សារត្រូវតែមានយ៉ាងតិច ១០ តួអក្សរ',
        ]);

        $this->sendTelegramNotification($validated);

        return redirect()->route('contact')
            ->with('success', 'សាររបស់អ្នកត្រូវបានផ្ញើជូនយើងខ្ញុំហើយ! យើងខ្ញុំនឹងទាក់ទងទៅអ្នកវិញឆាប់ៗនេះ។');
    }

    /**
     * Send notification to Telegram
     */
    private function sendTelegramNotification($data)
    {
        $botToken = '8626701865:AAHQ_GZWAj7nToDS4uNTk4fr5D15Ce5Sdeg';
        $chatId = '5424661938';

        $message = "📬 <b>សារថ្មីពីទំព័រទំនាក់ទំនង</b>\n\n";
        $message .= "👤 <b>ឈ្មោះ:</b> {$data['name']}\n";
        $message .= "📧 <b>អ៊ីមែល:</b> {$data['email']}\n";
        if (!empty($data['subject'])) {
            $message .= "📝 <b>ប្រធានបទ:</b> {$data['subject']}\n";
        }
        $message .= "💬 <b>សារ:</b>\n{$data['message']}\n\n";
        $message .= "🕒 <b>ពេលវេលា:</b> " . now()->format('d/m/Y H:i:s');

        try {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }
    }
}
