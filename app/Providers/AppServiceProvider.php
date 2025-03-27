<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $ongoingRepairCount = DB::table('returns_header')->whereIn('repair_status', [13, 15, 18, 19])->count();
        View::share('ongoing_repair_count', $ongoingRepairCount);

        // Get over all's count
        $fl_pending_call_out_dash_count_all = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])
            ->count();

        // Get today's count
        $fl_pending_call_out_dash_count = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])
            ->whereDate('created_at', today())
            ->count();

        // Get yesterday's count
        $yesterday_count = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])
            ->whereDate('created_at', today()->subDay())
            ->count();

        // Calculate percentage change (avoid division by zero)
        $percentage_change = $yesterday_count > 0 
            ? round((($fl_pending_call_out_dash_count - $yesterday_count) / $yesterday_count) * 100, 2)
            : 0; 

        // Abandoned Units
        $fl_abandoned_units_dash_count = DB::table('returns_header')
            ->whereIn('repair_status', [21])
            ->where('for_call_out_good_unit_at', '<=', Carbon::now()->subDays(60))
            ->count();

        // Get Aging Call-outs FOR CALL-OUT MAIL-IN
        $fl_aging_call_out_dash_count_all = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])
            ->count();
        $fl_aging_call_out_dash_count_0_14 = DB::table('returns_header')
            ->whereIn('repair_status', [10])
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->count();
        $fl_aging_call_out_dash_count_15_30 = DB::table('returns_header')
            ->whereIn('repair_status', [10])
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(15)])
            ->count();
        $fl_aging_call_out_dash_count_30_plus = DB::table('returns_header')
            ->whereIn('repair_status', [10])
            ->where('created_at', '<=', Carbon::now()->subDays(30))
            ->count();

        // Get Aging Call-outs FOR CALL-OUT (GOOD UNIT)
        $fl_gu_aging_call_out_dash_count_0_14 = DB::table('returns_header')
            ->whereIn('repair_status', [21])
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->count();
        $fl_gu_aging_call_out_dash_count_15_30 = DB::table('returns_header')
            ->whereIn('repair_status', [21])
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(15)])
            ->count();
        $fl_gu_aging_call_out_dash_count_30_plus = DB::table('returns_header')
            ->whereIn('repair_status', [21])
            ->where('created_at', '<=', Carbon::now()->subDays(30))
            ->count();

        View::share([
            'fl_pending_call_out_dash_count_all' => $fl_pending_call_out_dash_count_all,
            'fl_pending_call_out_dash_count' => $fl_pending_call_out_dash_count,
            'percentage_change' => $percentage_change,

            'fl_abandoned_units_dash_count' => $fl_abandoned_units_dash_count,

            'fl_aging_call_out_dash_count_all' => $fl_aging_call_out_dash_count_all,
            'fl_aging_call_out_dash_count_0_14' => $fl_aging_call_out_dash_count_0_14,
            'fl_aging_call_out_dash_count_15_30' => $fl_aging_call_out_dash_count_15_30,
            'fl_aging_call_out_dash_count_30_plus' => $fl_aging_call_out_dash_count_30_plus,

            'fl_gu_aging_call_out_dash_count_0_14' => $fl_gu_aging_call_out_dash_count_0_14,
            'fl_gu_aging_call_out_dash_count_15_30' => $fl_gu_aging_call_out_dash_count_15_30,
            'fl_gu_aging_call_out_dash_count_30_plus' => $fl_gu_aging_call_out_dash_count_30_plus,
        ]);

    }
}