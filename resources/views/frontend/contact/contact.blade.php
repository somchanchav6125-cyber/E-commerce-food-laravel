@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark">ទំនាក់ទំនងមកកាន់យើង</h1>
        <p class="text-secondary">មានសំណួរ ឬមតិយោបល់? សូមទាក់ទងមកយើងខ្ញុំ</p>
    </div>

    <div class="row g-5">
        {{-- Contact Information --}}
        <div class="col-md-5 col-lg-4">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h5 class="fw-semibold mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>ព័ត៌មានទំនាក់ទំនង</h5>
                <ul class="list-unstyled">
                    <li class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <span>អាសយដ្ឋាន: ផ្លូវ ៣០៨, ភ្នំពេញ, កម្ពុជា</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                        <span>ទូរស័ព្ទ: +855 973969572</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                        <span>អ៊ីមែល: contact@efood-kh.com</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-clock-fill text-primary me-3 fs-5"></i>
                        <span>ម៉ោងបើក: ម៉ោង ៩:០០ ព្រឹក ដល់ ១០:០០ យប់</span>
                    </li>
                </ul>

                <hr class="my-4">

                <h6 class="fw-semibold mb-3">តាមដានយើង</h6>
                <div class="d-flex gap-3">
                    <a href="https://www.facebook.com/share/1C9hGSwMbp/?mibextid=wwXIfr" class="text-dark fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="https://t.me/som_chanchav" class="text-dark fs-5"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="text-dark fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@somchachav?_r=1&_t=ZS-94qFiDsqwMv" class="text-dark fs-5"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="col-md-7 col-lg-8">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h5 class="fw-semibold mb-4"><i class="bi bi-envelope-paper me-2 text-primary"></i>ផ្ញើសារមកយើង</h5>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">ឈ្មោះ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">អ៊ីមែល <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">ប្រធានបទ</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">សារ <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2"><i class="bi bi-send me-2"></i>ផ្ញើសារ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Google Map (Optional) --}}
    <div class="mt-5">
        <div class="ratio ratio-21x9 rounded-4 overflow-hidden shadow-sm">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31276.241649699256!2d104.885756!3d11.556374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6be3%3A0x9c014eea65a3a3e1!2sPhnom%20Penh!5e0!3m2!1sen!2skh!4v1234567890" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
@endsection
