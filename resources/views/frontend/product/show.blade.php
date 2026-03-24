@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
:root {
    --primary: #667eea;
    --primary-dark: #764ba2;
    --secondary: #4ecdc4;
    --accent: #ff6b6b;
    --dark: #2d3436;
    --light: #f8f9fa;
    --success: #10b981;
    --danger: #ef4444;
}

/* Container */
.product-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Poppins', sans-serif;
}

/* Breadcrumb */
.breadcrumb-custom {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
    flex-wrap: wrap;
}
.breadcrumb-custom a {
    color: #636e72;
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb-custom a:hover {
    color: var(--primary);
}
.breadcrumb-custom span {
    color: #b2bec3;
}
.breadcrumb-custom .current {
    color: var(--dark);
    font-weight: 600;
}

/* Back Button */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}
.btn-back:hover {
    background: var(--primary);
    color: white;
    transform: translateX(-5px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* Product Detail Card */
.product-detail-card {
    display: flex;
    flex-direction: column;
    background: white;
    border-radius: 2rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 3rem;
}
@media(min-width: 992px) {
    .product-detail-card {
        flex-direction: row;
    }
}

/* Product Image Section */
.product-image-section {
    flex: 1;
    background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}
.product-main-image {
    width: 100%;
    max-width: 500px;
    height: 450px;
    object-fit: cover;
    border-radius: 1.5rem;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    transition: transform 0.5s ease;
}
.product-main-image:hover {
    transform: scale(1.05);
}

/* Product Info Section */
.product-info-section {
    flex: 1;
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* Category Badge */
.product-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary);
    background: linear-gradient(135deg, #e0e7ff, #ede9fe);
    border-radius: 2rem;
    width: fit-content;
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.2);
}

/* Product Title */
.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
    line-height: 1.3;
}

/* Product Price */
.product-price-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.product-price {
    font-size: 2rem;
    font-weight: 800;
    color: var(--accent);
    background: linear-gradient(135deg, #ff6b6b, #ff8787);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Stock Status */
.stock-status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
}
.stock-in {
    background: #d1fae5;
    color: #059669;
}
.stock-out {
    background: #fee2e2;
    color: #dc2626;
}

/* Product Description */
.product-description-box {
    background: #f8f9fa;
    border-left: 4px solid var(--primary);
    padding: 1.5rem;
    border-radius: 0.5rem;
    color: #4b5563;
    line-height: 1.8;
    font-size: 0.95rem;
}
.product-description-box h4 {
    margin: 0 0 0.75rem 0;
    color: var(--dark);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Quantity Selector */
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.quantity-label {
    font-weight: 600;
    color: var(--dark);
}
.quantity-control {
    display: flex;
    align-items: center;
    border: 2px solid #e5e7eb;
    border-radius: 1rem;
    overflow: hidden;
}
.quantity-btn {
    width: 40px;
    height: 40px;
    background: #f9fafb;
    border: none;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    cursor: pointer;
    transition: all 0.2s;
}
.quantity-btn:hover {
    background: var(--primary);
    color: white;
}
.quantity-input {
    width: 60px;
    height: 40px;
    text-align: center;
    border: none;
    font-weight: 600;
    font-size: 1rem;
    color: var(--dark);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
}
@media(min-width: 640px) {
    .action-buttons {
        flex-direction: row;
    }
}
.btn-action {
    flex: 1;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 1rem;
    cursor: pointer;
    border: none;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.btn-cart {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}
.btn-cart:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    color: white;
}
.btn-wishlist {
    background: white;
    color: var(--danger);
    border: 2px solid var(--danger);
}
.btn-wishlist:hover {
    background: var(--danger);
    color: white;
    transform: translateY(-3px);
}

/* Related Products Section */
.related-products-section {
    margin-top: 3rem;
}
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}
.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.section-title i {
    color: var(--primary);
}
.view-all-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}
.view-all-link:hover {
    color: var(--primary-dark);
    gap: 0.75rem;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.5rem;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.product-card-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: #f8f9fa;
    transition: transform 0.3s;
}
.product-card:hover .product-card-image {
    transform: scale(1.1);
}

.product-card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-card-category {
    font-size: 0.75rem;
    color: var(--primary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.product-card-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    text-decoration: none;
    transition: color 0.2s;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-card-name:hover {
    color: var(--primary);
}

.product-card-description {
    font-size: 0.8rem;
    color: #6b7280;
    margin-bottom: 1rem;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.product-card-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--accent);
}

.btn-view-product {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}
.btn-view-product:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Empty State */
.empty-related {
    text-align: center;
    padding: 3rem 1rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}
.empty-related i {
    font-size: 3rem;
    color: #dfe6e9;
    margin-bottom: 1rem;
}
.empty-related h4 {
    color: var(--dark);
    margin-bottom: 0.5rem;
}
.empty-related p {
    color: #b2bec3;
}
</style>

<div class="product-container">
    {{-- Back Button --}}
    <a href="{{ route('home') }}" class="btn-back">
        <i class="bi bi-arrow-left-short"></i>
        <span>ត្រឡប់</span>
    </a>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">ទំព័រដើម</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('category.show', $product->category->id) }}">{{ $product->category->name }}</a>
            <span>/</span>
        @endif
        <span class="current">{{ $product->name }}</span>
    </div>

    {{-- Product Detail Card --}}
    <div class="product-detail-card">
        {{-- Product Image --}}
        <div class="product-image-section">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-main-image">
            @else
                <div class="product-main-image d-flex align-items-center justify-content-center bg-light">
                    <i class="bi bi-image" style="font-size: 5rem; color: #dfe6e9;"></i>
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="product-info-section">
            @if($product->category)
                <span class="product-category-badge">
                    <i class="bi bi-tag-fill"></i>
                    {{ $product->category->name }}
                </span>
            @endif

            <h1 class="product-title">{{ $product->name }}</h1>

            <div class="product-price-wrapper">
                <span class="product-price">${{ number_format($product->price, 2) }}</span>
            </div>

            @if(isset($product->stock))
                <div class="stock-status {{ $product->stock > 0 ? 'stock-in' : 'stock-out' }}">
                    @if($product->stock > 0)
                        <i class="bi bi-check-circle-fill"></i>
                        <span>មានក្នុងស្តុក ({{ $product->stock }})</span>
                    @else
                        <i class="bi bi-x-circle-fill"></i>
                        <span>អស់ស្តុក</span>
                    @endif
                </div>
            @endif

            <div class="product-description-box">
                <h4><i class="bi bi-info-circle-fill"></i> ការពិពណ៌នា</h4>
                <p style="margin: 0;">{{ $product->description ?? 'មិនទាន់មានការពិពណ៌នា។' }}</p>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="quantity-selector">
                    <span class="quantity-label">ចំនួន:</span>
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn" onclick="decreaseQty()">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-input">
                        <button type="button" class="quantity-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-action btn-cart">
                        <i class="bi bi-cart-plus-fill"></i>
                        <span>បន្ថែមទៅកន្ត្រក</span>
                    </button>
                    <button type="button" class="btn-action btn-wishlist">
                        <i class="bi bi-heart"></i>
                        <span>ចូលចិត្ត</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Related Products Section --}}
    @if($relatedProducts->count() > 0)
        <div class="related-products-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    ផលិតផលពាក់ព័ន្ធ
                </h2>
                <a href="{{ route('categories.index') }}" class="view-all-link">
                    <span>មើលទាំងអស់</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="products-grid">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="product-card">
                        @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="product-card-image">
                        @else
                            <div class="product-card-image d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-image" style="font-size: 3rem; color: #dfe6e9;"></i>
                            </div>
                        @endif

                        <div class="product-card-body">
                            @if($relatedProduct->category)
                                <span class="product-card-category">{{ $relatedProduct->category->name }}</span>
                            @endif

                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="product-card-name">
                                {{ $relatedProduct->name }}
                            </a>

                            @if($relatedProduct->description)
                                <p class="product-card-description">{{ Str::limit($relatedProduct->description, 60) }}</p>
                            @endif

                            <div class="product-card-footer">
                                <span class="product-card-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn-view-product">
                                    <i class="bi bi-eye"></i>
                                    <span>មើល</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="related-products-section">
            <div class="empty-related">
                <i class="bi bi-basket"></i>
                <h4>គ្មានផលិតផលពាក់ព័ន្ធ</h4>
                <p>មិនទាន់មានផលិតផលពាក់ព័ន្ធនៅឡើយទេ។</p>
            </div>
        </div>
    @endif
</div>

<script>
function increaseQty() {
    let qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
}
function decreaseQty() {
    let qty = document.getElementById('quantity');
    if(parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
}
</script>
@endsection
