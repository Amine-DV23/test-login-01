<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الزبائن</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #343a40;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        th,
        td {
            padding: 12px;
            text-align: right;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .success-message {
            color: green;
            text-align: center;
            margin: 20px 20px;
            margin-top: -20px;
            font-weight: bold;
            display: none;
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

        .delete-button {
            background-color: #dc3545;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .update-button {
            background-color: #28a745;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .update-button:hover {
            background-color: #218838;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .modal-content input {
            width: 98%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>قائمة الزبائن</h1>

    <p id="successMessage" class="success-message">تمت العملية بنجاح!</p>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="ابحث عن زبون..." oninput="searchCustomers()">
        <button type="button" onclick="searchCustomers()">بحث</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>اسم الزبون</th>
                <th>العنوان</th>
                <th>الهاتف</th>
                <th>ملاحظة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->note }}</td>
                    <td>
                        <button class="update-button"
                            onclick="openModal({{ $customer->id }}, '{{ $customer->name }}', '{{ $customer->address }}', '{{ $customer->phone }}', '{{ $customer->note }}')">تحديث</button>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button" onclick="showMessage()">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>تحديث الزبون</h2>
            <form id="updateForm" method="POST">
                @csrf
                @method('PUT')
                <input type="text" id="customerName" name="name" placeholder="اسم الزبون" required>
                <input type="text" id="customerAddress" name="address" placeholder="العنوان" required>
                <input type="text" id="customerPhone" name="phone" placeholder="الهاتف" required>
                <input type="text" id="customerNote" name="note" placeholder="ملاحظة" required>
                <button class="update-button" type="submit" onclick="showMessage()">تحديث</button>
            </form>
        </div>
    </div>

    <script>
        function searchCustomers() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                if (name.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function openModal(id, name, address, phone, note) {
            document.getElementById('customerName').value = name;
            document.getElementById('customerAddress').value = address;
            document.getElementById('customerPhone').value = phone;
            document.getElementById('customerNote').value = note;
            document.getElementById('updateForm').action = '/customers/' + id;
            document.getElementById('myModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('myModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        function showMessage() {
            const message = document.getElementById('successMessage');
            message.style.display = 'block';
            setTimeout(function() {
                message.style.display = 'none';
            }, 4000);
        }
    </script>
</body>

</html>
