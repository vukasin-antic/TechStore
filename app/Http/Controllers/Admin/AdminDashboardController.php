<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
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
            $pendingStatus = OrderStatus::where('name', OrderStatusEnum::Pending)->first();

            $this->data['pendingOrders'] = Order::where('status_id', $pendingStatus->id)->count();
            $this->data['salesChart'] = $this->salesChartData();

            return view('admin.dashboard', $this->data);

        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Daily revenue and order counts for the last 30 days, zero-filled
     * so the chart has a point for every day.
     */
    private function salesChartData(): array
    {
        $start = now()->subDays(29)->startOfDay();

        $ordersByDay = Order::where('created_at', '>=', $start)
            ->get(['created_at', 'total_price'])
            ->groupBy(fn ($order) => $order->created_at->format('Y-m-d'));

        $chart = ['labels' => [], 'revenue' => [], 'orders' => []];
        for ($day = $start->copy(); $day->lessThanOrEqualTo(now()); $day->addDay()) {
            $ordersOfDay = $ordersByDay->get($day->format('Y-m-d'), collect());
            $chart['labels'][] = $day->format('j M');
            $chart['revenue'][] = round($ordersOfDay->sum('total_price'), 2);
            $chart['orders'][] = $ordersOfDay->count();
        }

        return $chart;
    }
}
