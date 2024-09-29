<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المنتجات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            margin-left: 20px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .back-button i {
            margin-right: 5px;
        }

        .search-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 200px;
            padding: 10px;
            margin-left: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-card {
            width: 200px;
            height: 320px;
            background: white;
            margin: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 200px;
            height: auto;
            max-height: 150px;
            object-fit: contain;
        }

        .product-info {
            padding: 10px;
        }
    </style>
</head>

<body>
    <header>
        <button class="back-button" onclick="window.location.href='{{ route('products.index') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1>قائمة المنتجات</h1>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="ابحث عن المنتج...">
            <button onclick="searchProducts()">بحث</button>
        </div>
    </header>

    <div class="product-container">
        @foreach ($products as $product)
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                <div class="product-info">
                    <p>اسم المنتج: {{ $product->product_name }}</p>
                    <p>السعر: {{ $product->prix }}</p>
                    <p>المورد: {{ $product->fornisseur }}</p>
                    <p>سعر الشراء: {{ $product->prix_achat }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function searchProducts() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                const productName = card.querySelector('.product-info p').textContent.toLowerCase();
                if (productName.includes(input)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
