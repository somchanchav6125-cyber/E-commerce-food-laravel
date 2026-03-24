@extends('layouts.admin')

@section('title', 'បន្ថែមផលិតផលថ្មី')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .custom-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        border: none;
    }

    .custom-card .card-body {
        padding: 24px;
    }

    .form-label {
        font-weight: 500;
        color: #111827;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        min-height: 46px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-back {
        border-radius: 8px;
        padding: 8px 16px;
    }

    .btn-save {
        border-radius: 8px;
        padding: 10px 28px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <div class="page-header">
        <h2 class="page-title">បន្ថែមផលិតផលថ្មី</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>

    <div class="card custom-card">
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- ឈ្មោះ --}}
                    <div class="col-md-6">
                        <label class="form-label">ឈ្មោះផលិតផល</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ប្រភេទអាហារ --}}
                    <div class="col-md-6">
                        <label class="form-label">ប្រភេទអាហារ</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">ជ្រើសរើសប្រភេទ...</option>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- តម្លៃ --}}
                    <div class="col-md-6">
                        <label class="form-label">តម្លៃ ($)</label>
                        <input type="number" step="0.01" name="price"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ស្តុក --}}
                    <div class="col-md-6">
                        <label class="form-label">ចំនួនក្នុងស្តុក</label>
                        <input type="number" name="stock"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', 1) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ការពិពណ៌នា --}}
                    <div class="col-12">
                        <label class="form-label">ការពិពណ៌នា</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- រូបភាព --}}
                    <div class="col-12">
                        <label class="form-label">រូបភាពផលិតផល</label>
                        <input type="file" name="image"
                               class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ប៊ូតុង --}}
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary btn-save">រក្សាទុក</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
