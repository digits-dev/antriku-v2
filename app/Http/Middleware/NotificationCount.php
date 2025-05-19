<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class NotificationCount
{
    public function handle($request, Closure $next)
    {
        $callout_count_sidebar = DB::table('returns_header')
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();
        View::share('callout_count_sidebar', $callout_count_sidebar);

        $to_diagnose_count = DB::table('returns_header')
            ->whereIn('repair_status', [1, 10, 14, 17, 18, 20, 23, 27])
            ->where('technician_id', CRUDBooster::myId())
            ->count();
        View::share('to_diagnose_count', $to_diagnose_count);

        $ongoing_repair_count = DB::table('returns_header')
            ->whereIn('repair_status', [30, 31, 34, 40, 41, 42])
            ->where('technician_id', CRUDBooster::myId())
            ->count();
        View::share('ongoing_repair_count', $ongoing_repair_count);

        $receiving = DB::table('returns_header')
            ->whereIn('repair_status', [26, 33, 45, 47])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();
        View::share('receiving', $receiving);

        $releasing = DB::table('returns_header')
            ->whereIn('repair_status', [29, 39])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();
        View::share('releasing', $releasing);

        return $next($request);
    }
}
