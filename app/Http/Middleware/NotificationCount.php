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
        // $ongoingRepairCount = DB::table('returns_header')->whereIn('repair_status', [13, 15, 18, 19])->where('technician_id', CRUDBooster::myId())->count();
        // View::share('ongoing_repair_count', $ongoingRepairCount);

        return $next($request);
    }
}
