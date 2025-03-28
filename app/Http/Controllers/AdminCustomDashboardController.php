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
        
        $data['handle_overall_total'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->count();

        $data['handle_for_all_employee'] = $handle_per_employee = DB::table('returns_header')
            ->select(
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();

        $data['handle_per_employee'] = $handle_per_employee = DB::table('returns_header')
            ->select(
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->where('cms_users.id', '=', CRUDBooster::myId())
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();
        
        $data['customers_units'] = $handle_per_employee = DB::table('returns_header')->where('branch', CRUDBooster::me()->branch_id)->count();

        return view('frontliner.admin_dashboard_custom', compact('salesData'), $data);
    }

    public function getSalesData(Request $request)
    {
        $year = $request->input('year', date('Y')); 

        // Apply year filter for Weekly and Monthly
        $weeklySales = DB::table('returns_header')
            ->whereNotIn('repair_status', [self::OngoingRepair, self::CancelledClosed])
            ->whereYear('created_at', $year) 
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
            ->whereNotIn('repair_status', [self::OngoingRepair, self::CancelledClosed])
            ->whereYear('created_at', $year) 
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
            ->whereNotIn('repair_status', [self::OngoingRepair, self::CancelledClosed])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(parts_total_cost) as total')
            )
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()->json([
            'weekly' => [
                'labels' => $weeklySales->map(fn($w) => "Week {$w->week}, {$w->year}")->toArray(),
                'data' => $weeklySales->pluck('total')->toArray()
            ],
            'monthly' => [
                'labels' => $monthlySales->map(fn($m) => "{$m->month} {$m->year}")->toArray(),
                'data' => $monthlySales->pluck('total')->toArray()
            ],
            'ytd' => [  // YTD shows all years
                'labels' => $ytdSales->pluck('year')->toArray(),
                'data' => $ytdSales->pluck('total')->toArray()
            ],
        ]);
    }

    public function filterCustomerUnit(Request $request)
    {
        $unit_type = $request->input('unit_type');
        $date_from = $request->input('date_range_from'); 
        $date_to = $request->input('date_range_to'); 

        $query = DB::table('returns_header');

        // Apply date range filter
        if ($date_from && $date_to) {
            $query->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$date_from, $date_to]);
        } elseif ($date_from) { 
            $query->whereRaw("DATE(created_at) >= ?", [$date_from]);
        } elseif ($date_to) { 
            $query->whereRaw("DATE(created_at) <= ?", [$date_to]);
        } elseif ($unit_type) {
            $query->where('unit_type', $unit_type);
        }

        $filter_results = $query->get();

        return response()->json([
            'filter_results' => $filter_results
        ]);
    }

    public function technicianDashboard()
    {
        if (!CRUDBooster::isSuperadmin() && !CRUDBooster::myPrivilegeId()) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), "You don't have permission to access this page!", 'warning');
        }

        $data = [];
        $data['totalOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('branch', 1)->count();
        $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('technician_id', CRUDBooster::myId())->count();
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
        $data['totalSalesOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->where('final_payment_status', 'PAID')->sum(DB::raw('parts_total_cost + diagnostic_cost'));
    
            

        return view('technician.admin_dashboard_custom', $data);
    }
}
