<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - E-Food Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Khmer Font -->
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- ===== MODERN ADMIN STYLE ===== -->
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Battambang', 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        * {
            font-family: 'Battambang', 'Segoe UI', sans-serif;
        }

        /* Wrapper */
        #wrapper {
            transition: all .3s ease;
        }

        /* ================= SIDEBAR ================= */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a, #020617);
            transition: all .3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, .2);
        }

        #wrapper.toggled #sidebar {
            margin-left: -250px;
        }

        #sidebar h4 {
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* Menu */
        #sidebar .nav-link {
            color: #cbd5e1;
            border-radius: 10px;
            padding: 10px 14px;
            transition: .25s;
        }

        #sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
            transform: translateX(5px);
        }

        #sidebar .nav-link.active {
            background: linear-gradient(45deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
        }

        /* ================= NAVBAR ================= */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
        }

        /* ================= CONTENT ================= */
        #page-content-wrapper {
            transition: all .3s ease;
        }

        .container-fluid {
            animation: fadeIn .4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================= CARD STYLE ================= */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
        }

        /* ================= ALERT ================= */
        .alert {
            border-radius: 10px;
        }

        /* Toggle Button */
        #menu-toggle {
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .15);
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- ================= SIDEBAR ================= -->
        <div id="sidebar" class="text-white">
            <div class="p-3">

                <h4 class="text-center">🍔 E-Food Admin</h4>
                <hr class="bg-light">

                <ul class="nav nav-pills flex-column">

                    <li class="nav-item mb-2">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> ផ្ទាំងគ្រប់គ្រង
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.categories.index') }}"
                            class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags me-2"></i> ប្រភេទអាហារ
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.products.index') }}"
                            class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> ផលិតផល
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.orders.index') }}"
                            class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt me-2"></i> ការបញ្ជាទិញ
                        </a>
                    </li>

                    <!-- API JSON Links -->
                    <li class="nav-item mt-3">
                        <small class="text-white-50 px-3 text-uppercase fw-bold" style="font-size: 0.75rem;">API JSON</small>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('/api/products') }}" target="_blank"
                            class="nav-link text-info">
                            <i class="bi bi-json me-2"></i> Products JSON
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('/api/categories') }}" target="_blank"
                            class="nav-link text-info">
                            <i class="bi bi-json me-2"></i> Categories JSON
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('/api/admin/products?token=ABC123') }}" target="_blank"
                            class="nav-link text-info">
                            <i class="bi bi-json me-2"></i> Admin Products JSON
                        </a>
                    </li>

                    <li class="nav-item mt-4">
                        <a href="{{ route('home') }}" class="nav-link" target="_blank">
                            <i class="bi bi-house-door me-2"></i> មើលគេហទំព័រ
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> ចាកចេញ
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>

        <!-- ================= CONTENT ================= -->
        <div id="page-content-wrapper" class="flex-grow-1">

            <!-- Navbar -->
            <nav class="navbar border-bottom px-3">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>

                <span class="navbar-text fw-semibold">
                    👋 សួស្តី, {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
            </nav>

            <!-- Page -->
            <div class="container-fluid px-4 py-3">

                @if (session('success'))
                    <div class="alert alert-success shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </div>

    </div>

    <!-- ================= SCRIPTS ================= -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById("menu-toggle")
            .addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("wrapper")
                    .classList.toggle("toggled");
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @stack('scripts')

</body>

</html>
