<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // عرض قائمة الطلبات
        $orders = Order::all();
        return view('orders.index', compact('orders'));






    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'client_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'note' => 'nullable|string'
        ]);

        // حساب الإجمالي (total)
        $total = $request->input('product_price') * $request->input('quantity');

        // إنشاء طلب جديد في قاعدة البيانات
        Order::create([
            'client_name' => $request->input('client_name'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'), // تأكد من وجود هذا الحقل
            'quantity' => $request->input('quantity'),
            'total' => $total, // تمرير القيمة المحسوبة بشكل صحيح
            'note' => $request->input('note')
        ]);

        // إعادة التوجيه بعد الإضافة
        return redirect()->back()->with('success', 'Order added successfully.');
    }
}
