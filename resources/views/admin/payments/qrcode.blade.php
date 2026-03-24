@extends('layouts.admin')

@section('content')
<h1>QR Code for Order #{{ $order->id }}</h1>
<p>Amount: ${{ $order->total }}</p>

<div style="margin-top:20px;">
    {!! $qrCode !!}
</div>

<form action="{{ route('admin.payments.confirm', $order->id) }}" method="POST" style="margin-top:10px;">
    @csrf
    <button type="submit" class="btn btn-success">Confirm Payment</button>
</form>
@endsection
