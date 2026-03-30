@extends('layouts.app')

@section('title', 'ប្រវត្តិរូប')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #667eea;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 15px 0 5px;
        }

        .profile-email {
            font-size: 1rem;
            opacity: 0.9;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .profile-card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-card-title i {
            color: #667eea;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
            margin-bottom: 15px;
        }

        .avatar-upload {
            position: relative;
            display: inline-block;
        }

        .avatar-upload input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .avatar-upload-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 10px;
            color: #667eea;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar-upload-label:hover {
            background: #f0f0ff;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f0f0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            margin-right: 15px;
        }

        .info-label {
            font-size: 0.9rem;
            color: #888;
            min-width: 100px;
        }

        .info-value {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: #764ba2;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px;
            }

            .profile-header {
                padding: 30px 20px;
                text-align: center;
            }

            .profile-avatar {
                margin: 0 auto 15px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="profile-container">
        <!-- Back Link -->
        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> ត្រឡប់ទៅទំព័រដើម
        </a>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="d-flex align-items-center">
                <div class="profile-avatar me-3">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-100 h-100 rounded-circle">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                </div>
                <div>
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <p class="profile-email">
                        <i class="bi bi-envelope me-1"></i> {{ $user->email }}
                    </p>
                    @if ($user->phonenumber)
                        <p class="profile-email mt-1">
                            <i class="bi bi-phone me-1"></i> {{ $user->phonenumber }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Information Form -->
        <div class="profile-card">
            <h2 class="profile-card-title">
                <i class="bi bi-person-lines-fill"></i>
                ព័ត៌មានផ្ទាល់ខ្លួន
            </h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <!-- Avatar Upload -->
                    <div class="col-md-4 text-center mb-4">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-preview">
                        @else
                            <div class="avatar-preview d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-person-circle fs-1 text-muted"></i>
                            </div>
                        @endif
                        <div class="avatar-upload">
                            <label class="avatar-upload-label">
                                <i class="bi bi-camera"></i> ផ្លាស់ប្តូររូប
                            </label>
                            <input type="file" name="avatar" accept="image/*" onchange="this.form.submit()">
                        </div>
                        @error('avatar')
                            <div class="text-danger mt-2 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Fields -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i> ឈ្មោះ
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i> អ៊ីមែល
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phonenumber" class="form-label">
                                <i class="bi bi-phone me-1"></i> លេខទូរស័ព្ទ
                            </label>
                            <input type="text"
                                   class="form-control @error('phonenumber') is-invalid @enderror"
                                   id="phonenumber"
                                   name="phonenumber"
                                   value="{{ old('phonenumber', $user->phonenumber) }}">
                            @error('phonenumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> រក្សាទុក
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-receipt me-1"></i> មើលប្រវត្តិការបញ្ជាទិញ
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="profile-card">
            <h2 class="profile-card-title">
                <i class="bi bi-lock-fill"></i>
                ផ្លាស់ប្តូរពាក្យសម្ងាត់
            </h2>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">
                        <i class="bi bi-key me-1"></i> ពាក្យសម្ងាត់បច្ចុប្បន្ន
                    </label>
                    <input type="password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password"
                           name="current_password"
                           required>
                    @error('current_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i> ពាក្យសម្ងាត់ថ្មី
                        </label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               minlength="8"
                               required>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i> បញ្ជាក់ពាក្យសម្ងាត់ថ្មី
                        </label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               minlength="8"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> ផ្លាស់ប្តូរពាក្យសម្ងាត់
                </button>
            </form>
        </div>

        <!-- Account Info Summary -->
        <div class="profile-card">
            <h2 class="profile-card-title">
                <i class="bi bi-info-circle"></i>
                ព័ត៌មានគណនី
            </h2>

            <div class="info-item">
                <div class="info-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="info-label">តួនាទី</div>
                <div class="info-value">
                    @if ($user->role === 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="info-label">ចុះឈ្មោះនៅ</div>
                <div class="info-value">
                    {{ $user->created_at->format('d/m/Y') }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="info-label">ចំនួនការបញ្ជាទិញ</div>
                <div class="info-value">
                    {{ $user->orders->count() }} លើក
                </div>
            </div>
        </div>
    </div>
@endsection
