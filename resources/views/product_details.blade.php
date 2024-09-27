@extends('layouts.app')

@section('content')
    <div class="product-details">
        <h2>Product Details</h2>
        <td>
            @if ($order->product_image)
                <img src="{{ asset('images/' . $order->product_image) }}" alt="product_image " style="width: 100px;">
            @else
                no product_image
            @endif
        </td>
        <p><strong>id:</strong>{{ $order->id }}</p>
        <p><strong>Client Name:</strong> {{ $order->client_name }}</p>
        <p><strong>Product Name:</strong> {{ $order->product_name }}</p>
        <p><strong>Price:</strong> {{ $order->product_price }} MAD</p>
        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Total:</strong> {{ $order->total }} MAD</p>
        <p><strong>Note:</strong> {{ $order->note }}</p>
        <a href="{{ route('home') }}">Back to Home</a>
    </div>
@endsection
