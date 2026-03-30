@extends('layouts.app')

@section('title', 'ការបញ្ជាទិញរបស់ខ្ញុំ')

@section('content')
<h1 class="mb-4">ប្រវត្តិការបញ្ជាទិញរបស់ខ្ញុំ</h1>

@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>លេខកូដ</th>
                    <th>ថ្ងៃបញ្ជាទិញ</th>
                    <th>តម្លៃសរុប</th>
                    <th>ស្ថានភាព</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'completed' ? 'success' : 'danger')) }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> មើល
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
@else
    <div class="alert alert-info">
        អ្នកមិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។ <a href="{{ route('home') }}">បន្តការទិញទំនិញ</a>
    </div>
@endif
@endsection
