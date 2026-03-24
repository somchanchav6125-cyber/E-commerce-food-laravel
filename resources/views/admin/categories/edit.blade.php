@extends('layouts.admin')

@section('title', 'កែប្រែប្រភេទ')

@push('styles')
<style>
    .form-wrapper {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    }
    .page-title { font-weight: 600; }
    .form-label { font-weight: 500; margin-bottom: 8px; }
    textarea { min-height: 120px; resize: vertical; }
    .top-bar .btn { border-radius: 8px; }
    .save-btn { min-width: 140px; border-radius: 8px; font-weight: 500; }
    img.preview { max-width: 100px; margin-bottom: 10px; border-radius: 8px; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 top-bar">
        <h3 class="page-title mb-0">កែប្រែប្រភេទ</h3>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← ត្រឡប់ក្រោយ</a>
    </div>

    <div class="form-wrapper">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Name --}}
                <div class="col-md-6">
                    <label class="form-label">ឈ្មោះផលិតផល</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $category->name) }}" required>
                </div>

                {{-- Parent Category --}}
                <div class="col-md-6">
                    <label class="form-label">ប្រភេទ</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- ជ្រើសរើសប្រភេទ --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Price --}}
                <div class="col-md-6">
                    <label class="form-label">តម្លៃ ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control"
                        value="{{ old('price', $category->price ?? '') }}" placeholder="5.99">
                </div>

                {{-- Stock --}}
                <div class="col-md-6">
                    <label class="form-label">ចំនួនស្តុក</label>
                    <input type="number" name="stock" class="form-control"
                        value="{{ old('stock', $category->stock ?? '') }}" placeholder="10">
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label">ការពិពណ៌នា</label>
                    <textarea name="description" class="form-control"
                        placeholder="បញ្ចូលការពិពណ៌នា...">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                {{-- Image --}}
                <div class="col-12">
                    <label class="form-label">រូបភាព (អាចមិនបញ្ចូលក៏បាន)</label>
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="preview">
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary save-btn">រក្សាទុកការកែប្រែ</button>
            </div>
        </form>
    </div>
</div>
@endsection
