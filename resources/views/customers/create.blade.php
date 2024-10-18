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


        .success-message {
            display: none;
            color: green;
            margin: 20px 20px;
            margin-top: -80px;
        }

        .search-container {
            display: flex;
            align-items: center;
            left: 100px;
        }

        #search-input {
            width: 200px;
            /* عرض خانة البحث */
            height: 34px;
            /* طول خانة البحث */
            padding: 8px;
            font-size: 16px;
            border-radius: 10px;
        }

        #search-button {
            width: 40px;
            /* عرض زر البحث */
            height: 40px;
            /* طول زر البحث */
            margin-left: 10px;
            cursor: pointer;
            border-radius: 50%;
            /* يجعل الزر دائريًا */
            border: none;
            background-color: #3498db;
            /* لون خلفية الزر */
            border: 1px solid black;
            /* لون النص أو الأيقونة داخل الزر */
            font-size: 16px;
            /* حجم الأيقونة أو النص داخل الزر */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <h1>إضافة زبون</h1>

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
        <!-- جزء البحث -->
        <section id="search-customer">
            <h2>بحث عن زبون</h2>
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search for customer by name...">
                <button id="search-button">🔍</button>
            </div>
            <ul id="search-results" style="list-style-type: none; padding: 0;"></ul>
        </section>
    </form>


    <section id="customer-info" style="display: none;">
        <h2>معلومات الزبون</h2>
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>العنوان</th>
                    <th>الهاتف</th>
                    <th>ملاحظة</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="customer-name"></td>
                    <td id="customer-address"></td>
                    <td id="customer-phone"></td>
                    <td id="customer-note"></td>

                </tr>
            </tbody>
        </table>
    </section>



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
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->note }}</td>
                    <td>
                        <button class="update-button"
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




    <!-- المودال لتحديث البيانات -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h1>تحديث معلومات الزبون</h1>
            <form id="updateForm" method="POST" onsubmit="showSuccessMessage(event)">
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

    <script>
        function openModal(id, name, address, phone, note) {
            document.getElementById('updateForm').action = '/customers/' + id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateAddress').value = address;
            document.getElementById('updatePhone').value = phone;
            document.getElementById('updateNote').value = note;
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        function showSuccessMessage(event) {
            event.preventDefault();
            const successMessage = document.querySelector('.success-message');
            successMessage.style.display = 'block';
            successMessage.textContent = 'تمت العملية بنجاح!';

            setTimeout(() => {
                event.target.submit();
            }, 2000);

            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 4000);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            const customerInfo = document.getElementById('customer-info');
            const searchButton = document.getElementById('search-button');

            // عند إدخال نص في خانة البحث
            searchInput.addEventListener('input', function() {
                const query = searchInput.value;

                if (query.length > 0) {
                    fetch(`/search-customers?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = ''; // مسح النتائج السابقة
                            data.forEach(customer => {
                                const li = document.createElement('li');
                                li.textContent = customer.name;
                                li.style.cursor = 'pointer';
                                li.addEventListener('click', function() {
                                    // تحديث خانة البحث بالاسم المحدد
                                    searchInput.value = customer.name;
                                    searchResults.innerHTML =
                                    ''; // إزالة القائمة بعد اختيار الاسم
                                });
                                searchResults.appendChild(li);
                            });
                        });
                } else {
                    searchResults.innerHTML = ''; // إذا كانت خانة البحث فارغة
                }
            });

            // عند الضغط على زر البحث
            searchButton.addEventListener('click', function(event) {
                event.preventDefault(); // منع إعادة تحميل الصفحة
                const query = searchInput.value;

                if (query.length > 0) {
                    fetch(`/search-customers?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const customer = data[0]; // افتراض أن النتيجة واحدة
                                // إظهار معلومات الزبون
                                document.getElementById('customer-name').textContent = customer.name;
                                document.getElementById('customer-address').textContent = customer
                                    .address;
                                document.getElementById('customer-phone').textContent = customer.phone;
                                document.getElementById('customer-note').textContent = customer.note ||
                                    'N/A';
                                customerInfo.style.display = 'block'; // إظهار معلومات الزبون
                            } else {
                                alert('لا توجد نتائج'); // تنبيه إذا لم يتم العثور على أي نتائج
                            }
                        });
                }
            });
        });
    </script>
</body>

</html>
