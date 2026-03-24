@extends('layouts.admin')

@section('title', 'គ្រប់គ្រងផលិតផល')

@push('styles')
<style>

.product-img{
    width:55px;
    height:55px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #f1f1f1;
}

/* Card */

.table-card{
    border-radius:14px;
    border:none;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

/* Table */

.table thead th{
    font-weight:600;
    color:#555;
}

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#f9fbff;
}

/* Action Button */

.action-btn{
    transition:all .2s ease;
}

.action-btn:hover{
    transform:scale(1.1);
}

/* Total Row */

.total-row{
    font-weight:600;
    background:#f8f9fa;
}

/* Pagination */

.pagination{
    gap:6px;
}

.pagination .page-link{
    border-radius:8px !important;
    border:none;
    padding:8px 14px;
    color:#555;
    background:#f1f3f5;
    transition:.2s;
}

.pagination .page-link:hover{
    background:#0d6efd;
    color:white;
}

.pagination .active .page-link{
    background:#0d6efd;
    color:white;
    font-weight:600;
}

</style>
@endpush


@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📦 គ្រប់គ្រងផលិតផល</h3>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> បន្ថែមផលិតផលថ្មី
        </a>
    </div>


    {{-- Card --}}
    <div class="card table-card">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm10-9a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3zM7 2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H7z"/>
                    </svg>
                    បញ្ជីផលិតផល
                </h5>
                <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="ស្វែងរកផលិតផល..." value="{{ request('search') }}" style="width: 250px;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        ស្វែងរក
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card-body p-0">

            {{-- Table --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>រូបភាព</th>
                            <th>ឈ្មោះ</th>
                            <th>ប្រភេទ</th>
                            <th>តម្លៃ</th>
                            <th>ស្តុក</th>
                            <th class="text-end">សកម្មភាព</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($products as $product)

                        <tr>

                            <td>{{ $product->id }}</td>

                            {{-- Image --}}
                            <td>

                                @if ($product->image)

                                    <img src="{{ asset('storage/'.$product->image) }}" class="product-img">

                                @else

                                    <span class="text-muted">គ្មានរូប</span>

                                @endif

                            </td>

                            {{-- Name --}}
                            <td class="fw-semibold">
                                {{ $product->name }}
                            </td>

                            {{-- Category --}}
                            <td>

                                <span class="badge bg-secondary">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>

                            </td>

                            {{-- Price --}}
                            <td class="text-success fw-bold">
                                ${{ number_format($product->price,2) }}
                            </td>

                            {{-- Stock --}}
                            <td>
                                {{ $product->stock }}
                            </td>


                            {{-- Action --}}
                            <td class="text-end">

                                <a href="{{ route('admin.products.edit',$product) }}"
                                   class="btn btn-sm btn-outline-primary action-btn me-1">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('admin.products.destroy',$product) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('តើអ្នកពិតជាចង់លុបផលិតផលនេះមែនទេ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger action-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center py-4">
                                មិនទាន់មានផលិតផលនៅឡើយទេ
                            </td>
                        </tr>

                        @endforelse


                        {{-- Total --}}
                        @if($products->count())

                        <tr class="total-row">

                            <td colspan="6" class="text-end">
                                ផលិតផលសរុប:
                            </td>

                            <td>
                                {{ $products->total() }}
                            </td>

                        </tr>

                        @endif

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">

                <div>
                    កំពុងបង្ហាញ {{ $products->count() }} ផលិតផលពីសរុប {{ $products->total() }}
                </div>

                <div>
                    {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>


        </div>

    </div>

</div>

@endsection
