@extends('layouts.app')

@section('title', 'កន្ត្រកទំនិញ')

@push('styles')
    <style>
        /* Page title */
        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
            font-weight: 600;
        }

        /* Card */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        /* Product image */
        .card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Quantity */
        .quantity-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-wrapper button {
            width: 32px;
            height: 32px;
            border: none;
            background: #28a745;
            color: white;
            font-size: 18px;
            border-radius: 6px;
        }

        .quantity-wrapper input {
            width: 50px;
            text-align: center;
            border-radius: 6px;
            border: 1px solid #ccc;
            height: 32px;
        }

        /* Summary */
        .summary-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 1rem;
        }

        /* FREE DELIVERY BOX ⭐ */
        .free-delivery-box {
            background: linear-gradient(135deg, #e8fff1, #d4f8e8);
            border: 1px dashed #28a745;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
            font-weight: 500;
            color: #155724;
        }

        .free-delivery-progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 8px;
        }

        .free-delivery-bar {
            height: 100%;
            background: #28a745;
            transition: width .4s ease;
        }

        /* Button */
        .btn-success {
            border-radius: 8px;
            font-weight: 600;
        }

        /* Alert */
        .alert {
            border-radius: 12px;
        }
    </style>
@endpush


@section('content')

    <h1>កន្ត្រកទំនិញរបស់ខ្ញុំ</h1>

    @if ($cartItems->count() > 0)
        @php
            $qty = $cartItems->sum('quantity');
        @endphp

        <div style="display:flex;gap:1rem;flex-wrap:wrap;">

            <!-- ================= LEFT PRODUCTS ================= -->
            <div style="flex:2;">

                @foreach ($cartItems as $item)
                    <div class="card">
                        <div style="display:flex;align-items:center;padding:.5rem;gap:1rem;">

                            <div style="flex:0 0 120px;">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}">
                                @endif
                            </div>

                            <div style="flex:1;">
                                <h5>{{ $item->product->name }}</h5>
                                <p>តម្លៃ: ${{ number_format($item->product->price, 2) }}</p>

                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="quantity-wrapper">
                                        <button type="button"
                                            onclick="this.nextElementSibling.stepDown();this.nextElementSibling.form.submit();">-</button>

                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->stock }}">

                                        <button type="button"
                                            onclick="this.previousElementSibling.stepUp();this.previousElementSibling.form.submit();">+</button>
                                    </div>

                                </form>
                            </div>

                            <div>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">លុប</button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>


            <!-- ================= RIGHT SUMMARY ================= -->
            <div style="flex:1;">

                <div class="summary-card">

                    <!-- FREE DELIVERY PROMO ⭐ -->
                    <div class="free-delivery-box">

                        @php
                            $qty = $cartItems->sum('quantity');
                            $freeDeliveryThreshold = 3; // ទិញពី ៣ ឡើងទៅ FREE
                            $remainingForFree = max(0, $freeDeliveryThreshold - $qty);
                            $progressPercent = min(100, ($qty / $freeDeliveryThreshold) * 100);
                        @endphp

                        @if ($qty >= $freeDeliveryThreshold)
                            🎉 <strong>អបអរសាទរ!</strong> អ្នកទទួលបាន
                            <strong>Free Delivery</strong> ហើយ!
                        @else
                            ទិញបន្ថែម <strong>{{ $remainingForFree }} ទៀត</strong>
                            ដើម្បីទទួលបាន
                            <strong>Free Delivery</strong>
                        @endif

                        <div class="free-delivery-progress">
                            <div class="free-delivery-bar" style="width:{{ $progressPercent }}%"></div>
                        </div>

                    </div>

                    <h5>សង្ខេបការបញ្ជាទិញ</h5>

                    <table style="width:100%;margin-bottom:1rem;">

                        <tr>
                            <td>ចំនួនផលិតផល:</td>
                            <td style="text-align:right">{{ $qty }}</td>
                        </tr>

                        <tr>
                            <td>តម្លៃទំនិញ:</td>
                            <td style="text-align:right;font-weight:600;">
                                ${{ number_format($total, 2) }}
                            </td>
                        </tr>

                        @php
                            $qty = $cartItems->sum('quantity');
                            $freeDeliveryThreshold = 3; // ទិញពី ៣ ឡើងទៅ FREE
                            $deliveryFee = 0.01;
                        @endphp

                        <tr>
                            <td>ការដឹកជញ្ជូន:</td>
                            <td style="text-align:right;font-weight:600;">
                                @if ($qty >= $freeDeliveryThreshold)
                                    <span style="color:green;">FREE</span>
                                    @php $delivery = 0; @endphp
                                @else
                                    ${{ number_format($deliveryFee, 2) }}
                                    @php $delivery = $deliveryFee; @endphp
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td><strong>សរុបទូទៅ:</strong></td>
                            <td style="text-align:right;font-size:1.2rem;font-weight:700;">
                                ${{ number_format($total + $delivery, 2) }}
                            </td>
                        </tr>

                    </table>

                    <a href="{{ route('checkout.index') }}" class="btn btn-success" style="width:100%;">
                        បន្តទៅការបង់ប្រាក់
                    </a>

                </div>
            </div>

        </div>
    @else
        <div class="alert alert-info">
            កន្ត្រកទំនិញរបស់អ្នកទទេ។
            <a href="{{ route('home') }}">បន្តការទិញទំនិញ</a>
        </div>
    @endif

@endsection
