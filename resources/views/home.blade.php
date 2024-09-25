@extends('layouts.app')

@section('content')

    <body>
        <header>
            <h1>Order Management System</h1>
            <div style="float: right; margin-top: -20px;">
                <form action="{{ route('search') }}" method="GET">
                    <input style="border-radius: 10px;" type="number" name="product_id" placeholder="Search by Product ID"
                        required>
                    <button style="border-radius: 50px;" type="submit">Search</button>
                </form>
            </div>

        </header>


        @if (session('error'))
            <div class="alert alert-danger"id="success-message">
                {{ session('error') }}
            </div>
        @endif

        <section id="add-order">
            <h2>Add New Order</h2>
            <form action="{{ route('orders.store') }}" method="POST">
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
                <button type="submit">Add Order</button>
            </form>
        </section>

        <section id="order-list">
            <h2>Order List</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
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
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->client_name }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->product_price }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->note }}</td>
                        </tr>
                    @endforeach
                </tbody>

                @if (session('success'))
                    <div class="alert alert-success" id="success-message">
                        {{ session('success') }}
                    </div>
                @endif


            </table>
        </section>

    </body>
@endsection
