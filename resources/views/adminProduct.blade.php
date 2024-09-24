<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .gallery-item {
            width: 100px;
            /* عرض الخانة */
            height: 120px;
            /* ارتفاع الخانة */
            margin: 10px;
            /* مسافة بين الخانات */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            max-height: 80px;
            /* أقصى ارتفاع للصورة */
            border-bottom: 1px solid #ddd;
        }

        .gallery-item p {
            margin: 5px 0 0;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>إضافة منتج جديد</h1>

    <form action="{{ route('bopos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Submit</button>
    </form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>المنتجات المضافة</h2>



</body>

</html>
