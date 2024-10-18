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



}
