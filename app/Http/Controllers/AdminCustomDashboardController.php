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
    private const Frontliner = 3;
    private const Technician = 4;
    private const LeadTechnician = 8;

    public function index(Request $request)
    {
        if (CRUDBooster::myPrivilegeId() != self::Frontliner) {
            return view('403_error_view.invalid_route');
        }

		$data['country'] = DB::table('refcountry')->get();    
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
        
        $data['customers_units'] = $handle_per_employee = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();

        $data['customers_info'] = $handle_per_employee = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->whereNotNull('country')
            ->whereNotNull('province')
            ->whereNotNull('city')
            ->whereNotNull('barangay')
            ->count();
        
        $data['time_motion'] = DB::table('returns_header')
            ->select(
                'returns_header.*',
                'transaction_status.status_name',
                DB::raw('MIN(call_out_recorder.call_out_at) as first_timestamp'),
            )
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->leftJoin('call_out_recorder', 'call_out_recorder.returns_header_id', '=', 'returns_header.id')
            ->whereIn('repair_status', [21, 6])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->groupBy('returns_header.id', 'transaction_status.status_name')
            ->orderBy('returns_header.id', 'DESC')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('frontliner.admin_dashboard_tm_table', ['time_motion' => $data['time_motion']])->render(),
                'pagination' => view('frontliner.admin_dashboard_tm_pagination', ['time_motion' => $data['time_motion']])->render(),
            ]);
        }

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
                DB::raw('SUM(parts_total_cost + diagnostic_cost) as total')
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
                DB::raw('SUM(parts_total_cost + diagnostic_cost) as total')
            )
            ->groupBy('year', 'month_number', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month_number', 'asc')
            ->get();

        $ytdSales = DB::table('returns_header')
            ->whereNotIn('repair_status', [self::OngoingRepair, self::CancelledClosed])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(parts_total_cost + diagnostic_cost) as total')
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
            'ytd' => [
                'labels' => $ytdSales->pluck('year')->toArray(),
                'data' => $ytdSales->pluck('total')->toArray()
            ],
        ]);
    }

    public function filterCustomerUnit(Request $request)
    {
        $date_from = $request->input('date_range_from');
        $date_to = $request->input('date_range_to');
        $perPage = 10; 

        $query = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->select(
                'returns_header.*',
                'returns_header.reference_no',
                'model.model_name',
                'returns_header.last_name',
                'returns_header.first_name',
                'returns_header.city',
                'returns_header.created_at',
                'transaction_status.status_name'
            );

        if ($request->has('search_input')) {
            $search = $request->search_input;
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'LIKE', "%$search%")
                ->orWhere('model_name', 'LIKE', "%$search%")
                ->orWhere('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('contact_no', 'LIKE', "%$search%")
                ->orWhere('status_name', 'LIKE', "%$search%");
            });
        }
            
            // if (!empty($date_from) && !empty($date_to)) {
            //     $query->whereBetween(DB::raw("DATE(returns_header.created_at)"), [$date_from, $date_to]);
            // } elseif (!empty($date_from)) {
            //     $query->whereDate('returns_header.created_at', '>=', $date_from);
            // } elseif (!empty($date_to)) {
            //     $query->whereDate('returns_header.created_at', '<=', $date_to);
            // }

        $filter_results = $query->paginate($perPage);

        return response()->json($filter_results);
    }

    public function filterCustomerInfo(Request $request)
    {
        $country = $request->input('country');
        $province = $request->input('province');
        $city = $request->input('city');
        $brgy = $request->input('brgy');
        $perPage = 10; 
    
        $query = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->whereNotNull('country')
            ->whereNotNull('province')
            ->whereNotNull('city')
            ->whereNotNull('barangay')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->select(
                'returns_header.*',
                'model.model_name',
                'transaction_status.status_name'
            );
    
        // Apply filters
        if ($country) {
            $query->where('returns_header.country', $country);
        }
        if ($province) { 
            $query->where('returns_header.province', $province);
        }
        if ($city) {
            $query->where('returns_header.city', $city);
        }
        if ($brgy) {
            $query->where('returns_header.barangay', $brgy);
        }
    
        $filter_results = $query->paginate($perPage);
    
        return response()->json($filter_results);
    }    

    public function technicianDashboard()
    {
        if (CRUDBooster::myPrivilegeId() != self::Technician) {
            return view('403_error_view.invalid_route');
        }

        $data = [];
        $data['branchName'] = DB::table('branch')->where('id', CRUDBooster::me()->branch_id)->value('branch_name');;
        $data['totalOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('branch', CRUDBooster::me()->branch_id)->count();
        $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('technician_id', CRUDBooster::myId())->count();
        $data['totalPendingCustomerPayment'] = DB::table('returns_header')->where('repair_status', self::PendingCustomerPayment)->where('technician_id', CRUDBooster::myId())->count();
        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->paginate(10);

        $data['totalCarryIn'] = DB::table('returns_header')->where('case_status', 'CARRY-IN')->where('branch', CRUDBooster::me()->branch_id)->count();
        $data['totalMailIn'] = DB::table('returns_header')->where('case_status', 'MAIL-IN')->where('branch', CRUDBooster::me()->branch_id)->count();

        $data['totalIW'] = DB::table('returns_header')->where('warranty_status', 'IN WARRANTY')->where('branch', CRUDBooster::me()->branch_id)->count();
        $data['totalOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->where('branch', CRUDBooster::me()->branch_id)->count();
    
    
            

        return view('technician.admin_dashboard_custom', $data);
    }

    public function headTechnicianDashboard()
    {
        if (CRUDBooster::myPrivilegeId() != self::LeadTechnician) {
            return view('403_error_view.invalid_route');
        }

        $data = [];
        $data['greenhills'] = DB::table('branch')->where('id', 1)->value('branch_name');;
        $data['bonifacio'] = DB::table('branch')->where('id', 2)->value('branch_name');;
        $data['greenhillsTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('branch', 1)->count();
        $data['bonifacioTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('branch', 2)->count();
        $data['totalOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->count();
        // $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingRepair, self::ReplacementPartsPaid, self::SparePartsReceived, self::ForPartsOrdering])->where('technician_id', CRUDBooster::myId())->count();
        $data['totalPendingCustomerPayment'] = DB::table('returns_header')->where('repair_status', self::PendingCustomerPayment)->where('technician_id', CRUDBooster::myId())->count();
        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->paginate(10);

        $data['totalCarryIn'] = DB::table('returns_header')->where('case_status', 'CARRY-IN')->count();
        $data['totalMailIn'] = DB::table('returns_header')->where('case_status', 'MAIL-IN')->count();

        $data['totalIW'] = DB::table('returns_header')->where('warranty_status', 'IN WARRANTY')->count();
        $data['totalOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->count();
    
            

        return view('headtechnician.admin_dashboard_custom', $data);
    }
}