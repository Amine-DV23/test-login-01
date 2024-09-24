<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));






    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'note' => 'nullable|string'
        ]);

        $total = $request->input('product_price') * $request->input('quantity');

        Order::create([
            'client_name' => $request->input('client_name'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'quantity' => $request->input('quantity'),
            'total' => $total,
            'note' => $request->input('note')
        ]);

        return redirect()->back()->with('success', 'Order added successfully.');
    }
}
