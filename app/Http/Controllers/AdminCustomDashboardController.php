<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
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

    private const OnGoingRepair = 34;
    private const OnGoingRepairOOW = 42;

    private const AwaitingAppleRepair = 17;
    private const AwaitingAppleRepairOOW = 26;
    private const AwaitingAppleRepairIW = 47;

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

        $data['fl_abandoned_units_dash_count'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('job_order_logs.status_id', [19, 28])->where('returns_header.branch', CRUDBooster::me()->branch_id)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->count();

        $data['callout_list'] = DB::table('transaction_status')
            ->whereIn('id', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('status', '=', 'ACTIVE')->get();

        $data['handle_per_employee'] = DB::table('returns_header')
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

        $data['customers_units'] = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();

        $data['customers_info'] = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->whereNotNull('country')
            ->whereNotNull('province')
            ->whereNotNull('city')
            ->whereNotNull('barangay')
            ->count();

        $data['fl_pending_call_out_dash_count_all'] = DB::table('returns_header')
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->count();

        $data['time_motion'] = DB::table('returns_header')
            ->select(
                'returns_header.*',
                'createdby.name as creator',
                'leadtech.name as lead_tech',
                'tech.name as technician',
                'transaction_status.status_name',
                DB::raw('MAX(CASE WHEN job_order_logs.status_id = 6 THEN job_order_logs.transacted_at ELSE NULL END) AS end_timestamp')
            )
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users as createdby', 'createdby.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_users as leadtech', 'leadtech.id', '=', 'returns_header.lead_technician_id')
            ->leftJoin('cms_users as tech', 'tech.id', '=', 'returns_header.technician_id')
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

    function getTimeline(Request $request)
    {

        $get_timeline_data = DB::table('job_order_logs')
            ->select('job_order_logs.*', 'transaction_status.status_name', 'cms_users.name')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'job_order_logs.status_id')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'job_order_logs.transacted_by')
            ->where('returns_header_id', $request->id)
            ->get();

        if ($get_timeline_data) {
            return response()->json(['success' => true, 'data' => $get_timeline_data]);
        }
    }

    function getAgingCallout(Request $request)
    {

        $data['fl_aging_call_out_dash_count_0_14'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('returns_header.repair_status', [$request->call_out_id])->where('returns_header.branch', CRUDBooster::me()->branch_id)
            ->whereBetween('job_order_logs.transacted_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->count();
        $data['fl_aging_call_out_dash_count_15_30'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('returns_header.repair_status', [$request->call_out_id])->where('returns_header.branch', CRUDBooster::me()->branch_id)
            ->whereBetween('job_order_logs.transacted_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(15)])
            ->count();
        $data['fl_aging_call_out_dash_count_30_plus'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('returns_header.repair_status', [$request->call_out_id])->where('returns_header.branch', CRUDBooster::me()->branch_id)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(30))
            ->count();

        return response()->json(['success' => true, 'data' => $data]);
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

    public function technicianDashboard(Request $request)
    {
        if (CRUDBooster::myPrivilegeId() != self::Technician) {
            return view('403_error_view.invalid_route');
        }

        $data = [];
        $data['branchName'] = DB::table('branch')->where('id', CRUDBooster::me()->branch_id)->value('branch_name');;
        $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('technician_id', CRUDBooster::myId())->count();
        $data['totalAwaitingRepair'] = DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('technician_id', CRUDBooster::myId())->count();

        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->get();

        $data['totalCarryIn'] = DB::table('returns_header')->where('case_status', 'CARRY-IN')->where('branch', CRUDBooster::me()->branch_id)->count();
        $data['totalMailIn'] = DB::table('returns_header')->where('case_status', 'MAIL-IN')->where('branch', CRUDBooster::me()->branch_id)->count();

        $data['totalIW'] = DB::table('returns_header')->where('warranty_status', 'IN WARRANTY')->where('branch', CRUDBooster::me()->branch_id)->count();
        $data['totalOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->where('branch', CRUDBooster::me()->branch_id)->count();

        $data['time_motion'] = DB::table('returns_header')
            ->select(
                'returns_header.*',
                'createdby.name as creator',
                'leadtech.name as lead_tech',
                'tech.name as technician',
                'transaction_status.status_name',
                DB::raw('MAX(CASE WHEN job_order_logs.status_id = 6 THEN job_order_logs.transacted_at ELSE NULL END) AS end_timestamp')
            )
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users as createdby', 'createdby.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_users as leadtech', 'leadtech.id', '=', 'returns_header.lead_technician_id')
            ->leftJoin('cms_users as tech', 'tech.id', '=', 'returns_header.technician_id')
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->groupBy('returns_header.id', 'transaction_status.status_name')
            ->orderBy('returns_header.id', 'DESC')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('frontliner.admin_dashboard_tm_table', ['time_motion' => $data['time_motion']])->render(),
                'pagination' => view('frontliner.admin_dashboard_tm_pagination', ['time_motion' => $data['time_motion']])->render(),
            ]);
        }


        return view('technician.admin_dashboard_custom', $data);
    }

    public function headTechnicianDashboard(Request $request)
    {
        if (CRUDBooster::myPrivilegeId() != self::LeadTechnician) {
            return view('403_error_view.invalid_route');
        }

        $data = [];
        $data['greenhills'] = DB::table('branch')->where('id', 1)->value('branch_name');;
        $data['bonifacio'] = DB::table('branch')->where('id', 2)->value('branch_name');;

        $data['greenhillsTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('branch', 1)->count();
        $data['bonifacioTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('branch', 2)->count();

        $data['greenhillsAwaitingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('branch', 1)->count();
        $data['bonifacioAwaitingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('branch', 2)->count();

        $data['myOngoingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('technician_id', CRUDBooster::myId())->count();
        $data['myAwaitingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('technician_id', CRUDBooster::myId())->count();

        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->get();


        $data['totalCarryIn'] = DB::table('returns_header')->where('case_status', 'CARRY-IN')->count();
        $data['totalMailIn'] = DB::table('returns_header')->where('case_status', 'MAIL-IN')->count();

        $data['totalIW'] = DB::table('returns_header')->where('warranty_status', 'IN WARRANTY')->count();
        $data['totalOOW'] = DB::table('returns_header')->where('warranty_status', 'OUT OF WARRANTY')->count();

        $data['time_motion'] = DB::table('returns_header')
            ->select(
                'returns_header.*',
                'createdby.name as creator',
                'leadtech.name as lead_tech',
                'tech.name as technician',
                'transaction_status.status_name',
                DB::raw('MAX(CASE WHEN job_order_logs.status_id = 6 THEN job_order_logs.transacted_at ELSE NULL END) AS end_timestamp')
            )
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users as createdby', 'createdby.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_users as leadtech', 'leadtech.id', '=', 'returns_header.lead_technician_id')
            ->leftJoin('cms_users as tech', 'tech.id', '=', 'returns_header.technician_id')
            ->groupBy('returns_header.id', 'transaction_status.status_name')
            ->orderBy('returns_header.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return response()->json([
                'table' => view('frontliner.admin_dashboard_tm_table', ['time_motion' => $data['time_motion']])->render(),
                'pagination' => view('frontliner.admin_dashboard_tm_pagination', ['time_motion' => $data['time_motion']])->render(),
            ]);
        }

        return view('headtechnician.admin_dashboard_custom', $data);
    }

    public function managerDashboard(Request $request)
    {
        $data['branch'] = DB::table('branch')->where('branch_status', '=', 'ACTIVE')->get();
        $data['all_call_out_status'] = DB::table('transaction_status')
            ->whereIn('id', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('status', '=', 'ACTIVE')->get();

        $data['fl_pending_call_out_dash_count_all'] = DB::table('returns_header')
            ->addSelect('returns_header.*')
            ->addSelect('transaction_status.status_name')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->get()
            ->groupBy('branch')
            ->map(function ($items) {
                return [
                    'total' => $items->count(),
                    'data' => $items,
                ];
            });

        $data['fl_abandoned_units_dash_count_all'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->select('returns_header.branch', DB::raw('COUNT(*) as total'))
            ->whereIn('job_order_logs.status_id', [19, 28])
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->groupBy('returns_header.branch')
            ->pluck('total', 'returns_header.branch');

        $data['handle_overall_total'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->select('returns_header.branch', DB::raw('COUNT(*) as total'))
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->groupBy('returns_header.branch')
            ->pluck('total', 'returns_header.branch');

        $data['handle_per_employee'] = DB::table('returns_header')
            ->select(
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_users.photo as user_profile',
                'cms_privileges.name as privilege_name',
                'returns_header.branch',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name', 'returns_header.branch')
            ->orderBy('total_creations', 'DESC')
            ->get()
            ->groupBy('branch');

        $data['tech_ongoing_repair_cases'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $data['tech_awaiting_repair_cases'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->whereIn('repair_status', [
                self::AwaitingAppleRepair,
                self::AwaitingAppleRepairOOW,
                self::AwaitingAppleRepairIW
            ])
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $data['totalIW'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->where('warranty_status', 'IN WARRANTY')
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $data['totalOOW'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->where('warranty_status', 'OUT OF WARRANTY')
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $data['totalCarryIn'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->where('case_status', 'CARRY-IN')
            ->groupBy('branch')
            ->pluck('total', 'branch');

        $data['totalMailIn'] = DB::table('returns_header')
            ->select('branch', DB::raw('COUNT(*) as total'))
            ->where('case_status', 'MAIL-IN')
            ->groupBy('branch')
            ->pluck('total', 'branch');


        return view('manager.manager_custom_dashboard', $data);
    }

    public function getFilteredCalloutCount(Request $request)
    {
        $statusId = $request->status_id;
        $branchId = $request->branch_id;

        $query = DB::table('returns_header')
            ->where('branch', $branchId)
            ->where('repair_status', $statusId);

        $count = (clone $query)->count();
        $data = $query->get();

        return response()->json([
            'count' => $count,
            'data' => $data,
        ]);
    }

    public function getSalesData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $branchId = $request->input('branch_id');

        // Apply year filter for Weekly and Monthly
        $weeklySales = DB::table('returns_header')
            ->whereNotIn('repair_status', [self::OnGoingRepair, self::CancelledClosed])
            ->whereYear('created_at', $year)
            ->where('branch', $branchId)
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
            ->whereNotIn('repair_status', [self::OnGoingRepair, self::CancelledClosed])
            ->whereYear('created_at', $year)
            ->where('branch', $branchId)
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
            ->whereNotIn('repair_status', [self::OnGoingRepair, self::CancelledClosed])
            ->where('branch', $branchId)
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
}
