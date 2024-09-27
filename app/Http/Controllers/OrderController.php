<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $orders = $query
            ? Order::where('product_name', 'LIKE', "%{$query}%")->get()
            : Order::all();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'note' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $total = $request->input('product_price') * $request->input('quantity');

        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        Order::create([
            'client_name' => $request->input('client_name'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'quantity' => $request->input('quantity'),
            'total' => $total,
            'note' => $request->input('note'),
            'product_image' => $imageName
        ]);

        return redirect()->back()->with('success', 'تم إضافة الطلب بنجاح.');
    }
}
