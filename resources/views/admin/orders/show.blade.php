@extends('layouts.admin')

@section('title', 'ព័ត៌មានលម្អិតនៃការបញ្ជាទិញ #'.$order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>ការបញ្ជាទិញ #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ត្រឡប់ក្រោយ
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5>ព័ត៌មានអតិថិជន</h5>
            </div>
            <div class="card-body">
                <p><strong>ឈ្មោះ:</strong> {{ $order->user->name }}</p>
                <p><strong>អ៊ីមែល:</strong> {{ $order->user->email }}</p>
                <p><strong>ទូរស័ព្ទ:</strong> {{ $order->user->phone ?? 'មិនមាន' }}</p>
                <p><strong>អាសយដ្ឋានដឹកជញ្ជូន:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5>ព័ត៌មានការបញ្ជាទិញ</h5>
            </div>
            <div class="card-body">
                <p><strong>ថ្ងៃបញ្ជាទិញ:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>វិធីបង់ប្រាក់:</strong>
                    @if($order->payment_method == 'cash_on_delivery')
                        បង់ប្រាក់ពេលទទួល
                    @else
                        {{ $order->payment_method }}
                    @endif
                </p>
                <p><strong>ស្ថានភាពបច្ចុប្បន្ន:</strong>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'completed' ? 'success' : 'danger')) }}">
                        {{ $order->status }}
                    </span>
                </p>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <div class="input-group">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>កំពុងរង់ចាំ</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>កំពុងដំណើរការ</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>បញ្ចប់</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>បោះបង់</option>
                        </select>
                        <button type="submit" class="btn btn-primary">ធ្វើបច្ចុប្បន្នភាព</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>បញ្ជីផលិតផលដែលបានបញ្ជាទិញ</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>រូបភាព</th>
                    <th>ផលិតផល</th>
                    <th>តម្លៃ</th>
                    <th>បរិមាណ</th>
                    <th>សរុប</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" width="50">
                        @endif
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">សរុបទាំងអស់:</th>
                    <th>${{ number_format($order->total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
