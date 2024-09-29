<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة زبون</title>
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
        }

        form {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        textarea {
            height: 100px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            text-align: center;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
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
            background-color: #eeeeee;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
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
        }

        .search-results-modal {
            display: none;
            position: fixed;
            z-index: 1;
            top: 60px;
            right: 75px;
            width: 300px;
            height: 100%;
            padding-top: 40px;

        }

        .search-results-content {
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            max-height: 70%;
            overflow-y: auto;
            text-align: left;

        }

        .search-results-content h3 {
            margin-bottom: 10px;
        }

        .search-results-content ul {
            list-style: none;
            padding: 0;
        }

        .search-results-content ul li {
            padding: 10px;
            background-color: #f8f9fa;
            margin-bottom: 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        .search-results-content ul li:hover {
            background-color: #e2e6ea;
        }

        .success-message {
            display: none;
            color: green;
            margin: 20px 20px;
            margin-top: -80px;
        }
    </style>
</head>

<body>
    <h1>إضافة زبون</h1>

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="ابحث عن زبون..." oninput="searchCustomers()">
        <button type="button" onclick="searchCustomers()">بحث</button>
    </div>

    <p class="success-message">{{ session('success') }}</p>

    <form action="{{ route('customers.store') }}" method="POST" onsubmit="showSuccessMessage(event)">
        @csrf
        <label for="name">اسم الزبون:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">العنوان:</label>
        <input type="text" id="address" name="address" required>

        <label for="phone">الهاتف:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="note">ملاحظة:</label>
        <textarea id="note" name="note"></textarea>

        <button type="submit">إرسال</button>
    </form>

    <h1>قائمة الزبائن المسجلين</h1>
    <table id="customerTable">
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
                <tr class="customer-row">
                    <td class="customer-name">{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->note }}</td>
                    <td>
                        <button class="update-button" data-id="{{ $customer->id }}"
                            onclick="openModal({{ $customer->id }}, '{{ $customer->name }}', '{{ $customer->address }}', '{{ $customer->phone }}', '{{ $customer->note }}')">تحديث</button>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                            style="display:inline;" onsubmit="showSuccessMessage(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h1>تحديث معلومات الزبون</h1>
            <form id="updateForm" action="" method="POST" onsubmit="showSuccessMessage(event)">
                @csrf
                @method('PUT')
                <label for="updateName">اسم الزبون:</label>
                <input type="text" id="updateName" name="name" required>

                <label for="updateAddress">العنوان:</label>
                <input type="text" id="updateAddress" name="address" required>

                <label for="updatePhone">الهاتف:</label>
                <input type="text" id="updatePhone" name="phone" required>

                <label for="updateNote">ملاحظة:</label>
                <textarea id="updateNote" name="note"></textarea>

                <button type="submit">تحديث</button>
            </form>
        </div>
    </div>

    <div id="searchResultsModal" class="search-results-modal">
        <div class="search-results-content">
            <ul id="searchResultsList"></ul>
        </div>
    </div>

    <script>
        function openModal(id, name, address, phone, note) {
            console.log(id);
            const modal = document.getElementById('updateModal');
            document.getElementById('updateForm').action = '/customers/' + id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateAddress').value = address;
            document.getElementById('updatePhone').value = phone;
            document.getElementById('updateNote').value = note;
            modal.style.display = "block";
        }

        function closeModal() {
            const modal = document.getElementById('updateModal');
            modal.style.display = "none";
        }

        function searchCustomers() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.customer-row');
            const searchResultsList = document.getElementById('searchResultsList');
            searchResultsList.innerHTML = '';
            rows.forEach(function(row) {
                const name = row.querySelector('.customer-name').textContent.toLowerCase();
                const id = row.querySelector('.update-button').getAttribute('data-id');

                if (name.includes(input)) {
                    const listItem = document.createElement('li');
                    listItem.textContent = name;
                    listItem.setAttribute('data-id', id);
                    listItem.onclick = function() {
                        openModal(
                            id,
                            row.querySelector('.customer-name').textContent,
                            row.querySelector('td:nth-child(2)').textContent,
                            row.querySelector('td:nth-child(3)').textContent,
                            row.querySelector('td:nth-child(4)').textContent
                        );
                        closeSearchResultsModal();
                    };
                    searchResultsList.appendChild(listItem);
                }
            });

            if (searchResultsList.childNodes.length > 0) {
                document.getElementById('searchResultsModal').style.display = 'block';
            } else {
                closeSearchResultsModal();
            }
        }

        function closeSearchResultsModal() {
            const modal = document.getElementById('searchResultsModal');
            modal.style.display = "none";
        }

        function showSuccessMessage(event) {
            event.preventDefault();

            const form = event.target;
            const successMessage = document.querySelector('.success-message');
            successMessage.style.display = 'block';
            successMessage.textContent = form.method === 'POST' ? 'تم  بنجاح!' :
                'تم  بنجاح!';

            setTimeout(() => {
                form.submit();
            }, 2000);

            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 2000);
        }
    </script>
</body>

</html>
