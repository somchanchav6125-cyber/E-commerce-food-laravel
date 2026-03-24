<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::all();
        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display products in a category
     */
    public function show(Category $category)
    {
        $products = $category->products()->paginate(10);
        return view('frontend.categories.show', compact('category', 'products'));
    }
}
