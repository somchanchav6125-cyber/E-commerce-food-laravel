<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        $user = Auth::user();

        $totalOrders = Order::where('user_id', $user->id)->count();
        $processingOrders = Order::where('user_id', $user->id)->where('status', 'processing')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('user.dashboard', compact(
            'totalOrders',
            'processingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }
}
