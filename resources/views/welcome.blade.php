<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .gallery-item {
            width: 220px;
            /* عرض الخانة */
            height: 220px;
            /* ارتفاع الخانة */
            margin: 20px;
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
            max-height: 180px;
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
    <h1>Welcome</h1>

    @if ($bopos->isNotEmpty())
        <ul class="gallery">
            @foreach ($bopos as $bopo)
                <li class="gallery-item">

                    <img src="{{ $bopo->imagepath }}" alt="Uploaded Image">

                    <p>{{ $bopo->name }}</p> <!-- استبدل 'name' بالعمود الذي تحتاجه -->
                </li>
            @endforeach
        </ul>
    @else
        <p>لا توجد عناصر لعرضها.</p>
    @endif
</body>

</html>
