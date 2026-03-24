@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" 
                                 class="me-2" viewBox="0 0 16 16">
                                <path d="M14.244 2.083a9.173 9.173 0 0 0-1.436-.864C11.673.653 10.033.25 8 .25c-2.033 0-3.673.403-4.808.969a9.173 9.173 0 0 0-1.436.864C.653 2.653.25 4.293.25 6.326c0 2.033.403 3.673.969 4.808.252.505.553.986.9 1.436.279.362.589.707.928 1.031.324.34.67.65 1.031.928a9.173 9.173 0 0 0 1.436.9C6.653 15.997 8.293 16.4 10.326 16.4c2.033 0 3.673-.403 4.808-.969a9.173 9.173 0 0 0 1.436-.864c.505-.252.986-.553 1.436-.9.362-.279.707-.589 1.031-.928a9.173 9.173 0 0 0 .9-1.436c.566-1.135.969-2.775.969-4.808 0-2.033-.403-3.673-.969-4.808a9.173 9.173 0 0 0-.9-1.436 9.173 9.173 0 0 0-.928-1.031 9.173 9.173 0 0 0-1.031-.928 9.173 9.173 0 0 0-1.436-.9ZM8 14.5c-3.5 0-6.5-3-6.5-6.5s3-6.5 6.5-6.5 6.5 3 6.5 6.5-3 6.5-6.5 6.5Z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"/>
                            </svg>
                            Payment for Order #{{ $order->id }}
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="mb-4">Scan KHQR to Pay</h5>
                        
                        <div class="mb-4">
                            <p class="text-muted">Order Total: <strong class="text-primary fs-4">{{ number_format($order->total_amount, 2) }} $</strong></p>
                        </div>

                        @if ($qr)
                            <div class="qr-container mb-4 p-3 bg-light rounded d-inline-block">
                                {!! QrCode::size(280)->generate($qr) !!}
                            </div>
                            
                            <div class="alert alert-info">
                                <p class="mb-1"><strong>MD5:</strong> <code class="text-break">{{ $md5 }}</code></p>
                                <p class="mb-0 text-muted small">Scan this QR code using Bakong App to make a payment.</p>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                ⚠ Failed to generate KHQR code.
                            </div>
                        @endif

                        {{-- Countdown Timer --}}
                        <div class="mt-4 p-3 bg-light rounded">
                            <h3 id="countdown" class="text-danger fw-bold mb-0">120</h3>
                            <p class="text-muted mb-0 small">This page will expire in <span id="seconds">120</span> seconds</p>
                        </div>

                        {{-- Status Messages --}}
                        <div id="payment-status" class="mt-3"></div>

                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Back to Shop</a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">View My Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Countdown & Auto-Verification Script --}}
    <script>
        let timeLeft = 120; // seconds
        const countdownElement = document.getElementById('countdown');
        const secondsText = document.getElementById('seconds');
        const statusElement = document.getElementById('payment-status');
        let paymentVerified = false;

        const timer = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;
            secondsText.textContent = timeLeft;

            if (timeLeft > 0 && !paymentVerified) {
                // Auto-verify every 3 seconds
                fetch("{{ route('verify.transaction') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            md5: "{{ $md5 }}"
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Verification response:', data);
                        
                        // Check for successful payment
                        if (data.responseCode === 0 || data.status === 'success' || data.paid === true) {
                            paymentVerified = true;
                            clearInterval(timer);
                            
                            statusElement.innerHTML = `
                                <div class="alert alert-success">
                                    <strong>✓ Payment Successful!</strong> Redirecting...
                                </div>
                            `;
                            
                            setTimeout(() => {
                                window.location.href = "{{ route('checkout.success', ['order' => $order->id]) }}";
                            }, 1500);
                        } else if (data.responseCode !== undefined && data.responseCode !== 0) {
                            // Payment failed
                            statusElement.innerHTML = `
                                <div class="alert alert-warning">
                                    ⚠ Payment not yet received. Please scan the QR code.
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Verification error:', error);
                        statusElement.innerHTML = `
                            <div class="alert alert-danger">
                                ⚠ Verification error. Please try again.
                            </div>
                        `;
                    });
            }

            if (timeLeft <= 0) {
                clearInterval(timer);
                if (!paymentVerified) {
                    statusElement.innerHTML = `
                        <div class="alert alert-danger">
                            ⚠ Payment session expired. Please start checkout again.
                        </div>
                    `;
                    setTimeout(() => {
                        window.location.href = "{{ route('checkout.index') }}";
                    }, 2000);
                }
            }
        }, 3000); // Check every 3 seconds
    </script>
@endsection
