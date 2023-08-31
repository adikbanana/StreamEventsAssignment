<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\followers;
use App\Models\subscribers;
use App\Models\donations;
use App\Models\merch_sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); //The currently logged-in user

        // $aggregatedData = [
        //     'followers' => $user->followers,
        //     'subscribers' => $user->subscribers,
        //     'donations' => $user->donations,
        //     'merch_sales' => $user->merch_sales,
        // ];

        $aggregatedData = [
            'followers' => $user->followers->map(function ($follower) {
                $follower->type = 'follow';
                return $follower;
            }),
            'subscribers' => $user->subscribers->map(function ($subscriber) {
                $subscriber->type = 'subscribe';
                return $subscriber;
            }),
            'donations' => $user->donations->map(function ($donation) {
                $donation->type = 'donate';
                return $donation;
            }),
            'merch_sales' => $user->merch_sales->map(function ($merchSale) {
                $merchSale->type = 'merch';
                return $merchSale;
            }),
        ];

        $allEvents = collect();
        foreach ($aggregatedData as $eventType => $events) {
            $allEvents = $allEvents->merge($events);
        }

        $aggregatedData = $allEvents->sortBy('created_at');


        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Calculate total revenue from donations in the past 30 days
        $totalDonationRevenue = $user->donations
            ->where('created_at', '>', $thirtyDaysAgo)
            ->sum('amount');

        // Calculate total revenue from subscriptions in the past 30 days
        $subscriptionTierPrices = [
            1 => 5,
            2 => 10,
            3 => 15,
        ];

        $totalSubscriptionRevenue = $user->subscribers
            ->where('created_at', '>', $thirtyDaysAgo)
            ->sum(function ($subscriber) use ($subscriptionTierPrices) {
                return $subscriptionTierPrices[$subscriber->subscription_tier] ?? 0;
            });

        // Calculate total revenue from merch sales in the past 30 days
        $totalMerchSalesRevenue = $user->merch_sales
            ->where('created_at', '>', $thirtyDaysAgo)
            ->sum('price');

        // Calculate the overall total revenue
        $totalRevenue = $totalDonationRevenue + $totalSubscriptionRevenue + $totalMerchSalesRevenue;

        // Calculate total followers gained in the past 30 days
        $totalFollowersGained = $user->followers->where('created_at', '>', $thirtyDaysAgo)->count();

        // Fetch top 3 items with the best sales in the past 30 days
        $topMerchSales = $user->merch_sales
            ->where('created_at', '>', $thirtyDaysAgo)
            ->sortByDesc(function ($item) {
                return $item->quantity * $item->price; // Calculate total revenue for each item
            })
            ->take(3);
        // ->get();

        $perPage = 100;
        $aggregatedData = new Paginator($aggregatedData, $perPage);
        $aggregatedData->setPath(route('dashboard'));

        return view('dashboard.index', compact('aggregatedData', 'totalRevenue', 'totalFollowersGained', 'topMerchSales'));
    }

    public function markAsRead(Request $request)
    {
        $event_type = $request->input('event_type');
        $event_id = $request->input('event_id');

        $event = null;
        
        if ($event_type === 'follow') {
            $event = followers::find('$event_id');
        } elseif ($event_type === 'subscribe') {
            $event = subscribers::find($event_id);
        } elseif ($event_type === 'donate') {
            $event = donations::find($event_id);
        } elseif ($event_type === 'merch') {
            $event = merch_sales::find($event_id);
        } else {
            return response()->json(['success' => false]);
        }
    
        if ($event) {
            $event->update(['is_read' => !$event->is_read]);
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false]);
    }
    
}
