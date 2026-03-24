<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        // យកផលិតផល ៨ ចុងក្រោយបង្អស់ដែលទើបបន្ថែម
        $query = Product::latest();

        // Search by name or description (case-insensitive for Khmer and English)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($search, 'UTF-8') . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . mb_strtolower($search, 'UTF-8') . '%']);
            });
            $searchResults = $query->get();
        } else {
            $searchResults = null;
        }

        $featuredProducts = Product::latest()->paginate(12);

        return view('frontend.home', compact('categories', 'featuredProducts', 'searchResults'));
    }
}
