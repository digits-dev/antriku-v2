<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class NotificationCount
{
    public function handle($request, Closure $next)
    {
        $ongoingRepairCount = DB::table('returns_header')->whereIn('repair_status', [13, 15, 18, 19])->where('technician_id', CRUDBooster::myId())->count();
        View::share('ongoing_repair_count', $ongoingRepairCount);

        $to_diagnose_count = DB::table('returns_header')->whereIn('repair_status', [1, 9, 16])->where('technician_id', CRUDBooster::myId())->count();
        View::share('to_diagnose_count', $to_diagnose_count);

        $pending_mail_in_shipment = DB::table('returns_header')->whereIn('repair_status', [11, 12])->count();
        View::share('pending_mail_in_shipment', $pending_mail_in_shipment);

        $pending_spare_parts = DB::table('returns_header')->whereIn('repair_status', [14])->count();
        View::share('pending_spare_parts', $pending_spare_parts);

        $pending_good_unit = DB::table('returns_header')->whereIn('repair_status', [22])->count();
        View::share('pending_good_unit', $pending_good_unit);

        $call_out_count = DB::table('returns_header')->whereIn('repair_status', [10, 3, 17, 21])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('call_out_count', $call_out_count);

        // Get over all's count
        $fl_pending_call_out_dash_count_all = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])->where('branch', CRUDBooster::me()->branch_id)
            ->count();

        // Get today's count
        $fl_pending_call_out_dash_count = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])->where('branch', CRUDBooster::me()->branch_id)
            ->whereDate('created_at', today())
            ->count();

        // Get yesterday's count
        $yesterday_count = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])->where('branch', CRUDBooster::me()->branch_id)
            ->whereDate('created_at', today()->subDay())
            ->count();

        // Calculate percentage change (avoid division by zero)
        $percentage_change = $yesterday_count > 0
            ? round((($fl_pending_call_out_dash_count - $yesterday_count) / $yesterday_count) * 100, 2)
            : 0;

        // Abandoned Units
        $fl_abandoned_units_dash_count = DB::table('returns_header')
            ->whereIn('repair_status', [21])->where('branch', CRUDBooster::me()->branch_id)
            ->where('for_call_out_good_unit_at', '<=', Carbon::now()->subDays(60))
            ->count();

        // Get Aging Call-outs FOR CALL-OUT MAIL-IN
        $fl_aging_call_out_dash_count_all = DB::table('returns_header')
            ->whereIn('repair_status', [10, 21])->where('branch', CRUDBooster::me()->branch_id)
            ->count();
        $fl_aging_call_out_dash_count_0_14 = DB::table('returns_header')
            ->whereIn('repair_status', [10])->where('branch', CRUDBooster::me()->branch_id)
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->count();
        $fl_aging_call_out_dash_count_15_30 = DB::table('returns_header')
            ->whereIn('repair_status', [10])->where('branch', CRUDBooster::me()->branch_id)
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(15)])
            ->count();
        $fl_aging_call_out_dash_count_30_plus = DB::table('returns_header')
            ->whereIn('repair_status', [10])->where('branch', CRUDBooster::me()->branch_id)
            ->where('created_at', '<=', Carbon::now()->subDays(30))
            ->count();

        // Get Aging Call-outs FOR CALL-OUT (GOOD UNIT)
        $fl_gu_aging_call_out_dash_count_0_14 = DB::table('returns_header')
            ->whereIn('repair_status', [21])->where('branch', CRUDBooster::me()->branch_id)
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->count();
        $fl_gu_aging_call_out_dash_count_15_30 = DB::table('returns_header')
            ->whereIn('repair_status', [21])->where('branch', CRUDBooster::me()->branch_id)
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(15)])
            ->count();
        $fl_gu_aging_call_out_dash_count_30_plus = DB::table('returns_header')
            ->whereIn('repair_status', [21])->where('branch', CRUDBooster::me()->branch_id)
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

        return $next($request);
    }
}
