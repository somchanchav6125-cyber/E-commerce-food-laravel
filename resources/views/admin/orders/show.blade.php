@extends('layouts.admin')

@section('title', 'ព័ត៌មានលម្អិតនៃការបញ្ជាទិញ #'.$order->id)

@section('content')
<style>
    .info-card .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .info-table td {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-table tr:last-child td {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        width: 150px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cart-check me-2"></i>ការបញ្ជាទិញ #{{ $order->id }}</h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>ត្រឡប់ក្រោយ
    </a>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card info-card">
            <div class="card-header">
                <i class="bi bi-person-circle me-2"></i>ព័ត៌មានអតិថិជន
            </div>
            <div class="card-body">
                <table class="table info-table mb-0">
                    <tr>
                        <td class="info-label">👤 ឈ្មោះ:</td>
                        <td>{{ $order->shipping_name ?? $order->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">📧 អ៊ីមែល:</td>
                        <td>{{ $order->shipping_email ?? $order->user->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">📱 លេខទូរស័ព្ទ:</td>
                        <td>{{ $order->shipping_phone ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card info-card mt-3">
            <div class="card-header">
                <i class="bi bi-gear-fill me-2"></i>ធ្វើបច្ចុប្បន្នភាពស្ថានភាព
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">ស្ថានភាព:</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>កំពុងរង់ចាំ</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>កំពុងដំណើរការ</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>បញ្ចប់</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>បោះបង់</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>ធ្វើបច្ចុប្បន្នភាព
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card info-card">
            <div class="card-header">
                <i class="bi bi-bag-check me-2"></i>ព័ត៌មានវិក្កយបត្រ
            </div>
            <div class="card-body">
                <table class="table info-table mb-0">
                    <tr>
                        <td class="info-label">🛒 លេខកូដ:</td>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">💰 សរុប:</td>
                        <td><strong class="text-primary">${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="info-label">💳 វិធីទូទាត់:</td>
                        <td>
                            @if($order->payment_method == 'cash_on_delivery')
                                <span class="badge bg-info">បង់ប្រាក់ពេលទទួល</span>
                            @elseif($order->payment_method == 'qr')
                                <span class="badge bg-info">បង់តាម QR Code</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->payment_method }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">✅ ស្ថានភាពទូទាត់:</td>
                        <td>
                            @if($order->payment_status == 'paid' || $order->paid == true)
                                <span class="badge bg-success">បានទូទាត់</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning">កំពុងរង់ចាំ</span>
                            @elseif($order->payment_status == 'failed' || $order->payment_status == 'cancelled')
                                <span class="badge bg-danger">បរាជ័យ</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->payment_status ?? 'មិនកំណត់' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">📍 អាសយដ្ឋាន:</td>
                        <td>
                            @if($order->location_type == 'phnom_penh')
                                {{ $order->house_number ?? '' }}
                                {{ $order->street ? 'ផ្លូវ ' . $order->street : '' }}
                                {{ $order->village ? 'ភូមិ ' . $order->village : '' }}
                                {{ $order->district ? 'ខណ្ឌ ' . $order->district : '' }}
                                {{ $order->city ?? '' }}
                            @elseif($order->location_type == 'province')
                                {{ $order->house_number ?? '' }}
                                {{ $order->street ? 'ផ្លូវ ' . $order->street : '' }}
                                {{ $order->village ? 'ភូមិ ' . $order->village : '' }}
                                {{ $order->city ? 'ក្រុង/ស្រុក ' . $order->city : '' }}
                                {{ $order->province ? 'ខេត្ត ' . $order->province : '' }}
                            @else
                                {{ $order->shipping_address ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">🏠 ទីតាំង:</td>
                        <td>
                            @if($order->location_type == 'phnom_penh')
                                <span class="badge bg-primary">ភ្នំពេញ</span>
                            @elseif($order->location_type == 'province')
                                <span class="badge bg-primary">ខេត្ត</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->location_type ?? 'N/A' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">📦 ទំនិញ:</td>
                        <td>{{ $order->items->count() }} មុខ</td>
                    </tr>
                    <tr>
                        <td class="info-label">🕒 ពេលបញ្ជា:</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">🕒 ធ្វើបច្ចុប្បន្នភាព: </td>
                        <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <i class="bi bi-basket-fill me-2"></i>បញ្ជីផលិតផលដែលបានបញ្ជាទិញ
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">រូបភាព</th>
                    <th>ផលិតផល</th>
                    <th class="text-center">តម្លៃ</th>
                    <th class="text-center">បរិមាណ</th>
                    <th class="text-end">សរុប</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="text-center">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #f8f9fa; border-radius: 5px;"
                                 class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">${{ number_format($item->price, 2) }}</td>
                    <td class="text-center"><span class="badge bg-primary">{{ $item->quantity }}</span></td>
                    <td class="text-end"><strong class="text-primary">${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <th colspan="4" class="text-end">សរុបទាំងអស់:</th>
                    <th class="text-end">${{ number_format($order->total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
