<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminCustomDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    private const Cancelled = 3;
    private const CancelledClosed = 5;
    private const OngoingRepair = 13;
    private const ShippedMailIn = 16;
    private const SparePartsReceived = 15;
    private const ReplacementPartsPaid = 18;
    private const PendingCustomerPayment = 17;
    private const ForPartsOrdering = 19;

    public function index()
    {
        if (!CRUDBooster::isSuperadmin() && !CRUDBooster::myPrivilegeId()) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), "You don't have permission to access this page!", 'warning');
        }

        $weeklySales = DB::table('returns_header')
            ->whereNotIn('repair_status', [self::OngoingRepair, CancelledClosed])
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
            ->whereNotIn('repair_status', [self::OngoingRepair, CancelledClosed])
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
            ->whereNotIn('repair_status', [self::OngoingRepair, CancelledClosed])
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

    public function technicianDashboard() {
        if (!CRUDBooster::isSuperadmin() && !CRUDBooster::myPrivilegeId()) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), "You don't have permission to access this page!", 'warning');
        }

        $data = [];
        $data['totalOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair,self::ReplacementPartsPaid,self::SparePartsReceived, self::ForPartsOrdering])->where('branch', 1)->count();
        $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair,self::ReplacementPartsPaid,self::SparePartsReceived, self::ForPartsOrdering])->where('technician_id', CRUDBooster::myId())->count();
        $data['totalPendingCustomerPayment'] = DB::table('returns_header')->where('repair_status', self::PendingCustomerPayment)->where('technician_id', CRUDBooster::myId())->count();
        $data['totalRepairPerModel'] = DB::table('returns_header')
        ->join('model', 'returns_header.model', '=', 'model.id')
        ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
        ->groupBy('model.model_name')
        ->orderByDesc('total_repairs')
        ->paginate(10);

        $data['totalCarryIn'] = DB::table('returns_header')->where('case_status', 'CARRY-IN')->where('branch', 1)->count();
        $data['totalMailIn'] = DB::table('returns_header')->where('case_status', 'MAIL-IN')->where('branch', 1)->count();

        $data['totalSalesIW'] = DB::table('returns_header')->where('warranty_status', 'IN WARRANTY')->sum('parts_total_cost');
        $data['totalSalesOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->sum('parts_total_cost');
    
            

        return view('technician.admin_dashboard_custom', $data);
    }
}