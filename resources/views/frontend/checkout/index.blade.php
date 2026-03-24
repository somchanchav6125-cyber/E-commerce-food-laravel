@extends('layouts.app')

@section('content')
<div class="container py-20">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Progress Stepper --}}
    <div class="stepper-wrapper mb-5">
        <div class="stepper-item active">
            <div class="step-counter">1</div>
            <div class="step-name">ដឹកជញ្ជូន</div>
        </div>
        <div class="stepper-item active">
            <div class="step-counter">2</div>
            <div class="step-name">ទូទាត់</div>
        </div>
        <div class="stepper-item">
            <div class="step-counter">3</div>
            <div class="step-name">បញ្ជាក់</div>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row g-4">
            {{-- Left Column: Combined Checkout Card --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-cart-check-fill me-2"></i> បញ្ចប់ការបញ្ជាទិញរបស់អ្នក
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        {{-- ========== SHIPPING SECTION ========== --}}
                        <div class="mb-5">
                            <h6 class="fw-bold mb-3 pb-2 border-bottom">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i> ព័ត៌មានដឹកជញ្ជូន
                            </h6>

                            {{-- Delivery Location Dropdown --}}
                            <div class="mb-4">
                                <label for="location_type" class="form-label fw-bold">
                                    <i class="bi bi-pin-map-fill text-primary me-1"></i> ទីតាំងដឹកជញ្ជូន
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('location_type') is-invalid @enderror"
                                        id="location_type" name="location_type" onchange="handleLocationChange(this.value)" required>
                                    <option value="">-- ជ្រើសរើសទីតាំងដឹកជញ្ជូន --</option>
                                    <option value="phnom_penh" {{ old('location_type') == 'phnom_penh' ? 'selected' : '' }}>🏙️ ភ្នំពេញ</option>
                                    <option value="province" {{ old('location_type') == 'province' ? 'selected' : '' }}>🏞️ ខេត្ត</option>
                                </select>
                                @error('location_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="bi bi-telephone-fill text-primary me-1"></i> លេខទូរស័ព្ទ
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="ឧទាហរណ៍៖ 012 345 678" required>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phnom Penh Address Fields --}}
                            <div id="phnom-penh-fields" class="location-fields" style="display: none;">
                                <div class="alert alert-light border rounded-3 p-3 mb-3">
                                    <i class="bi bi-info-circle-fill text-info me-1"></i>
                                    <small>សូមផ្តល់អាសយដ្ឋានរបស់អ្នកនៅភ្នំពេញ</small>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="district" class="form-label">ខណ្ឌ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('district') is-invalid @enderror"
                                               id="district" name="district" value="{{ old('district') }}"
                                               placeholder="ឧទាហរណ៍៖ ៧មករា">
                                        @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="street" class="form-label">ផ្លូវ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('street') is-invalid @enderror"
                                               id="street" name="street" value="{{ old('street') }}"
                                               placeholder="ឧទាហរណ៍៖ ១២៨">
                                        @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="house_number" class="form-label">លេខផ្ទះ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('house_number') is-invalid @enderror"
                                               id="house_number" name="house_number" value="{{ old('house_number') }}"
                                               placeholder="ឧទាហរណ៍៖ ២៣B">
                                        @error('house_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Province Address Fields --}}
                            <div id="province-fields" class="location-fields" style="display: none;">
                                <div class="alert alert-light border rounded-3 p-3 mb-3">
                                    <i class="bi bi-info-circle-fill text-info me-1"></i>
                                    <small>សូមផ្តល់អាសយដ្ឋានពេញលេញនៅខេត្ត</small>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="village" class="form-label">ភូមិ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('village') is-invalid @enderror"
                                               id="village" name="village" value="{{ old('village') }}"
                                               placeholder="ឧទាហរណ៍៖ អូរឫស្សី">
                                        @error('village') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">ឃុំ/ស្រុក <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                               id="city" name="city" value="{{ old('city') }}"
                                               placeholder="ឧទាហរណ៍៖ កំពង់ចាម">
                                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="province" class="form-label">ខេត្ត <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('province') is-invalid @enderror"
                                               id="province" name="province" value="{{ old('province') }}"
                                               placeholder="ឧទាហរណ៍៖ កំពង់ចាម">
                                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ========== PAYMENT SECTION ========== --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 pb-2 border-bottom">
                                <i class="bi bi-credit-card-2-front-fill text-success me-2"></i> វិធីសាស្ត្រទូទាត់
                            </h6>

                            {{-- Payment Method Dropdown --}}
                            <div class="mb-4">
                                <label for="payment_method" class="form-label fw-bold">
                                    <i class="bi bi-cash-stack me-1"></i> ជ្រើសរើសវិធីសាស្ត្រទូទាត់
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" onchange="handlePaymentChange(this.value)" required>
                                    <option value="qr" {{ old('payment_method', 'qr') == 'qr' ? 'selected' : '' }}>📱 KHQR Payment (ស្កែន & ទូទាត់)</option>
                                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>💰 ទូទាត់ពេលទទួលបានទំនិញ</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- QR Payment Section (Dynamic) --}}
                            <div id="qr-payment-section" class="mt-4">
                                @if($qr && $md5)
                                    <div class="p-4 bg-light rounded-4 border border-primary shadow-sm">
                                        <h6 class="fw-bold text-primary mb-3 text-center">
                                            <i class="bi bi-upc-scan me-2"></i> ស្កែនដើម្បីទូទាត់ - ${{ number_format($total, 2) }}
                                        </h6>
                                        <div class="text-center">
                                            <div class="d-inline-block p-3 bg-white rounded-3 shadow-sm mb-3">
                                                {!! QrCode::size(220)->generate($qr) !!}
                                            </div>
                                        </div>
                                        <div id="payment-status" class="mt-3"></div>
                                        <div class="alert alert-info mt-3 mb-0 py-2 small text-center rounded-3">
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            <strong>ការផ្ទៀងផ្ទាត់ស្វ័យប្រវត្តិ</strong> - ការទូទាត់នឹងត្រូវបានផ្ទៀងផ្ទាត់ដោយស្វ័យប្រវត្តិបន្ទាប់ពីស្កែន
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        មិនអាចបង្កើតលេខកូដ QR បានទេ។ សូមព្យាយាមទូទាត់ពេលទទួលបានទំនិញ ឬទាក់ទងផ្នែកគាំទ្រ។
                                    </div>
                                @endif
                            </div>

                            {{-- COD Info Section (Dynamic) --}}
                            <div id="cod-info-section" class="mt-4 p-4 bg-light rounded-4 border border-success" style="display: none;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-truck fs-1 text-success me-3"></i>
                                    <div>
                                        <h6 class="fw-bold text-success mb-1">ទូទាត់ពេលទទួលបានទំនិញ</h6>
                                        <p class="small text-muted mb-0">បំពេញព័ត៌មានដឹកជញ្ជូនរបស់អ្នក រួចចុច "បញ្ជាទិញ" ខាងក្រោម។ ទូទាត់ជាសាច់ប្រាក់នៅពេលអ្នកទទួលបានទំនិញ។</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Place Order Button (Only for COD) --}}
                            <div id="place-order-section" class="d-grid mt-4" style="display: none;">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill py-3 fw-bold shadow-sm" id="submit-btn">
                                    <i class="bi bi-check2-circle me-2"></i> បញ្ជាទិញ - ទូទាត់ពេលទទួលបាន
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-semibold"><i class="bi bi-cart-check-fill me-2"></i> សង្ខេបការបញ្ជាទិញ</h5>
                    </div>
                    <div class="card-body p-4">
                        @if($cartItems && count($cartItems) > 0)
                            <ul class="list-unstyled mb-3">
                                @foreach($cartItems as $item)
                                    <li class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <div>
                                            <span class="fw-medium">{{ $item->product->name }}</span>
                                            <br>
                                            <small class="text-muted">ចំនួន៖ {{ $item->quantity }}</small>
                                        </div>
                                        <span class="fw-bold text-primary">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="fs-5 fw-bold">សរុប៖</span>
                                <span class="fs-4 fw-bold text-success">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="mt-3 text-center">
                                <small class="text-muted"><i class="bi bi-shield-check"></i> ការទូទាត់មានសុវត្ថិភាព</small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-cart-x fs-1 text-muted"></i>
                                <p class="text-muted mt-2">កន្ត្រកទំនិញរបស់អ្នកទទេ</p>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm rounded-pill">ទិញទំនិញ</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* General */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-pill {
        border-radius: 50rem !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }

    /* Progress Stepper */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .stepper-item {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .stepper-item:not(:last-child):before {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background-color: #dee2e6;
        z-index: 0;
    }
    .stepper-item.active:not(:last-child):before {
        background-color: #0d6efd;
    }
    .step-counter {
        width: 40px;
        height: 40px;
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        position: relative;
        z-index: 1;
        background-color: white;
    }
    .stepper-item.active .step-counter {
        border-color: #0d6efd;
        background-color: #0d6efd;
        color: white;
    }
    .step-name {
        margin-top: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #6c757d;
    }
    .stepper-item.active .step-name {
        color: #0d6efd;
        font-weight: bold;
    }

    /* Location & Payment Cards (no longer used but kept for potential future) */
    .location-fields {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .verifying {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    /* Form Input Focus */
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
    }
</style>

<script>
    let paymentVerified = false;
    let verificationInterval = null;

    // Location change handler
    function handleLocationChange(type) {
        const phnomPenhFields = document.getElementById('phnom-penh-fields');
        const provinceFields = document.getElementById('province-fields');

        // Required fields
        const district = document.getElementById('district');
        const street = document.getElementById('street');
        const houseNumber = document.getElementById('house_number');
        const village = document.getElementById('village');
        const city = document.getElementById('city');
        const province = document.getElementById('province');

        if (type === 'phnom_penh') {
            phnomPenhFields.style.display = 'block';
            provinceFields.style.display = 'none';
            district.required = true;
            street.required = true;
            houseNumber.required = true;
            village.required = false;
            city.required = false;
            province.required = false;
        } else if (type === 'province') {
            phnomPenhFields.style.display = 'none';
            provinceFields.style.display = 'block';
            district.required = false;
            street.required = false;
            houseNumber.required = false;
            village.required = true;
            city.required = true;
            province.required = true;
        } else {
            phnomPenhFields.style.display = 'none';
            provinceFields.style.display = 'none';
            district.required = false;
            street.required = false;
            houseNumber.required = false;
            village.required = false;
            city.required = false;
            province.required = false;
        }
    }

    // Payment change handler
    function handlePaymentChange(method) {
        const qrSection = document.getElementById('qr-payment-section');
        const codSection = document.getElementById('cod-info-section');
        const placeOrderSection = document.getElementById('place-order-section');

        if (method === 'qr') {
            qrSection.style.display = 'block';
            codSection.style.display = 'none';
            placeOrderSection.style.display = 'none';
            startVerification();
        } else {
            qrSection.style.display = 'none';
            codSection.style.display = 'block';
            placeOrderSection.style.display = 'block';
            stopVerification();
        }
    }

    // QR verification polling
    function startVerification() {
        if (verificationInterval) return;

        const statusElement = document.getElementById('payment-status');
        statusElement.innerHTML = `
            <div class="alert alert-info verifying rounded-3">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                កំពុងរង់ចាំការទូទាត់... សូមស្កែនលេខកូដ QR ។
            </div>
        `;

        verificationInterval = setInterval(() => {
            fetch("{{ route('verify.transaction') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ md5: "{{ $md5 }}" })
            })
            .then(response => response.json())
            .then(data => {
                if (data.responseCode === 0 || data.status === 'success' || data.paid === true) {
                    paymentVerified = true;
                    stopVerification();
                    statusElement.innerHTML = `
                        <div class="alert alert-success rounded-3">
                            <strong>✓ ការទូទាត់បានជោគជ័យ!</strong> កំពុងបង្កើតការបញ្ជាទិញរបស់អ្នក...
                        </div>
                    `;
                    setTimeout(() => {
                        document.getElementById('checkout-form').submit();
                    }, 1500);
                } else if (data.responseCode !== undefined && data.responseCode !== 0) {
                    // Keep waiting message (already shown)
                }
            })
            .catch(error => console.error('Verification error:', error));
        }, 3000);
    }

    function stopVerification() {
        if (verificationInterval) {
            clearInterval(verificationInterval);
            verificationInterval = null;
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        // Set default location based on old input
        const oldLocation = "{{ old('location_type') }}";
        if (oldLocation) {
            handleLocationChange(oldLocation);
        } else {
            // If no old location, hide both address sections
            document.getElementById('phnom-penh-fields').style.display = 'none';
            document.getElementById('province-fields').style.display = 'none';
        }

        // Set default payment method - hide button by default (QR selected)
        const paymentSelect = document.getElementById('payment_method');
        const selectedPayment = paymentSelect ? paymentSelect.value : 'qr';
        handlePaymentChange(selectedPayment);
    });

    // Form submission handling
    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', function(e) {
        const paymentMethod = document.getElementById('payment_method').value;

        // Prevent form submission if QR payment is selected but not verified
        if (paymentMethod === 'qr' && !paymentVerified) {
            e.preventDefault();
            const statusElement = document.getElementById('payment-status');
            statusElement.innerHTML = `
                <div class="alert alert-warning rounded-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    សូមស្កែន និងទូទាត់តាម QR មុននឹងបញ្ជាទិញ។
                </div>
            `;
            return false;
        }

        const btn = document.getElementById('submit-btn');
        // Only show processing state for COD payment
        if (btn && paymentMethod === 'cod') {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>កំពុងដំណើរការ...';
        }
    });
</script>
@endsection
