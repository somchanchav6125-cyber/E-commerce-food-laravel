@extends('layouts.app')

@section('title', 'ទំព័រដើម')

@push('styles')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --primary: #ff6b6b;
            --primary-dark: #fa5252;
            --secondary: #4ecdc4;
            --accent: #ffe169;
            --dark: #2d3436;
            --light: #f8f9fa;
            --gray: #6c757d;
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafbfc;
            color: var(--dark);
            scroll-behavior: smooth;
        }

        /* ========== HERO SECTION ========== */
        .hero-section {
            position: relative;
            background: linear-gradient(145deg, #4158D0, #C850C0, #FFCC70);
            background-size: 200% 200%;
            animation: gradientFlow 12s ease infinite;
            color: white;
            padding: 120px 0;
            margin-bottom: 70px;
            border-radius: 0 0 60px 60px;
            overflow: hidden;
            isolation: isolate;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.2" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.15;
            z-index: -1;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 700;
            line-height: 1.2;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeInDown 1s;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            opacity: 0.95;
            margin-bottom: 35px;
            animation: fadeInUp 1s 0.2s both;
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto;
            animation: fadeIn 1.5s 0.4s both;
        }

        .search-box .input-group {
            border-radius: 60px;
            overflow: hidden;
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .search-box input {
            border: none;
            padding: 18px 28px;
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.95);
        }

        .search-box button {
            background: var(--primary);
            border: none;
            padding: 0 40px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .search-box button:hover {
            background: var(--primary-dark);
            transform: scale(1.02);
        }

        /* ========== SECTION TITLES ========== */
        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--dark);
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 50px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
            transition: width 0.4s;
        }

        .section-title:hover::after {
            width: 150px;
        }

        /* ========== CATEGORY CARDS ========== */
        .category-card {
            border: none;
            border-radius: 30px;
            overflow: hidden;
            background: white;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-lg);
        }

        .category-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.8s;
        }

        .category-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .category-card .card-body {
            padding: 1.5rem 1rem;
            text-align: center;
            background: white;
            flex: 1;
        }

        .category-card .card-title {
            font-weight: 600;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .category-link {
            display: inline-block;
            padding: 8px 25px;
            background: linear-gradient(135deg, var(--primary), #ff8e8e);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
        }

        .category-link:hover {
            background: linear-gradient(135deg, var(--primary-dark), #ff6b6b);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(255, 107, 107, 0.5);
        }

        .admin-category-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            gap: 8px;
        }

        .category-card:hover .admin-category-actions {
            opacity: 1;
        }

        .btn-edit,
        .btn-delete {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: none;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-edit:hover,
        .btn-delete:hover {
            transform: scale(1.1);
        }

        /* ========== PRODUCT CARDS ========== */
        .product-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            background: white;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 5;
            background: var(--accent);
            color: var(--dark);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .product-card .card-img-top {
            height: 230px;
            object-fit: cover;
            transition: transform 0.8s;
        }

        .product-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .product-card .card-body {
            padding: 1.5rem;
            background: white;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card .card-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .product-card .card-text {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            flex: 1;
        }

        .product-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .product-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: auto;
        }

        .btn-detail {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
            flex: 1;
        }

        .btn-detail:hover {
            background: var(--primary);
            color: white;
        }

        .btn-buy {
            background: linear-gradient(145deg, var(--primary), #ff8e8e);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 8px 15px -5px rgba(255, 107, 107, 0.4);
            flex: 1;
            text-align: center;
            text-decoration: none;
        }

        .btn-buy:hover {
            background: linear-gradient(145deg, var(--primary-dark), #ff6b6b);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(255, 107, 107, 0.6);
            color: white;
        }

        .btn-buy:disabled,
        .btn-buy.disabled {
            opacity: 0.6;
            pointer-events: none;
            background: var(--gray);
            box-shadow: none;
        }

        .admin-product-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            gap: 8px;
        }

        .product-card:hover .admin-product-actions {
            opacity: 1;
        }

        /* Stock badge */
        .stock-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 5;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--dark);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .stock-badge.out {
            background: rgba(220, 53, 69, 0.9);
            color: white;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .product-actions {
                flex-direction: column;
            }

            .btn-detail,
            .btn-buy {
                width: 100%;
            }
        }

        /* ========== PAGINATION ========== */
        .pagination {
            gap: 8px;
        }

        .pagination .page-link {
            border: 2px solid #e5e7eb;
            color: var(--dark);
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            margin: 0 4px;
        }

        .pagination .page-link:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .pagination .active .page-link {
            background: linear-gradient(145deg, var(--primary), #ff8e8e);
            border-color: var(--primary);
            color: white;
        }

        .pagination .disabled .page-link {
            color: #9ca3af;
            background: #f3f4f6;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }

        .pagination .page-item:not(.disabled) .page-link {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    {{-- HERO SECTION --}}
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title animate__animated animate__fadeInDown">
                ស្វែងរកអាហារឆ្ងាញ់ៗ <br>នៅក្បែរអ្នក
            </h1>
            <p class="hero-subtitle animate__animated animate__fadeInUp">
                រកឃើញមុខម្ហូបថ្មីៗ និងការផ្តល់ជូនពិសេសប្រចាំថ្ងៃ
            </p>

            {{-- Search box --}}
            <div class="search-box animate__animated animate__fadeInUp animate__delay-1s">
                <form action="{{ route('home') }}" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ស្វែងរកម្ហូប ឬភោជនីយដ្ឋាន..." value="{{ request('search') }}">
                    <button class="btn" type="submit">
                        <i class="bi bi-search"></i> ស្វែងរក
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Search Results Section --}}
    @if($searchResults !== null)
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">
                    <i class="bi bi-search me-2"></i>លទ្ធផលស្វែងរក: "{{ request('search') }}"
                </h2>
                <a href="{{ route('home') }}" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-x-circle me-1"></i>សម្អាត
                </a>
            </div>

            @if($searchResults->count() > 0)
                <div class="row g-4">
                    @foreach($searchResults as $product)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-card">
                                <span class="product-badge"><i class="bi bi-search"></i> លទ្ធផល</span>

                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 230px;">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif

                                <span class="stock-badge {{ $product->stock <= 0 ? 'out' : '' }}">
                                    @auth
                                        @if ($product->stock > 0)
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                class="d-inline w-100">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn-buy w-100">
                                                    <i class="bi bi-cart-plus"></i> ទិញ
                                                </button>
                                            </form>
                                        @else
                                            <span class="btn-buy disabled w-100">
                                                <i class="bi bi-cart-x"></i> អស់ស្តុក
                                            </span>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn-buy w-100">
                                            <i class="bi bi-box-arrow-in-right"></i> ចូលដើម្បីទិញ
                                        </a>
                                    @endauth
                                </span>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 60) }}</p>
                                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown display-1 text-muted"></i>
                    <h3 class="mt-3">មិនមានលទ្ធផលស្វែងរក</h3>
                    <p class="text-muted">យើងរកមិនឃើញមុខម្ហូបដែលត្រូវនឹង "{{ request('search') }}" ទេ។</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 rounded-pill px-4">
                        <i class="bi bi-house-door me-1"></i>ត្រឡប់ទៅទំព័រដើម
                    </a>
                </div>
            @endif
        </div>
    @else

    <div class="container">
        {{-- CATEGORIES SECTION --}}
        <section class="mb-5">
            <h2 class="section-title">ប្រភេទអាហារ</h2>
            <div class="row g-4">
                @forelse($categories as $category)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="category-card">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top"
                                    alt="{{ $category->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif

                            {{-- Admin actions (សម្រាប់តែអ្នកគ្រប់គ្រង) --}}
                            @auth
                                @if (Auth::user()->role === 'admin' && isset($category) && $category instanceof \App\Models\Category)
                                    <div class="admin-category-actions">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-edit"
                                            title="កែប្រែ">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('តើអ្នកប្រាកដថាចង់លុបប្រភេទនេះ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" title="លុប">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <a href="{{ route('category.show', $category->id) }}" class="category-link">
                                    <i class="bi bi-eye"></i> មើលផលិតផល
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center py-4">
                            <i class="bi bi-info-circle fs-3"></i>
                            <p class="mb-0">មិនទាន់មានប្រភេទអាហារនៅឡើយទេ។</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- FEATURED PRODUCTS SECTION --}}
        <section class="mb-5">
            <h2 class="section-title">ផលិតផលពេញនិយម</h2>
            <div class="row g-4">
                @forelse($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-card">
                            {{-- Badge ពេញនិយម --}}
                            <span class="product-badge"><i class="bi bi-star-fill"></i> ពេញនិយម</span>

                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 230px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif

                            {{-- Stock status badge --}}
                            <span class="stock-badge {{ $product->stock <= 0 ? 'out' : '' }}">
                                @auth
                                    @if ($product->stock > 0 && isset($product->id))
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="d-inline w-100">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn-buy w-100">
                                                <i class="bi bi-cart-plus"></i> ទិញ
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn-buy disabled w-100">
                                            <i class="bi bi-cart-x"></i> អស់ស្តុក
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-buy w-100">
                                        <i class="bi bi-box-arrow-in-right"></i> ចូលដើម្បីទិញ
                                    </a>
                                @endauth
                            </span>

                            {{-- Admin actions --}}
                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <div class="admin-product-actions">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit"
                                            title="កែប្រែ">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('តើអ្នកប្រាកដថាចង់លុបផលិតផលនេះ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" title="លុប">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 60) }}</p>
                                <div class="product-price">${{ number_format($product->price, 2) }}</div>

                                <div class="product-actions">
                                    {{-- Detail button --}}
                                    @if ($product->slug)
                                        <a href="{{ route('product.show', $product) }}" class="btn-detail">
                                            លម្អិត
                                        </a>
                                    @else
                                        <span class="btn-detail disabled text-muted">
                                            លម្អិត
                                        </span>
                                    @endif

                                    {{-- Buy button --}}
                                    @auth
                                        @if ($product->stock > 0)
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                class="d-inline w-100">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn-buy w-100">
                                                    <i class="bi bi-cart-plus"></i> ទិញ
                                                </button>
                                            </form>
                                        @else
                                            <span class="btn-buy disabled w-100">
                                                <i class="bi bi-cart-x"></i> អស់ស្តុក
                                            </span>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn-buy w-100">
                                            <i class="bi bi-box-arrow-in-right"></i> ចូលដើម្បីទិញ
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center py-4">
                            <i class="bi bi-info-circle fs-3"></i>
                            <p class="mb-0">មិនទាន់មានផលិតផលនៅឡើយទេ។</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $featuredProducts->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart animation
            const buyButtons = document.querySelectorAll('.btn-buy');
            buyButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!this.classList.contains('disabled') && this.tagName === 'BUTTON') {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="bi bi-check2-circle"></i> បានបន្ថែម';
                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 1500);
                    }
                });
            });
        });
    </script>
@endpush
