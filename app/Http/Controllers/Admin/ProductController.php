<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search by product name
                $q->where('name', 'like', "%{$search}%")
                  // Search by description
                  ->orWhere('description', 'like', "%{$search}%")
                  // Search by price
                  ->orWhere('price', 'like', "%{$search}%")
                  // Search by category
                  ->orWhereHas('category', function($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->get();
        $total = $products->count();

        // Return JSON for API requests
        if ($request->wantsJson()) {
            return response()->json([
                'products' => $products,
                'total' => $total
            ]);
        }

        return view('admin.products.index', compact('products', 'total'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $slug = Str::slug($request->name);
        $data['slug'] = $slug ?: 'product-'.uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Return JSON for API requests
        if ($request->wantsJson()) {
            return response()->json($product, 201);
        }

        return redirect()->route('admin.products.index')
               ->with('success', 'ផលិតផលត្រូវបានបង្កើតដោយជោគជ័យ');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $slug = Str::slug($request->name);
        $data['slug'] = $slug ?: 'product-'.uniqid();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Return JSON for API requests
        if ($request->wantsJson()) {
            return response()->json($product);
        }

        return redirect()->route('admin.products.index')
               ->with('success', 'ផលិតផលត្រូវបានកែប្រែដោយជោគជ័យ');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->count() > 0) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'មិនអាចលុបផលិតផលដែលមានក្នុងការបញ្ជាទិញបានទេ'], 422);
            }
            return back()->with('error', 'មិនអាចលុបផលិតផលដែលមានក្នុងការបញ្ជាទិញបានទេ');
        }

        $product->carts()->delete();
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json(['message' => 'ផលិតផលត្រូវបានលុបដោយជោគជ័យ']);
        }

        return redirect()->route('admin.products.index')
               ->with('success', 'ផលិតផលត្រូវបានលុបដោយជោគជ័យ');
    }

    public function show(Product $product)
    {
        $product->load('category', 'orderItems', 'carts');

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json($product);
        }

        return view('admin.products.show', compact('product'));
    }
}
