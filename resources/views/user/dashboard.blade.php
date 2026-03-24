@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">សួស្តី {{ Auth::user()->name }}! 👋</h1>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">ការបញ្ជាទិញសរុប</h5>
                    <h2 class="mb-0">{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">កំពុងដំណើរការ</h5>
                    <h2 class="mb-0">{{ $processingOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">បានជោគជ័យ</h5>
                    <h2 class="mb-0">{{ $completedOrders }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📦 ការបញ្ជាទិញថ្មីៗ</h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->isEmpty())
                        <p class="text-muted text-center">អ្នកមិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ល.ដ</th>
                                        <th>ទឹកប្រាក់</th>
                                        <th>ស្ថានភាព</th>
                                        <th>កាលបរិច្ឆេទ</th>
                                        <th>សកម្មភាព</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                                មើលលម្អិត
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
