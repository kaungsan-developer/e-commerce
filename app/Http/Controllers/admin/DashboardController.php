<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::count();
        $orders = Order::count();
        $users = User::count(); 
        $totalIncome = Order::where('status', 'delivered')->sum('total_amount');
        return view('admin.dashboard.index', compact('products', 'orders', 'users', 'totalIncome'));
    }
}
