<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::all();
        return view('home', compact('orders'));
    }
    public function search(Request $request)
    {
        $product_id = $request->input('product_id');
        $order = Order::find($product_id);

        if ($order) {
            return view('product_details', compact('order'));
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }

}
