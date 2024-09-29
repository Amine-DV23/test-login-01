<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::all();

        $totalOrders = $orders->count();
        $totalValue = $orders->sum('total');

        return view('home', compact('orders', 'totalOrders', 'totalValue'));
    }
    public function search(Request $request)
    {
        $client_name = $request->input('client_name');

        $order = Order::where('client_name', 'like', $client_name . '%')->first();

        if ($order) {
            return view('product_details', compact('order'));
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }


}
