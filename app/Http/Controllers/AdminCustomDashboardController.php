<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminCustomDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function index()
    {
        if (!CRUDBooster::isSuperadmin() && !CRUDBooster::myPrivilegeId()) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), "You don't have permission to access this page!", 'warning');
        }

        $weeklySales = DB::table('returns_header')
            ->whereNotIn('repair_status', [3, 5])
            ->select(
                DB::raw('YEARWEEK(created_at, 1) as year_week'),
                DB::raw('WEEK(created_at) as week'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(parts_total_cost) as total')
            )
            ->groupBy('year_week', 'week', 'year')
            ->orderBy('year_week', 'asc')
            ->get();

        $monthlySales = DB::table('returns_header')
            ->whereNotIn('repair_status', [3, 5])
            ->select(
                DB::raw('MONTH(created_at) as month_number'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(parts_total_cost) as total')
            )
            ->groupBy('year', 'month_number', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month_number', 'asc')
            ->get();

        $ytdSales = DB::table('returns_header')
            ->whereNotIn('repair_status', [3, 5])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(parts_total_cost) as total')
            )
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $salesData = [
            'weekly' => [
                'labels' => $weeklySales->map(fn($w) => "Week {$w->week}, {$w->year}")->toArray(),
                'data' => $weeklySales->pluck('total')->toArray()
            ],
            'monthly' => [
                'labels' => $monthlySales->map(fn($m) => "{$m->month} {$m->year}")->toArray(),
                'data' => $monthlySales->pluck('total')->toArray()
            ],
            'ytd' => [
                'labels' => $ytdSales->pluck('year')->toArray(),
                'data' => $ytdSales->pluck('total')->toArray()
            ]
        ];

        return view('frontliner.admin_dashboard_custom', compact('salesData'));
    }
}
