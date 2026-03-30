<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Battambang', 'Segoe UI', Tahoma, Geneva, sans-serif;
            background-color: #f4f6f9;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .success-icon {
            text-align: center;
            margin: 30px 0;
        }

        .success-icon svg {
            width: 80px;
            height: 80px;
            color: #10b981;
        }

        .order-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
        }

        .order-info h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        .items-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .total-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total-row.grand-total {
            font-size: 20px;
            font-weight: 700;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            padding-top: 15px;
            margin-top: 10px;
        }

        .delivery-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .delivery-info h4 {
            color: #856404;
            margin-bottom: 10px;
        }

        .delivery-info p {
            color: #856404;
            margin: 5px 0;
        }

        .cta-button {
            text-align: center;
            margin: 30px 0;
        }

        .cta-button a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.3s;
        }

        .cta-button a:hover {
            transform: translateY(-2px);
        }

        .email-footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .email-footer p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }

        .social-links {
            margin-top: 15px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #667eea;
            text-decoration: none;
            font-size: 20px;
        }

        @media (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎉 ការបញ្ជាទិញបានជោគជ័យ!</h1>
            <p>សូមអរគុណសម្រាប់ការបញ្ជាទិញរបស់អ្នក</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <!-- Greeting -->
            <p class="greeting">សួស្តី <strong>{{ $user->name }}</strong>,</p>

            <!-- Success Icon -->
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <p style="text-align: center; color: #555; font-size: 16px;">
                ការបញ្ជាទិញរបស់អ្នកត្រូវបានបញ្ជាក់ហើយ។ យើងនឹងចាត់ចែងការដឹកជញ្ជូនឆាប់ៗនេះ!
            </p>

            <!-- Order Information -->
            <div class="order-info">
                <h3>📦 ព័ត៌មានការបញ្ជាទិញ</h3>
                
                <div class="info-row">
                    <span class="info-label">លេខកូដការបញ្ជាទិញ:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">កាលបរិច្ឆេទបញ្ជាទិញ:</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">វិធីទូទាត់:</span>
                    <span class="info-value">
                        {{ $order->payment_method === 'qr' ? 'KHQR' : 'ទូទាត់ពេលទទួលបាន (COD)' }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">ស្ថានភាព:</span>
                    <span class="info-value" style="color: #10b981;">{{ $order->status }}</span>
                </div>
            </div>

            <!-- Order Items -->
            <h3 style="margin: 25px 0 15px; color: #333;">🛒 ទំនិញដែលបានបញ្ជាទិញ</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>ទំនិញ</th>
                        <th>ចំនួន</th>
                        <th>តម្លៃ</th>
                        <th>សរុប</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <span>ចំនួនទំនិញ:</span>
                    <span>{{ $order->items->sum('quantity') }} ដុំ</span>
                </div>
                <div class="total-row grand-total">
                    <span>សរុបទូទាត់:</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="delivery-info">
                <h4>📍 ព័ត៌មានដឹកជញ្ជូន</h4>
                <p><strong>លេខទូរស័ព្ទ:</strong> {{ $order->shipping_phone }}</p>
                
                @if($order->location_type === 'phnom_penh')
                    <p><strong>អាសយដ្ឋាន:</strong> លេខផ្ទះ {{ $order->house_number }}, ផ្លូវ {{ $order->street }}, ខណ្ឌ {{ $order->district }}, ភ្នំពេញ</p>
                @else
                    <p><strong>អាសយដ្ឋាន:</strong> ភូមិ {{ $order->village }}, ស្រុក/ក្រុង {{ $order->city }}, ខេត្ត {{ $order->province }}</p>
                @endif
            </div>

            <!-- Call to Action -->
            <div class="cta-button">
                <a href="{{ route('orders.show', $order->id) }}">
                    👁️ មើលព័ត៌មានលម្អិត
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>E-Food</strong> - អាហារឆ្ងាញ់ ដឹកជញ្ជូនរហ័ស</p>
            <p>សម្រាប់ការគាំទ្រ: support@e-food.com | 012 345 678</p>
            
            <div class="social-links">
                <a href="#">📘 Facebook</a>
                <a href="#">📷 Instagram</a>
                <a href="#">💬 Telegram</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                នេះជាសារស្វ័យប្រវត្តិ សូមកុំឆ្លើយតប។
            </p>
        </div>
    </div>
</body>
</html>
