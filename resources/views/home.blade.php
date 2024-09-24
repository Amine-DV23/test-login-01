@extends('layouts.app')

@section('content')

    <body>
        <header>
            <h1>Order Management System</h1>
        </header>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('#add-order form');
                const productPriceInput = form.querySelector('input[name="product_price"]');
                const quantityInput = form.querySelector('input[name="quantity"]');
                const totalInput = form.querySelector('input[name="order_total"]');

                function calculateTotal() {
                    const price = parseFloat(productPriceInput.value) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const total = price * quantity;
                    totalInput.value = total.toFixed(2); // تأكد من عرض القيمة بصيغة عشرية
                }

                productPriceInput.addEventListener('input', calculateTotal);
                quantityInput.addEventListener('input', calculateTotal);
            });
        </script>
        <script>
            // تأكد من وجود الرسالة
            window.onload = function() {
                const message = document.getElementById('success-message');
                if (message) {
                    // إخفاء الرسالة بعد 3 ثوانٍ
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 3000); // 3000 مللي ثانية = 3 ثوانٍ
                }
            };
        </script>
    </body>
@endsection
