<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Eager load category
        $product->load('category');

        // Get related products from the same category (excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(24)
            ->get();

        return view('frontend.product.show', compact('product', 'relatedProducts'));
    }
}
