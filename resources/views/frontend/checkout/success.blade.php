@extends('layouts.app')

@section('content')
<div class="container py-30">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            {{-- Success Card --}}
            <div class="card shadow-lg border-0 success-card">
                <div class="card-body text-center p-4 p-md-5">
                    {{-- Animated Success Icon --}}
                    <div class="success-icon mb-4">
                        <div class="checkmark-circle">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Confetti Canvas --}}
                    <canvas id="confetti" class="confetti-canvas"></canvas>

                    {{-- Success Message --}}
                    <h1 class="display-4 fw-bold text-success mb-3 animate-fade-in">
                        🎉 ការបញ្ជាទិញបានជោគជ័យ!
                    </h1>

                    <p class="lead text-muted mb-4 animate-fade-in-delay">
                        @if(session('success'))
                            {{ session('success') }}
                        @else
                            សូមអរគុណសម្រាប់ការបញ្ជាទិញរបស់អ្នក! យើងនឹងជូនដំណឹងដល់អ្នកនៅពេលវាត្រូវបានដឹកជញ្ជូន។
                        @endif
                    </p>

                    {{-- Order Details --}}
                    <div class="order-details bg-light rounded-4 p-4 mb-4 animate-slide-up">
                        <div class="mb-3">
                            <span class="text-muted">លេខកូដការបញ្ជាទិញ</span>
                            <h3 class="fw-bold text-primary mb-0">#{{ $order->id ?? 'N/A' }}</h3>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="bi bi-credit-card text-success fs-4 mb-2 d-block"></i>
                                    <p class="small text-muted mb-1">ការទូទាត់</p>
                                    <p class="fw-bold mb-0">
                                        @if(($order->payment_method ?? '') === 'qr')
                                            <span class="badge bg-success">✓ ទូទាត់តាម KHQR</span>
                                        @else
                                            <span class="badge bg-warning text-dark">ទូទាត់ពេលទទួលបានទំនិញ</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="bi bi-cash-stack text-primary fs-4 mb-2 d-block"></i>
                                    <p class="small text-muted mb-1">សរុប</p>
                                    <p class="fw-bold mb-0">${{ number_format($order->total ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delivery Info --}}
                    <div class="alert alert-info border-0 rounded-4 mb-4 animate-slide-up-delay">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-truck fs-3 me-3"></i>
                            <div class="text-start">
                                <h6 class="fw-bold mb-1">ព័ត៌មានដឹកជញ្ជូន</h6>
                                <p class="small mb-0">
                                    <strong>{{ $order->shipping_name ?? 'N/A' }}</strong><br>
                                    @if(($order->location_type ?? '') === 'phnom_penh')
                                        ខណ្ឌ៖ {{ $order->district ?? '' }}, ផ្លូវ៖ {{ $order->street ?? '' }}, លេខផ្ទះ៖ {{ $order->house_number ?? '' }}
                                    @else
                                        ភូមិ៖ {{ $order->village ?? '' }}, ស្រុក/ក្រុង៖ {{ $order->city ?? '' }}, ខេត្ត៖ {{ $order->province ?? '' }}
                                    @endif
                                    <br>
                                    {{ $order->shipping_phone ?? 'No phone' }}
                                </p>
                                @if(($order->tracking_number ?? false))
                                    <p class="small mt-2 mb-0">
                                        <i class="bi bi-upc-scan"></i> លេខតាមដាន៖ <strong>{{ $order->tracking_number }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Status Timeline (Dynamic based on order status) --}}
                    <div class="timeline mb-4 animate-slide-up-delay-2">
                        <h6 class="fw-bold text-muted mb-3">ស្ថានភាពការបញ្ជាទិញ</h6>
                        @php
                            $statuses = [
                                'placed' => 'បានបញ្ជាទិញ',
                                'processing' => 'កំពុងដំណើរការ',
                                'shipped' => 'កំពុងដឹកជញ្ជូន',
                                'delivered' => 'បានទទួល'
                            ];
                            $currentStatus = $order->status ?? 'placed';
                            $statusOrder = ['placed', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        @endphp
                        @foreach($statusOrder as $index => $key)
                            <div class="timeline-item {{ $index <= $currentIndex ? 'completed' : '' }}">
                                <div class="timeline-dot {{ $index <= $currentIndex ? 'completed' : 'pending' }}"></div>
                                <div class="timeline-content">
                                    <p class="fw-bold mb-0 {{ $index <= $currentIndex ? 'text-dark' : 'text-muted' }}">
                                        {{ $statuses[$key] }}
                                    </p>
                                    @if($index == $currentIndex && $order->updated_at)
                                        <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                                    @else
                                        <small class="text-muted">
                                            @if($index < $currentIndex) បានបញ្ចប់
                                            @elseif($index == $currentIndex) កំពុងអនុវត្ត
                                            @else រង់ចាំ
                                            @endif
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Estimated Delivery --}}
                    <div class="alert alert-light border rounded-4 mb-4 animate-fade-in">
                        <i class="bi bi-clock-history me-2"></i>
                        ការដឹកជញ្ជូនរំពឹងទុក៖ <strong>{{ now()->addDays(3)->format('l, d F Y') }}</strong>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-grid gap-2 animate-fade-in-delay-2">
                        <a href="{{ route('orders.show', ['order' => $order->id ?? 0]) }}" class="btn btn-primary btn-lg rounded-pill">
                            <i class="bi bi-eye me-2"></i> មើលព័ត៌មានលម្អិត
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-success btn-lg rounded-pill">
                            <i class="bi bi-cart me-2"></i> ទិញទំនិញបន្ត
                        </a>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="bi bi-printer"></i> បោះពុម្ព
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="shareBtn">
                                <i class="bi bi-share"></i> ចែករំលែក
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
    /* General */
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-pill {
        border-radius: 50rem !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* Success Icon Animation */
    .success-icon {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .checkmark-circle {
        width: 120px;
        height: 120px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    .checkmark {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #fff;
        stroke-miterlimit: 10;
        box-shadow: inset 0 0 0 #28a745;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: absolute;
        top: 0;
        left: 0;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #28a745;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }

    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }

    @keyframes fill {
        100% { box-shadow: inset 0 0 0 120px #28a745; }
    }

    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Animations */
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out 0.3s both;
    }

    .animate-fade-in-delay {
        animation: fadeIn 0.6s ease-out 0.5s both;
    }

    .animate-fade-in-delay-2 {
        animation: fadeIn 0.6s ease-out 0.7s both;
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out 0.4s both;
    }

    .animate-slide-up-delay {
        animation: slideUp 0.6s ease-out 0.6s both;
    }

    .animate-slide-up-delay-2 {
        animation: slideUp 0.6s ease-out 0.8s both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
        text-align: left;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -24px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #28a745;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #28a745;
        transition: all 0.3s ease;
    }

    .timeline-dot.pending {
        background: #e9ecef;
        box-shadow: 0 0 0 2px #dee2e6;
    }

    .timeline-item.completed .timeline-dot {
        background: #28a745;
        box-shadow: 0 0 0 2px #28a745;
    }

    .timeline-content {
        padding-left: 15px;
    }

    /* Confetti Canvas */
    .confetti-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
    }

    /* Card Animation */
    .success-card {
        animation: cardEntrance 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes cardEntrance {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .success-card .card-body {
            padding: 1.5rem !important;
        }
        .order-details .row > div {
            margin-bottom: 1rem;
        }
        .timeline {
            padding-left: 20px;
        }
        .timeline-dot {
            left: -20px;
        }
    }
</style>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    // Launch confetti
    document.addEventListener('DOMContentLoaded', function() {
        // Initial burst
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#28a745', '#20c997', '#17a2b8', '#007bff', '#ffc107', '#fd7e14']
        });

        // Side cannons
        setTimeout(() => {
            confetti({
                particleCount: 50,
                angle: 60,
                spread: 55,
                origin: { x: 0, y: 0.6 },
                colors: ['#28a745', '#20c997', '#17a2b8']
            });
            confetti({
                particleCount: 50,
                angle: 120,
                spread: 55,
                origin: { x: 1, y: 0.6 },
                colors: ['#ffc107', '#fd7e14', '#28a745']
            });
        }, 300);

        // Continuous small bursts
        let end = Date.now() + 2000;
        (function frame() {
            confetti({
                particleCount: 5,
                angle: 60,
                spread: 55,
                origin: { x: 0 },
                colors: ['#28a745', '#20c997']
            });
            confetti({
                particleCount: 5,
                angle: 120,
                spread: 55,
                origin: { x: 1 },
                colors: ['#28a745', '#20c997']
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }());

        // Share button
        const shareBtn = document.getElementById('shareBtn');
        if (shareBtn && navigator.share) {
            shareBtn.addEventListener('click', () => {
                navigator.share({
                    title: 'ការបញ្ជាទិញបានជោគជ័យ',
                    text: `ការបញ្ជាទិញលេខ #{{ $order->id ?? 'N/A' }} របស់ខ្ញុំត្រូវបានបញ្ជាក់!`,
                    url: window.location.href
                }).catch(console.error);
            });
        } else if (shareBtn) {
            shareBtn.style.display = 'none';
        }
    });
</script>
@endsection
