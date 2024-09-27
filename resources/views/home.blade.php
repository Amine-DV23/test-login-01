@extends('layouts.app')

@section('content')

    <body>
        <header>
            <h1>Order Management System</h1>
            <div style="float: right; margin-top: -20px;">
                <form action="{{ route('search') }}" method="GET" style="display: flex; align-items: center;">
                    <input class="barsrsh" type="number" name="product_id" placeholder="Search by Product ID" required>
                    <button class="btnsrsh" type="submit">🔍</button>
                </form>
            </div>

        </header>

        @if (session('error'))
            <div class="alert alert-danger" id="success-message">
                {{ session('error') }}
            </div>
        @endif

        <section id="add-order">
            <h2>Add New Order</h2>
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <input type="text" name="client_name" placeholder="Client Name" required>
                    <input type="text" name="product_name" placeholder="Product Name" required>
                </div>
                <div class="form-row">
                    <input type="number" name="product_price" placeholder="Product Price" step="0.01" required>
                    <input type="number" name="quantity" placeholder="Quantity" required>
                    <input type="text" name="order_total" placeholder="Order Total" readonly>
                </div>

                <textarea name="note" placeholder="Note" rows="3"></textarea>
                <div class="form-row">
                    <div class="form-row">
                        <label for="product_image">Upload Product Image:</label>
                        <input type="file" name="product_image" id="product_image" accept="image/*" required>
                    </div>
                    <button type="submit">Add Order</button>
                </div>
            </form>
        </section>

        <section id="order-list">
            <h2>Order List</h2>

            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Product Image</th>
                        <th>Client Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="bordered">
                            <td>{{ $order->id }}</td>

                            <td>
                                @if ($order->product_image)
                                    <img src="{{ asset('images/' . $order->product_image) }}" alt=" product_image"
                                        style="width: 100px;">
                                @else
                                    no product_image
                                @endif
                            </td>

                            <td>{{ $order->client_name }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->product_price }} MAD</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->total }} MAD</td>
                            <td>{{ $order->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if (session('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
            @endif

        </section>

    </body>
@endsection
