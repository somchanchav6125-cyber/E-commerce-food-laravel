@extends('layouts.app')
{{-- ចំណាំ: សូមប្តូរទៅ extends layout របស់ admin ប្រសិនបើអ្នកមាន (ឧ. layouts.admin) --}}

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">ផ្ទៀងផ្ទាត់ការបង់ប្រាក់ (QR Scan)</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($payments->isEmpty())
            <p class="text-gray-500 text-center py-4">មិនមានការបង់ប្រាក់ដែលកំពុងរង់ចាំទេ។</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border-b">Invoice ID</th>
                        <th class="p-3 border-b">ចំនួនទឹកប្រាក់</th>
                        <th class="p-3 border-b">កាលបរិច្ឆេទ</th>
                        <th class="p-3 border-b">ស្ថានភាព</th>
                        <th class="p-3 border-b">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b font-mono">{{ $payment->invoice_id }}</td>
                        <td class="p-3 border-b font-bold text-green-600">${{ number_format($payment->amount, 2) }}</td>
                        <td class="p-3 border-b text-sm text-gray-500">{{ $payment->created_at->format('d-M-Y h:i A') }}</td>
                        <td class="p-3 border-b">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="p-3 border-b">
                            <form action="{{ route('admin.payments.confirm', $payment->id) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាបានទទួលលុយហើយមែនទេ?');">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded shadow transition">
                                    អនុម័ត (Confirm)
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
