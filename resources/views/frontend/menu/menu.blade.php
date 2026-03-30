@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header with animated gradient underline --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark position-relative d-inline-block">
            មុខម្ហូបរបស់យើង
            <span class="header-underline"></span>
        </h1>
        <p class="text-secondary mt-3">រកមើលមុខម្ហូបឆ្ងាញ់ៗ និងបញ្ជាទិញតាមអនឡាញ</p>
    </div>

    {{-- Search and Sort Form --}}
    <form action="{{ route('menu') }}" method="GET" class="row g-3 mb-4 align-items-center justify-content-center">
        {{-- Search Input --}}
        <div class="col-auto">
            <div class="input-group search-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="ស្វែងរកមុខម្ហូប..." value="{{ request('search') }}">
            </div>
        </div>
        {{-- Submit Button --}}
        <div class="col-auto">
            <button type="submit" class="btn btn-primary filter-submit">
                <i class="bi bi-funnel me-1"></i> ស្វែងរក
            </button>
        </div>
    </form>

    {{-- Category Filter Buttons --}}
    <div class="category-filter-wrapper mb-4">
        <p class="text-muted fw-semibold mb-3">
            <i class="bi bi-grid-3x3-gap me-2"></i>ប្រភេទមុខម្ហូប
        </p>
        <div class="category-buttons d-flex flex-wrap gap-2">
            {{-- All Categories Button --}}
            <a href="{{ route('menu', array_merge(request()->except('category'), ['page' => null])) }}"
               class="category-btn {{ !request('category') ? 'active' : '' }}">
                <i class="bi bi-collection me-1"></i>ទាំងអស់
            </a>
            {{-- Individual Category Buttons --}}
            @foreach($categories as $category)
                @php
                    $icons = ['fire', 'cup-hot', 'egg', 'cookie', 'star', 'heart', 'flower', 'leaf'];
                    $icon = $icons[$loop->index % count($icons)];
                @endphp
                <a href="{{ route('menu', array_merge(request()->except('category'), ['category' => $category->id, 'page' => null])) }}"
                   class="category-btn {{ request('category') == $category->id ? 'active' : '' }}">
                    <i class="bi bi-{{ $icon }} me-1"></i>{{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="row g-4">
        @forelse ($foods as $food)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm food-card">
                    {{-- Product Image --}}
                    @if($food->image_url)
                        <div class="card-img-wrapper">
                            <img src="{{ $food->image_url }}" class="card-img-top" alt="{{ $food->name }}">
                            <div class="card-img-overlay-hover">
                                <span class="badge badge-price">${{ number_format($food->price, 2) }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        {{-- Category Badge --}}
                        @if($food->category)
                            <span class="badge badge-gradient mb-2 align-self-start">{{ $food->category->name }}</span>
                        @endif
                        {{-- Product Name --}}
                        <h5 class="card-title fw-bold text-dark">{{ $food->name }}</h5>
                        {{-- Product Description --}}
                        <p class="card-text text-secondary small flex-grow-1">
                            {{ Str::limit($food->description, 80) }}
                        </p>
                        {{-- Price and Add to Cart --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-primary price-display">${{ number_format($food->price, 2) }}</span>
                            @auth
                                <form action="{{ route('cart.add', $food) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-outline-primary btn-sm cart-btn">
                                        <i class="bi bi-cart-plus me-1"></i> បញ្ចូលកន្ត្រក
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm cart-btn">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> ចូលដើម្បីបញ្ជា
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State with Animation --}}
            <div class="col-12">
                <div class="text-center py-5 empty-state">
                    <img src="https://www.svgrepo.com/show/493678/search-and-magnifying-glass.svg" alt="No food found" class="mb-4 empty-state-img">
                    <h3 class="fw-bold">រកមិនឃើញមុខម្ហូបទេ</h3>
                    <p class="text-secondary">យើងរកមិនឃើញមុខម្ហូបដែលត្រូវនឹងការស្វែងរករបស់អ្នកទេ។</p>
                    <a href="{{ route('menu') }}" class="btn btn-primary mt-3 clear-filter-btn">សម្អាតតម្រង</a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    @if($foods->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $foods->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('styles')
<style>

    /* ===== CSS Variables ===== */
    :root {
        --primary: #0d6efd;
        --primary-dark: #0b5ed7;
        --secondary: #6610f2;
        --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
        --gradient-hover: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        --shadow-sm: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        --shadow-md: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 1rem 2rem rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Global Styles ===== */
    body {
        background: #f8fafc;
        font-family: 'Battambang', 'Inter', system-ui, sans-serif;
    }

    /* ===== Header Underline Animation ===== */
    .header-underline {
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient);
        border-radius: 4px;
        transform: scaleX(0);
        transform-origin: left;
        animation: slideIn 0.5s ease forwards;
    }

    @keyframes slideIn {
        to {
            transform: scaleX(1);
        }
    }

    /* ===== Search & Filter Group ===== */
    .search-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        min-width: 350px;
    }
    .search-group:hover {
        box-shadow: var(--shadow-md);
    }
    .search-group .input-group-text {
        border: 1px solid #e2e8f0;
        border-right: none;
        background: white;
        border-radius: 50px 0 0 50px;
        color: var(--primary);
    }
    .search-group .form-control {
        border: 1px solid #e2e8f0;
        border-left: none;
        border-radius: 0 50px 50px 0;
        padding-left: 0;
        transition: var(--transition);
    }
    .search-group .form-control:focus {
        border-color: var(--primary);
        box-shadow: none;
        outline: none;
    }

    .filter-select {
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        background-color: white;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .filter-submit {
        border-radius: 50px;
        background: var(--gradient);
        border: none;
        padding: 0.5rem 1rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .filter-submit:hover {
        transform: translateY(-2px);
        background: var(--gradient-hover);
        box-shadow: var(--shadow-md);
    }

    /* ===== Category Filter Buttons ===== */
    .category-filter-wrapper {
        animation: fadeInUp 0.5s ease;
    }
    .category-buttons {
        gap: 0.75rem;
    }
    .category-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.6rem 1.2rem;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        color: #4a5568;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .category-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .category-btn.active {
        background: var(--gradient);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
    .category-btn i {
        font-size: 1rem;
    }

    /* ===== Food Card ===== */
    .food-card {
        border-radius: 20px;
        overflow: hidden;
        background: white;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .food-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-lg);
    }

    .card-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .food-card:hover .card-img-top {
        transform: scale(1.05);
    }
    .card-img-overlay-hover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        padding: 1rem;
    }
    .food-card:hover .card-img-overlay-hover {
        opacity: 1;
    }
    .badge-price {
        background: rgba(255,255,255,0.9);
        color: var(--primary);
        font-size: 1rem;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 30px;
        backdrop-filter: blur(4px);
    }

    .badge-gradient {
        background: var(--gradient);
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.4em 0.8em;
        border-radius: 30px;
        letter-spacing: 0.5px;
    }

    .card-title {
        font-size: 1.2rem;
        margin-top: 0.5rem;
        transition: color 0.3s;
    }
    .food-card:hover .card-title {
        color: var(--primary) !important;
    }

    .card-text {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .price-display {
        font-weight: 700;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-size: 1.25rem;
    }

    .cart-btn {
        border-radius: 30px;
        border-width: 2px;
        padding: 0.4rem 1rem;
        transition: var(--transition);
        font-weight: 500;
    }
    .cart-btn:hover {
        background: var(--gradient);
        border-color: transparent;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
    }

    /* ===== Pagination ===== */
    .pagination {
        gap: 0.5rem;
    }
    .page-link {
        border: none;
        border-radius: 50% !important;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2f6;
        color: #4a5568;
        transition: var(--transition);
        font-weight: 500;
    }
    .page-link:hover {
        background: var(--gradient);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 12px rgba(13, 110, 253, 0.3);
    }
    .page-item.active .page-link {
        background: var(--gradient);
        color: white;
        box-shadow: 0 5px 12px rgba(13, 110, 253, 0.3);
    }
    .page-item.disabled .page-link {
        background: #eef2f6;
        color: #adb5bd;
        transform: none;
        box-shadow: none;
    }

    /* ===== Empty State ===== */
    .empty-state {
        animation: fadeInUp 0.6s ease;
    }
    .empty-state-img {
        max-width: 180px;
        opacity: 0.7;
        transition: transform 0.3s;
    }
    .empty-state:hover .empty-state-img {
        transform: scale(1.05);
    }
    .clear-filter-btn {
        border-radius: 50px;
        background: var(--gradient);
        border: none;
        padding: 0.6rem 1.5rem;
        transition: var(--transition);
    }
    .clear-filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===== Animations ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Staggered animation for cards */
    .col-md-4.col-lg-3 {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    .col-md-4.col-lg-3:nth-child(1) { animation-delay: 0.05s; }
    .col-md-4.col-lg-3:nth-child(2) { animation-delay: 0.1s; }
    .col-md-4.col-lg-3:nth-child(3) { animation-delay: 0.15s; }
    .col-md-4.col-lg-3:nth-child(4) { animation-delay: 0.2s; }
    .col-md-4.col-lg-3:nth-child(5) { animation-delay: 0.25s; }
    .col-md-4.col-lg-3:nth-child(6) { animation-delay: 0.3s; }
    .col-md-4.col-lg-3:nth-child(7) { animation-delay: 0.35s; }
    .col-md-4.col-lg-3:nth-child(8) { animation-delay: 0.4s; }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 768px) {
        .filter-submit {
            width: 100%;
        }
        .food-card:hover {
            transform: translateY(-4px);
        }
        .page-link {
            width: 35px;
            height: 35px;
        }
    }

    /* ===== Custom Scrollbar ===== */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--gradient);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--secondary);
    }
</style>
@endpush
@endsection
