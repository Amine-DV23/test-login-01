@extends('layouts.app')

@section('content')

    <body>
        <section id="total-orders">
            <h2>Order Summary</h2>
            <p>Total Orders: <span id="order-count">{{ $totalOrders }}</span></p>
            <p>Total Value: $<span id="total-value">{{ number_format($totalValue, 2) }}</span></p>
        </section>

        <header>
            <h1>Order Management System</h1>


        </header>

        @if (session('error'))
            <div class="alert alert-danger" id="success-message">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        <section id="add-order">
            <h2>Add New Order</h2>
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <input type="text" name="product_name" placeholder="Product Name" required>
                </div>
                <div class="form-row">
                    <input type="number" name="product_price" placeholder="Product Price" step="0.01" required>
                    <input type="number" name="quantity" placeholder="Quantity" required>
                    <input type="text" name="order_total" placeholder="Order Total" readonly>
                </div>

                <textarea name="note" placeholder="Note" rows="3"></textarea>

                <button type="submit">Add Order</button>
                <section id="search-customer">
                    <h2>Search Customer</h2>
                    <div class="search-container">
                        <input type="text" id="search-input" placeholder="Search for customer by name...">
                        <button id="search-button" type="button">🔍</button> <!-- زر البحث -->
                    </div>
                    <ul id="search-results" style="list-style-type: none; padding: 0; margin-top: 10px;"></ul>
                    <!-- نتائج البحث -->
                </section>




            </form>
        </section>
        <section id="customer-info" style="display: none;">
            <h2>Customer Information</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #383838; padding: 8px; text-align: left;">Name</th>
                        <th style="border: 1px solid #383838; padding: 8px; text-align: left;">Address</th>
                        <th style="border: 1px solid #383838; padding: 8px; text-align: left;">Phone</th>
                        <th style="border: 1px solid #383838; padding: 8px; text-align: left;">Note</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="customer-name" style="border: 1px solid #383838; padding: 8px;"></td>
                        <td id="customer-address" style="border: 1px solid #383838; padding: 8px;"></td>
                        <td id="customer-phone" style="border: 1px solid #383838; padding: 8px;"></td>
                        <td id="customer-note" style="border: 1px solid #383838; padding: 8px;"></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="order-list">
            <h2>Order List</h2>
            <table>
                <thead>
                    <tr>
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
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->product_price }} MAD</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->total }} MAD</td>
                            <td>{{ $order->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>



    </body>

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
                totalInput.value = total.toFixed(2);
            }

            productPriceInput.addEventListener('input', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchButton = document.getElementById('search-button');
            const searchResults = document.getElementById('search-results');
            const customerInfo = document.getElementById('customer-info');

            // الخطوة 1: عرض قائمة النتائج عند الكتابة في خانة البحث
            searchInput.addEventListener('input', function() {
                const query = searchInput.value;

                if (query.length > 0) {
                    fetch(`/search-customers?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = ''; // تفريغ النتائج القديمة
                            data.forEach(customer => {
                                const li = document.createElement('li');
                                li.textContent = customer.name;
                                li.style.cursor = 'pointer';
                                // عند الضغط على أحد الأسماء، يظهر في خانة البحث فقط
                                li.addEventListener('click', function() {
                                    searchInput.value = customer.name;
                                    searchResults.innerHTML =
                                        ''; // إزالة القائمة بعد اختيار الاسم
                                });
                                searchResults.appendChild(li);
                            });
                        });
                } else {
                    searchResults.innerHTML = ''; // إخفاء النتائج إذا كانت الخانة فارغة
                }
            });

            // الخطوة 2: عند الضغط على زر البحث، عرض المعلومات
            searchButton.addEventListener('click', function() {
                const query = searchInput.value;

                if (query.length > 0) {
                    fetch(`/search-customers?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const customer = data[0]; // افتراض أن العميل الأول هو الهدف
                                document.getElementById('customer-name').textContent = customer.name;
                                document.getElementById('customer-address').textContent = customer
                                    .address;
                                document.getElementById('customer-phone').textContent = customer.phone;
                                document.getElementById('customer-note').textContent = customer.note ||
                                    'N/A';

                                // إظهار معلومات الزبون
                                customerInfo.style.display = 'block';
                            } else {
                                alert('No customer found.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching customer:', error);
                        });
                } else {
                    alert('Please enter a customer name to search.');
                }
            });
        });
    </script>
@endsection
