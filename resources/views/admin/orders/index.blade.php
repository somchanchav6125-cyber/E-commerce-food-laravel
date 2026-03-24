@extends('layouts.admin')

@section('title', 'គ្រប់គ្រងការបញ្ជាទិញ')

@section('content')
<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="me-2 text-primary" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        ការបញ្ជាទិញ
                    </h2>
                    <p class="text-muted mb-0">គ្រប់គ្រងការបញ្ជាទិញទាំងអស់</p>
                </div>
                <div class="text-end">
                    <h4 class="text-primary mb-0">{{ $orders->total() }}</h4>
                    <small class="text-muted">សរុប</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-warning">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">កំពុងរង់ចាំ</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" opacity="0.5" viewBox="0 0 16 16">
                            <path d="M8 16A2 2 0 0 0 10 14v-2a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2H8zm6-6a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2zm-6 0a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2zm-6 0a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-info">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">កំពុងដំណើរការ</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'processing')->count() }}</h3>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" opacity="0.5" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-success">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">បញ្ចប់</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'completed')->count() }}</h3>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" opacity="0.5" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-danger">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">បោះបង់</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'cancelled')->count() }}</h3>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" opacity="0.5" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v10z"/>
                    </svg>
                    បញ្ជីការបញ្ជាទិញ
                </h5>
                <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="ស្វែងរក..." value="{{ request('search') }}" style="width: 250px;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        ស្វែងរក
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">លេខកូដ</th>
                            <th class="border-0 py-3 px-4">អតិថិជន</th>
                            <th class="border-0 py-3 px-4">ថ្ងៃបញ្ជាទិញ</th>
                            <th class="border-0 py-3 px-4">សរុប</th>
                            <th class="border-0 py-3 px-4">ស្ថានភាព</th>
                            <th class="border-0 py-3 px-4">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <span class="fw-bold text-primary">#{{ $order->id }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <div class="fw-medium">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="fw-bold text-success">${{ number_format($order->total, 2) }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-white',
                                        'completed' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white'
                                    ];
                                    $statusText = [
                                        'pending' => 'កំពុងរង់ចាំ',
                                        'processing' => 'កំពុងដំណើរការ',
                                        'completed' => 'បញ្ចប់',
                                        'cancelled' => 'បោះបង់'
                                    ];
                                    $statusIcons = [
                                        'pending' => '⏳',
                                        'processing' => '🔄',
                                        'completed' => '✅',
                                        'cancelled' => '❌'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }} px-3 py-2">
                                    {{ $statusIcons[$order->status] ?? '' }} {{ $statusText[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                    មើល
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted mb-3" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <p class="text-muted">មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer">
            <div class="pagination-wrapper">
                @include('vendor.pagination.custom', ['paginator' => $orders])
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* ===== CSS Variables ===== */
:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --primary-light: #eef2ff;
    --success: #10b981;
    --success-light: #d1fae5;
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --danger: #ef4444;
    --danger-light: #fee2e2;
    --info: #3b82f6;
    --info-light: #dbeafe;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --radius: 12px;
    --radius-sm: 8px;
}

/* Pagination Styles */
.pagination-wrapper {
    padding: 20px 24px;
    background: linear-gradient(180deg, var(--gray-50) 0%, white 100%);
    border-top: 1px solid var(--gray-200);
}

.pagination-wrapper nav {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.pagination-wrapper small {
    display: block;
    text-align: center;
    color: var(--gray-500);
    font-size: 13px;
    font-weight: 500;
    background: var(--gray-100);
    padding: 8px 16px;
    border-radius: var(--radius-sm);
}

.pagination-wrapper .pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-wrapper .page-item {
    display: inline-block;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 44px;
    height: 44px;
    padding: 0 14px;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius);
    color: var(--gray-600);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.pagination-wrapper .page-link:hover {
    background: var(--primary-light);
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(79, 70, 229, 0.2);
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-color: var(--primary);
    color: white;
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    transform: translateY(-3px);
}

.pagination-wrapper .page-item.disabled .page-link {
    background: var(--gray-100);
    border-color: var(--gray-200);
    color: var(--gray-400);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.pagination-wrapper .page-link svg {
    transition: transform 0.3s ease;
}

.pagination-wrapper .page-link:hover svg {
    transform: translateX(-3px);
}

.pagination-wrapper .page-link[rel="next"]:hover svg {
    transform: translateX(3px);
}

.pagination-wrapper .page-link.dots {
    cursor: default;
    border-color: transparent;
    background: transparent;
    color: var(--gray-400);
    font-weight: 700;
    letter-spacing: 2px;
}

.pagination-wrapper .page-link.dots:hover {
    transform: none;
    box-shadow: none;
    background: transparent;
    border-color: transparent;
    color: var(--gray-400);
}

@media (max-width: 768px) {
    .pagination-wrapper .page-link {
        min-width: 40px;
        height: 40px;
        font-size: 13px;
        padding: 0 10px;
    }

    .pagination-wrapper .pagination {
        gap: 4px;
    }

    .pagination-wrapper small {
        font-size: 12px;
        padding: 6px 12px;
    }

    .pagination-wrapper .page-link span:not(.page-link svg) {
        display: none;
    }

    .pagination-wrapper .page-link svg {
        margin: 0;
    }
}
</style>
@endsection
