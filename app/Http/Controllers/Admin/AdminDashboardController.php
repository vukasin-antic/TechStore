<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
        try{
            $this->data['totalOrders'] = Order::count();
            $this->data['totalProducts'] = Product::count();
            $this->data['totalUsers'] = User::where('role', 'user')->count();
            $this->data['totalRevenue'] = Order::sum('total_price');
            $this->data['recentOrders'] = Order::with('user')->latest()->take(5)->get();
            $this->data['recentLogs'] = Log::latest('date')->take(5)->get();
            $this->data['pendingOrders'] = Order::where('status', 'pending')->count();

            return view('admin.dashboard', $this->data);

        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
