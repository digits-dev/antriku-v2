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
        $callout_count_sidebar = DB::table('returns_header')->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('callout_count_sidebar', $callout_count_sidebar);

        $mail_in = DB::table('returns_header')->whereIn('repair_status', [12, 21, 26, 47])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('mail_in', $mail_in);

        $carry_in = DB::table('returns_header')->whereIn('repair_status', [33 ,35 ,43 ,45 ,48])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('carry_in', $carry_in);

        $call_out_releasing = DB::table('returns_header')->whereIn('repair_status', [13 ,19 ,22 ,28 , 39])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('call_out_releasing', $call_out_releasing);

        $mail_in = DB::table('returns_header')->whereIn('repair_status', [12, 21, 26, 47])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('mail_in', $mail_in);

        $carry_in = DB::table('returns_header')->whereIn('repair_status', [33 ,35 ,43 ,45 ,48])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('carry_in', $carry_in);

        $call_out_releasing = DB::table('returns_header')->whereIn('repair_status', [13 ,19 ,22 ,28 , 39])->where('branch', CRUDBooster::me()->branch_id)->count();
        View::share('call_out_releasing', $call_out_releasing);

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

        $pending_mail_in_shipment = DB::table('returns_header')->whereIn('repair_status', [15, 16, 24, 25])->count();
        View::share('pending_mail_in_shipment', $pending_mail_in_shipment);

        $spare_parts_parent_module = DB::table('returns_header')->whereIn('repair_status', [26 ,33 ,45 ,47, 29, 39])->count();
        View::share('spare_parts_parent_module', $spare_parts_parent_module);

        $pending_mail_in_shipment = DB::table('returns_header')->whereIn('repair_status', [15, 16, 24, 25])->count();
        View::share('pending_mail_in_shipment', $pending_mail_in_shipment);

        $spare_parts_parent_module = DB::table('returns_header')->whereIn('repair_status', [26 ,33 ,45 ,47, 29, 39])->count();
        View::share('spare_parts_parent_module', $spare_parts_parent_module);

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