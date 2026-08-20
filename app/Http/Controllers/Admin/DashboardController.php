<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Top Level Counters
        $totalCustomers = User::count();
        $pendingOrdersCount = Order::where('order_status', OrderStatusEnums::PENDING->value)->count();

        // Revenue = Total sales amount from delivered orders
        $totalRevenue = Order::where('order_status', OrderStatusEnums::DELIVERED->value)->sum('grand_total');

        // Profit = (Selling Price - Buying Price) * Quantity for delivered orders
        $totalProfit = OrderItem::whereHas('order', function ($q) {
            $q->where('order_status',  OrderStatusEnums::DELIVERED->value);
        })->get()->sum(function ($item) {
            $buyPrice = $item->buying_price ?? 0;
            return ($item->price - $buyPrice) * $item->quantity;
        });

        // Order Status Stats
        $orderStats = [
            'pending' => $pendingOrdersCount,
            'processing' => Order::where('order_status', OrderStatusEnums::PROCESSING->value)->count(),
            'delivered' => Order::where('order_status', OrderStatusEnums::DELIVERED->value)->count(),
            'cancelled' => Order::where('order_status', OrderStatusEnums::CANCELLED->value)->count(),
            'returned' => Order::where('order_status', OrderStatusEnums::RETURNED->value)->count(),
        ];

        // Monthly Sales Chart Data (12 Months of Current Year)
        $monthlySalesData = array_fill(0, 12, 0);

        $sales = Order::selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->whereYear('created_at', date('Y'))
            ->where('order_status', 'delivered')
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($sales as $month => $total) {
            $monthlySalesData[$month - 1] = $total;
        }

        // Flot Chart Data (Last 30 Days Revenue)
        $dailyRevenueData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Order::whereDate('created_at', $date->format('Y-m-d'))
                ->where('order_status', 'delivered')
                ->sum('grand_total');

            // Flot chart format: [[0, val], [1, val], [2, val] ...]
            $dailyRevenueData[] = [29 - $i, (float)$total];
        }

        // Recent Tables Data
        $recentOrders = Order::latest()->take(6)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        $monthlySalesData = array_values($monthlySalesData);
        $dailyRevenueData = array_values($dailyRevenueData);

        return view('admin.index', compact(
            'totalCustomers',
            'pendingOrdersCount',
            'totalRevenue',
            'totalProfit',
            'orderStats',
            'recentOrders',
            'recentMessages',
            'monthlySalesData',
            'dailyRevenueData'
        ));
    }
}
