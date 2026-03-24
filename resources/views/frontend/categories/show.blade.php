@extends('layouts.app')

@section('title', $category->name)

@section('content')
<style>
    /* Category Header */
    .category-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    .category-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .category-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }
    .category-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        background: white;
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f8f9fa;
    }

    .product-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 0.5rem;
        text-decoration: none;
        transition: color 0.2s;
    }
    .product-name:hover {
        color: #667eea;
    }

    .product-description {
        font-size: 0.875rem;
        color: #636e72;
        margin-bottom: 1rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #667eea;
    }

    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-view:hover {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .empty-state i {
        font-size: 4rem;
        color: #dfe6e9;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        color: #636e72;
        margin-bottom: 0.5rem;
    }
    .empty-state p {
        color: #b2bec3;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }
    .breadcrumb-custom a {
        color: #636e72;
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-custom a:hover {
        color: #667eea;
    }
    .breadcrumb-custom span {
        color: #b2bec3;
    }
    .breadcrumb-custom .current {
        color: #2d3436;
        font-weight: 600;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 0.6rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    .btn-back:hover {
        background: #667eea;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }
    .page-item .page-link {
        border: none;
        color: #667eea;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .page-item:not(.active) .page-link:hover {
        background: #f8f9fa;
        color: #764ba2;
    }
</style>

<div class="container">
    {{-- Back Button --}}
    <a href="{{ route('home') }}" class="btn-back">
        <i class="bi bi-arrow-left-short"></i>
        <span>ត្រឡប់</span>
    </a>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">ទំព័រដើម</a>
        <span>/</span>
        <a href="{{ route('categories.index') }}">ប្រភេទ</a>
        <span>/</span>
        <span class="current">{{ $category->name }}</span>
    </div>

    {{-- Category Header --}}
    <div class="category-header">
        <div class="d-flex align-items-center gap-3">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
            @else
                <div class="category-image d-flex align-items-center justify-content-center bg-white text-primary">
                    <i class="bi bi-grid-3x3-gap-fill" style="font-size: 1.5rem;"></i>
                </div>
            @endif
            <div>
                <h1>{{ $category->name }}</h1>
                @if($category->description)
                    <p>{{ $category->description }}</p>
                @else
                    <p>ប្រភេទផលិតផលចំនួន {{ $products->total() }} មុខ</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Products Section --}}
    @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-image d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-image" style="font-size: 3rem; color: #dfe6e9;"></i>
                        </div>
                    @endif

                    <div class="product-body">
                        <a href="{{ route('product.show', $product->slug) }}" class="product-name">
                            {{ $product->name }}
                        </a>

                        @if($product->description)
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        @endif

                        <div class="product-footer">
                            <span class="product-price">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn-view">
                                <i class="bi bi-eye me-1"></i>មើល
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="empty-state">
            <i class="bi bi-basket"></i>
            <h3>គ្មានផលិតផលនៅឡើយ</h3>
            <p>ប្រភេទ {{ $category->name }} មិនទាន់មានផលិតផលណាមួយនៅឡើយទេ។</p>
            <a href="{{ route('categories.index') }}" class="btn-view mt-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i>ត្រឡប់
            </a>
        </div>
    @endif
</div>
@endsection
