<?php

namespace App\Http\Controllers;

use App\Models\DailyReturn;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Build last-7-days daily returns dataset
        $today  = Carbon::today();
        $labels = [];
        $values = [];

        // Fetch the user's existing records for the last 7 days
        $records = DailyReturn::where('user_id', $user->id)
            ->whereBetween('return_date', [$today->copy()->subDays(6), $today])
            ->get()
            ->keyBy(fn($r) => $r->return_date->format('Y-m-d'));

        // Fetch the global max setting
        $globalMax = (float) \App\Models\Setting::get('global_max_daily_return', 5.00);

        for ($i = 6; $i >= 0; $i--) {
            $date      = $today->copy()->subDays($i);
            $key       = $date->format('Y-m-d');
            $labels[]  = $date->format('D, d M'); // e.g. "Mon, 11 Jul"
            
            if (isset($records[$key])) {
                $actualPct = (float) $records[$key]->return_percentage;
                // Cap at global max if actual is higher
                $displayPct = $actualPct > $globalMax ? $globalMax : $actualPct;
                // Calculate return amount based on user's portfolio value
                $displayAmount = round($user->portfolio_value * $displayPct / 100, 2);
                $values[] = $displayAmount;
            } else {
                $values[] = 0;
            }
        }

        // Compute total returns dynamically from all history
        $allRecords = DailyReturn::where('user_id', $user->id)->get();
        $computedTotalReturns = 0;

        foreach ($allRecords as $r) {
            $sign = $r->return_percentage >= 0 ? 1 : -1;
            $computedTotalReturns += $sign * $r->return_amount;
        }

        // Calculate growth rate from total deposits
        $computedGrowthRate = $user->portfolio_value > 0 
            ? ($computedTotalReturns / $user->portfolio_value) * 100 
            : 0;

        return view('user.dashboard', compact('user', 'labels', 'values', 'computedTotalReturns', 'computedGrowthRate'));
    }
}
