<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Map category_id to parent_id
        $data['parent_id'] = $request->input('category_id');

        $data['slug'] = Str::slug($request->name);

        $slugExists = Category::where('slug', $data['slug'])->exists();
        if ($slugExists) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'បន្ថែមប្រភេទអាហារបានជោគជ័យ');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // ដើម្បី edit category នេះ
        $categories = Category::all();         // សម្រាប់ dropdown parent category
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name);

        // បើ slug ដដែលមានរួចហើយ លើកលែង record នេះ
        $slugExists = Category::where('slug', $data['slug'])
            ->where('id', '!=', $category->id)
            ->exists();

        if ($slugExists) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'ប្រភេទអាហារត្រូវបានកែប្រែដោយជោគជ័យ');
    }




    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
