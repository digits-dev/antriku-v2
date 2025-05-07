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
        $callout_count_sidebar = DB::table('returns_header')->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])->count();
        View::share('callout_count_sidebar', $callout_count_sidebar);

        $to_diagnose_count = DB::table('returns_header')->whereIn('repair_status', [1, 10, 14, 17, 18, 20,23,27])->count();
        View::share('to_diagnose_count', $to_diagnose_count);

        $ongoing_repair_count = DB::table('returns_header')->whereIn('repair_status', [30, 31, 34, 40, 41, 42])->count();
        View::share('ongoing_repair_count', $ongoing_repair_count);

        return $next($request);
    }
}
