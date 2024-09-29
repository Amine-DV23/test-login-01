<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال منتج جديد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"],
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 200px;

            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        table {
            width: 110%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .search-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            display: inline-block;
            width: auto;
            margin-right: 10px;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>

    <h1>إدخال منتج جديد</h1>

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="ابحث عن المنتج...">
        <button onclick="searchProducts()">بحث</button>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>اسم المنتج:</label>
        <input type="text" name="product_name" required>
        <label>السعر:</label>
        <input type="number" name="prix" required>
        <label>المورد:</label>
        <input type="text" name="fornisseur" required>
        <label>سعر الشراء:</label>
        <input type="number" name="prix_achat" required>
        <label>الصورة:</label>
        <input type="file" name="image" required>
        <button type="submit">إضافة المنتج</button>
    </form>

    <div id="updateModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000;">
        <div style="background:white; margin:100px auto; padding:20px; width:600px; border-radius:5px;">
            <h1>تحديث المنتج</h1>
            <form id="updateForm" action="{{ route('products.update', '') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="productId">
                <label>اسم المنتج:</label>
                <input type="text" name="product_name" id="productName" required>
                <label>السعر:</label>
                <input type="number" name="prix" id="productPrice" required>
                <label>المورد:</label>
                <input type="text" name="fornisseur" id="productSupplier" required>
                <label>سعر الشراء:</label>
                <input type="number" name="prix_achat" id="productPurchasePrice" required>
                <label>الصورة (اختياري):</label>
                <input type="file" name="image" id="productImage">
                <button type="submit">تحديث</button>
                <button type="button" onclick="closeUpdateModal()">إغلاق</button>
            </form>
        </div>
    </div>

    <h1>المنتجات المسجلة</h1>
    <table id="productTable">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>اسم المنتج</th>
                <th>السعر</th>
                <th>المورد</th>
                <th>سعر الشراء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" width="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->prix }}</td>
                    <td>{{ $product->fornisseur }}</td>
                    <td>{{ $product->prix_achat }}</td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width: 100px;background-color: #dc3545; color: white; border: none; cursor: pointer;">حذف</button>
                        </form>
                        <button onclick="openUpdateModal({{ $product }})"
                            style="width: 100px; background-color: #007bff; color: white; border: none; cursor: pointer;">تحديث</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

<script>
    function closeUpdateModal() {
        document.getElementById('updateModal').style.display = 'none';
    }

    function openUpdateModal(product) {
        document.getElementById('productId').value = product.id;
        document.getElementById('productName').value = product.product_name;
        document.getElementById('productPrice').value = product.prix;
        document.getElementById('productSupplier').value = product.fornisseur;
        document.getElementById('productPurchasePrice').value = product.prix_achat;
        document.getElementById('updateForm').action = "{{ route('products.update', '') }}/" + product.id;
        document.getElementById('updateModal').style.display = 'block';
    }

    function searchProducts() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#productTable tr');

        rows.forEach(row => {
            const productName = row.cells[1].textContent.toLowerCase();
            if (productName.startsWith(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
<script>
    window.onload = function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }
    };
</script>

</html>
