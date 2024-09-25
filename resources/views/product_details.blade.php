@extends('layouts.app')

@section('content')
    <div class="product-details">
        <h2>Product Details</h2>
        <p><strong>Client Name:</strong> {{ $order->client_name }}</p>
        <p><strong>Product Name:</strong> {{ $order->product_name }}</p>
        <p><strong>Price:</strong> {{ $order->product_price }}</p>
        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Total:</strong> {{ $order->total }}</p>
        <p><strong>Note:</strong> {{ $order->note }}</p>
        <a href="{{ route('home') }}">Back to Home</a>
    </div>
@endsection
