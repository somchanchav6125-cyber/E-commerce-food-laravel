<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // អ្នកប្រើប្រាស់សរុប (គ្រប់គ្នាដែលមាន role 'user')
        $totalUsers = User::where('role', 'user')->count();

        // អ្នកទិញសរុប (អ្នកដែលបានបញ្ជាទិញយ៉ាងហោចណាស់ម្តង)
        $totalBuyers = Order::distinct('user_id')->count('user_id');

        // Recent orders (for table)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Order counts per period
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // Revenue for today and this week (for display in cards)
        $revenueToday = Order::whereDate('created_at', today())->sum('total');
        $revenueThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total');

        // Sales data for line chart (last 7 days)
        $dates = [];
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('d M');
            $salesData[] = Order::whereDate('created_at', $date)->sum('total');
        }

        // Calculate trend (compare last 7 days with previous 7 days)
        $last7DaysTotal = Order::whereBetween('created_at', [Carbon::today()->subDays(6), Carbon::today()])->sum('total');
        $previous7DaysTotal = Order::whereBetween('created_at', [Carbon::today()->subDays(13), Carbon::today()->subDays(7)])->sum('total');
        $trendPercentage = $previous7DaysTotal > 0 ? round((($last7DaysTotal - $previous7DaysTotal) / $previous7DaysTotal) * 100, 1) : 0;
        $trendUp = $last7DaysTotal >= $previous7DaysTotal;

        // Traffic sources dummy data (replace with real data if available)
        $trafficSources = [
            ['source' => 'Direct',   'visits' => 1234],
            ['source' => 'Social',   'visits' => 987],
            ['source' => 'Search',   'visits' => 654],
            ['source' => 'Email',    'visits' => 321],
            ['source' => 'Referral', 'visits' => 210],
        ];
        $trafficLabels = json_encode(collect($trafficSources)->pluck('source'));
        $trafficData = json_encode(collect($trafficSources)->pluck('visits'));

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBuyers',
            'recentOrders',
            'ordersToday',
            'ordersThisWeek',
            'revenueToday',
            'revenueThisWeek',
            'dates',
            'salesData',
            'last7DaysTotal',
            'trendPercentage',
            'trendUp',
            'trafficLabels',
            'trafficData'
        ));
    }
}
