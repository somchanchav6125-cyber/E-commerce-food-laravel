@php
    $cartCount = 0;
    if (auth()->check()) {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
    }
@endphp

<!-- Google Font Khmer Battambang -->
<link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Navbar font general */
    .navbar {
        font-family: 'Battambang', 'Segoe UI', Tahoma, Geneva, sans-serif;
    }

    /* Navbar brand */
    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: #4a4a4a;
        transition: color 0.3s;
    }

    .navbar-brand:hover {
        color: #7b5fff;
    }

    /* Nav links */
    .navbar-nav .nav-link {
        font-weight: 500;
        font-size: 1rem;
        color: #333333;
        transition: color 0.3s, transform 0.2s;
    }

    .navbar-nav .nav-link:hover {
        color: #7b5fff;
        transform: scale(1.05);
    }

    .navbar-nav .nav-link.active {
        color: #7b5fff;
        font-weight: 600;
    }

    /* Cart badge */
    .badge {
        font-family: 'Battambang', sans-serif;
        font-weight: 600;
    }

    /* Dropdown menu font */
    .dropdown-menu {
        font-family: 'Battambang', sans-serif;
        font-size: 0.95rem;
    }

    /* Icons spacing */
    .nav-link i {
        vertical-align: middle;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop text-secondary me-2"></i> E-Food
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>ទំព័រដើម
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">
                        <i class="bi bi-grid me-1"></i>មុខម្ហូប
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i>ទំនាក់ទំនង
                    </a>
                </li>

                @auth
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart fs-5"></i> កន្ត្រក
                            @if ($cartCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- User dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>ប្រវត្តិរូប
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-receipt me-2"></i>ការបញ្ជាទិញរបស់ខ្ញុំ
                                </a>
                            </li>
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-shield-lock me-2"></i>ផ្ទាំងគ្រប់គ្រង (Admin)
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>ចាកចេញ
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Guest links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>ចូលប្រើ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>ចុះឈ្មោះ
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
