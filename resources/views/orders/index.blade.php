@extends('layouts.app')

@section('content')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    </head>

    <body>
        <div class="container mt-5">
            <h1 class="mb-4" id="page-title">products</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div style="float: right; margin-top: -40px;">
                <form id="search-form" action="{{ route('orders.search') }}" method="GET"
                    style="display: flex; align-items: center;">
                    <input class="barsrsh" type="text" name="query" placeholder="search product name" required
                        minlength="3" onfocus="showSearchHeader()">
                    <button class="btnsrsh" type="submit">🔍</button>
                </form>
            </div>

            <div class="search-header" id="search-header">
            </div>

            <div class="row" id="products-container">
                @foreach ($orders as $order)
                    <div class="product-card">
                        @if ($order->product_image)
                            <img src="{{ asset('images/' . $order->product_image) }}" alt="product_image"
                                class="product-image">
                        @else
                            <p>no product_image</p>
                        @endif
                        <div class="productprice">{{ $order->product_name }}</div>
                        <div class="product-info">{{ $order->product_price }} MAD</div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function showSearchHeader() {
                document.getElementById('page-title').innerText = 'product Search';
            }

            function goToOrdersPage() {
                window.location.href = "{{ route('orders.index') }}";
            }

            document.getElementById('search-form').addEventListener('submit', function() {
                hideSearchHeader();
            });
        </script>
    </body>
@endsection
