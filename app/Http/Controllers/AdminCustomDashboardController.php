<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AdminCustomDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    private const CancelledClosed = 5;
    private const Custodian = 9;
    private const Frontliner = 3;
    private const Technician = 4;
    private const LeadTechnician = 8;
    private const OnGoingRepair = 34;
    private const OnGoingRepairOOW = 42;
    private const OngoingDiagnosis = 10;
    private const AwaitingAppleRepair = 17;
    private const AwaitingAppleRepairOOW = 26;
    private const AwaitingAppleRepairIW = 47;

    public function index(Request $request)
    {
        if (CRUDBooster::myPrivilegeId() != self::Frontliner) {
            return view('403_error_view.invalid_route');
        }

        $data['country'] = DB::table('refcountry')->get();

        $data['fl_abandoned_units_dash_count'] = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('job_order_logs.status_id', [19, 28])->where('returns_header.branch', CRUDBooster::me()->branch_id)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->where('returns_header.created_by', CRUDBooster::myId())
            ->count();

        $data['callout_type'] = DB::table('transaction_status')
            ->whereIn('id', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('status', '=', 'ACTIVE')->get();

        $data['aging_callouts'] = DB::table('returns_header')
            ->select('returns_header.*', 'latest_logs.transacted_at')
            ->leftJoinSub(
                DB::table('job_order_logs')
                    ->select('returns_header_id', DB::raw('MAX(transacted_at) as transacted_at'))
                    ->groupBy('returns_header_id'),
                'latest_logs',
                function ($join) {
                    $join->on('returns_header.id', '=', 'latest_logs.returns_header_id');
                }
            )
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->get();

        $today = Carbon::now();
        $normalCount = 0;
        $mediumCount = 0;
        $highCount = 0;
        $criticalCount = 0;

        foreach ($data['aging_callouts'] as $callout) {
            $lastUpdated = $callout->transacted_at
                ? Carbon::parse($callout->transacted_at)
                : Carbon::parse($callout->created_at);

            // Calculate age in days
            $ageDays = $lastUpdated->diffInDays($today);

            // Categorize based on age
            if ($ageDays <= 7) {
                $normalCount++;
            } elseif ($ageDays <= 14) {
                $mediumCount++;
            } elseif ($ageDays <= 30) {
                $highCount++;
            } else {
                $criticalCount++;
            }
            $callout->age_days = $ageDays;
        }

        // Add counts to the data array
        $data['normalCount'] = $normalCount;
        $data['mediumCount'] = $mediumCount;
        $data['highCount'] = $highCount;
        $data['criticalCount'] = $criticalCount;

        $data['my_cases'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'transaction_status.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'returns_header.repair_status')
            ->where('returns_header.created_by', '=', CRUDBooster::myId())
            ->orderBy('returns_header.id', 'DESC')
            ->get();

        $data['customers_units'] = DB::table('returns_header')
            ->where('branch', CRUDBooster::me()->branch_id)
            ->count();

        $data['fl_pending_call_out_dash_count_all'] = DB::table('returns_header')
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('created_by', CRUDBooster::myId())
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

    public function filterCustomerUnit(Request $request)
    {
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
        $data['myOngoingDiagnosis'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [self::OngoingDiagnosis])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['myOngoingRepair'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalAwaitingRepair'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->get();

        $data['totalCarryIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->where('returns_header.case_status', 'CARRY-IN')
            ->where('returns_header.branch', CRUDBooster::me()->branch_id)
            // ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalMailIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->where('returns_header.case_status', 'MAIL-IN')
            ->where('returns_header.branch', CRUDBooster::me()->branch_id)
            // ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalIW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->where('returns_header.warranty_status', 'IN WARRANTY')
            ->where('returns_header.branch', CRUDBooster::me()->branch_id)
            // ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalOOW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->where('returns_header.warranty_status', 'OUT OF WARRANTY')
            ->where('returns_header.branch', CRUDBooster::me()->branch_id)
            // ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

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

        $data['greenhillsOngoingDiagnosis'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingDiagnosis])->where('branch', 1)->count();
        $data['bonifacioOngoingDiagnosis'] =  DB::table('returns_header')->whereIn('repair_status', [self::OngoingDiagnosis])->where('branch', 2)->count();

        $data['greenhillsTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('branch', 1)->count();
        $data['bonifacioTotalRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])->where('branch', 2)->count();

        $data['greenhillsAwaitingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('branch', 1)->count();
        $data['bonifacioAwaitingRepair'] =  DB::table('returns_header')->whereIn('repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])->where('branch', 2)->count();

        $data['myOngoingRepair'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['myAwaitingRepair'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['myOngoingDiagnosis'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OngoingDiagnosis])
            ->where('returns_header.technician_id', CRUDBooster::myId())
            ->get();

        $data['totalCarryIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'CARRY-IN')
            ->get();

        $data['totalMailIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'MAIL-IN')
            ->get();

        $data['totalIW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'IN WARRANTY')
            ->get();

        $data['totalOOW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'OUT OF WARRANTY')
            ->get();

        $data['totalToAsign'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 9)
            ->get();

        $data['totalPedningAssigned'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 1)
            ->get();

        $data['totalRepairPerModel'] = DB::table('returns_header')
            ->join('model', 'returns_header.model', '=', 'model.id')
            ->select('model.model_name', DB::raw('COUNT(*) as total_repairs'))
            ->groupBy('model.model_name')
            ->orderByDesc('total_repairs')
            ->get();

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

    public function custodianDashboard(Request $request)
    {
        if (CRUDBooster::myPrivilegeId() != self::Custodian) {
            return view('403_error_view.invalid_route');
        }

        $data = [];
        $data['pending_mail_in_shipment_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('repair_status', [15, 16, 24, 25])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->get();

        $data['spare_parts_receiving_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('repair_status', [26, 33, 45, 47])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->get();

        $data['spare_parts_releasing_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('repair_status', [29, 39])
            ->where('branch', CRUDBooster::me()->branch_id)
            ->get();

        return view('custodian.custodian_dashboard_custom', $data);
    }

    public function managerDashboard()
    {
        if (CRUDBooster::myPrivilegeId() != 10) {
            return view('403_error_view.invalid_route');
        }

        $PBI = "https://app.powerbi.com/view?r=eyJrIjoiNzVhMTNmNTQtYjg4MS00YTQ1LTk4ZTctYmFjYjg5N2E5ODA2IiwidCI6ImVhNjUwNjA1LTVlOGQtNGRkNC1iNzhmLTAyZTNlZDVmZWQ5OCIsImMiOjEwfQ%3D%3D&pageName=62440140c8c03bc370a0";
        $data['PBI'] = $PBI;
        $data['branch'] = DB::table('branch')->where('branch_status', '=', 'ACTIVE')->get();

        // V-Mall Dashboard
        $vmall_branch = 1;

        $data['callout_type'] = DB::table('transaction_status')
            ->whereIn('id', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('status', '=', 'ACTIVE')->get();

        $data['aging_callouts'] = DB::table('returns_header')
            ->select('returns_header.*', 'latest_logs.transacted_at')
            ->leftJoinSub(
                DB::table('job_order_logs')
                    ->select('returns_header_id', DB::raw('MAX(transacted_at) as transacted_at'))
                    ->groupBy('returns_header_id'),
                'latest_logs',
                function ($join) {
                    $join->on('returns_header.id', '=', 'latest_logs.returns_header_id');
                }
            )
            ->whereIn('returns_header.repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $today = Carbon::now();
        $normalCount = 0;
        $mediumCount = 0;
        $highCount = 0;
        $criticalCount = 0;

        foreach ($data['aging_callouts'] as $callout) {
            $lastUpdated = $callout->transacted_at
                ? Carbon::parse($callout->transacted_at)
                : Carbon::parse($callout->created_at);

            // Calculate age in days
            $ageDays = $lastUpdated->diffInDays($today);

            // Categorize based on age
            if ($ageDays <= 7) {
                $normalCount++;
            } elseif ($ageDays <= 14) {
                $mediumCount++;
            } elseif ($ageDays <= 30) {
                $highCount++;
            } else {
                $criticalCount++;
            }
            $callout->age_days = $ageDays;
        }

        // Add counts to the data array
        $data['normalCount'] = $normalCount;
        $data['mediumCount'] = $mediumCount;
        $data['highCount'] = $highCount;
        $data['criticalCount'] = $criticalCount;

        $data['fl_pending_call_out_vmall'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['fl_abandoned_units_vmall'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('job_order_logs.status_id', [19, 28])
            ->where('returns_header.branch', $vmall_branch)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->get();

        $data['myOngoingRepair'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['myAwaitingRepair'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['myOngoingDiagnosis'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OngoingDiagnosis])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalCarryIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'CARRY-IN')
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalMailIn'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'MAIL-IN')
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalIW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'IN WARRANTY')
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalOOW'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'OUT OF WARRANTY')
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalToAsign'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 9)
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['totalPedningAssigned'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 1)
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['pending_mail_in_shipment_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [15, 16, 24, 25])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['spare_parts_receiving_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [26, 33, 45, 47])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['spare_parts_releasing_dash'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [29, 39])
            ->where('returns_header.branch', $vmall_branch)
            ->get();

        $data['handle_overall_total'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('returns_header.branch', $vmall_branch)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->count();

        $data['handle_for_all_employee_vmall'] = DB::table('returns_header')
            ->select(
                'returns_header.created_by as created_by_id',
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->where('returns_header.branch', $vmall_branch)
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();

        $data['handle_overall_total_tech_vmall'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            // ->where('cms_users.id_cms_privileges', 4)
            ->where('returns_header.branch', $vmall_branch)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->count();

        $data['handle_for_all_employee_tech_vmall'] = DB::table('returns_header')
            ->select(
                'returns_header.technician_id as assigned_tech',
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            // ->where('cms_users.id_cms_privileges', 4)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->where('returns_header.branch', $vmall_branch)
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();

        // BGC Dashboard
        $bgc_branch = 2;
        $data['aging_callouts_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'latest_logs.transacted_at')
            ->leftJoinSub(
                DB::table('job_order_logs')
                    ->select('returns_header_id', DB::raw('MAX(transacted_at) as transacted_at'))
                    ->groupBy('returns_header_id'),
                'latest_logs',
                function ($join) {
                    $join->on('returns_header.id', '=', 'latest_logs.returns_header_id');
                }
            )
            ->whereIn('returns_header.repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $today = Carbon::now();
        $normalCount = 0;
        $mediumCount = 0;
        $highCount = 0;
        $criticalCount = 0;

        foreach ($data['aging_callouts_bgc'] as $callout) {
            $lastUpdated = $callout->transacted_at
                ? Carbon::parse($callout->transacted_at)
                : Carbon::parse($callout->created_at);

            // Calculate age in days
            $ageDays = $lastUpdated->diffInDays($today);

            // Categorize based on age
            if ($ageDays <= 7) {
                $normalCount++;
            } elseif ($ageDays <= 14) {
                $mediumCount++;
            } elseif ($ageDays <= 30) {
                $highCount++;
            } else {
                $criticalCount++;
            }
            $callout->age_days = $ageDays;
        }

        // Add counts to the data array
        $data['normalCount_bgc'] = $normalCount;
        $data['mediumCount_bgc'] = $mediumCount;
        $data['highCount_bgc'] = $highCount;
        $data['criticalCount_bgc'] = $criticalCount;

        $data['fl_pending_call_out_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['fl_abandoned_units_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('job_order_logs.status_id', [19, 28])
            ->where('returns_header.branch', $bgc_branch)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->get();

        $data['myOngoingRepair_bgc'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['myAwaitingRepair_bgc'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['myOngoingDiagnosis_bgc'] =  DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->whereIn('returns_header.repair_status', [self::OngoingDiagnosis])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalCarryIn_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'CARRY-IN')
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalMailIn_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.case_status', 'MAIL-IN')
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalIW_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'IN WARRANTY')
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalOOW_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.warranty_status', 'OUT OF WARRANTY')
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalToAsign_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 9)
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['totalPedningAssigned_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name', 'ts.status_name', 'cms_users.name as assigned_tech')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->where('returns_header.repair_status', 1)
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['pending_mail_in_shipment_dash_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [15, 16, 24, 25])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['spare_parts_receiving_dash_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [26, 33, 45, 47])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['spare_parts_releasing_dash_bgc'] = DB::table('returns_header')
            ->select('returns_header.*', 'model.model_name')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->whereIn('returns_header.repair_status', [29, 39])
            ->where('returns_header.branch', $bgc_branch)
            ->get();

        $data['handle_overall_total_bgc'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('returns_header.branch', $bgc_branch)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->count();

        $data['handle_for_all_employee_bgc'] = DB::table('returns_header')
            ->select(
                'returns_header.created_by as created_by_id',
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.created_by')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 3)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->where('returns_header.branch', $bgc_branch)
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();

        $data['handle_overall_total_tech_bgc'] = DB::table('returns_header')
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 4)
            ->where('returns_header.branch', $bgc_branch)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->count();

        $data['handle_for_all_employee_tech_bgc'] = DB::table('returns_header')
            ->select(
                'returns_header.technician_id as assigned_tech',
                'cms_users.id as user_id',
                'cms_users.name as created_by_user',
                'cms_privileges.name as privilege_name',
                DB::raw('COUNT(*) as total_creations')
            )
            ->leftJoin('cms_users', 'cms_users.id', '=', 'returns_header.technician_id')
            ->leftJoin('cms_privileges', 'cms_privileges.id', '=', 'cms_users.id_cms_privileges')
            ->where('cms_users.id_cms_privileges', 4)
            ->where('cms_users.status', '=', 'ACTIVE')
            ->where('returns_header.branch', $bgc_branch)
            ->groupBy('cms_users.id', 'cms_users.name', 'cms_privileges.name')
            ->orderBy('total_creations', 'DESC')
            ->get();

        return view('manager.manager_custom_dashboard', $data);
    }

    public function managerDashboardPerEmployee(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'creator_id' => 'required|integer|exists:cms_users,id',
        ]);

        $creator_id = $validated['creator_id'];

        // Fetch employee data
        $employee_data = DB::table('returns_header')
            ->where('returns_header.created_by', $creator_id)
            ->get();

        // Count of abandoned units older than 90 days
        $abandoned_units_count = DB::table('returns_header')
            ->leftJoin('job_order_logs', 'job_order_logs.returns_header_id', '=', 'returns_header.id')
            ->whereIn('job_order_logs.status_id', [19, 28])
            ->where('returns_header.created_by', $creator_id)
            ->where('job_order_logs.transacted_at', '<=', Carbon::now()->subDays(90))
            ->count();

        // Count of pending callouts
        $pending_callouts_count = DB::table('returns_header')
            ->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])
            ->where('created_by', $creator_id)
            ->count();

        return response()->json([
            'success' => true,
            'data' => $employee_data,
            'abandoned_units_count' => $abandoned_units_count,
            'pending_callouts_count' => $pending_callouts_count,
        ]);
    }

    public function managerDashboardPerEmployeeTech(Request $request) {
        // Validate request
        $validated = $request->validate([
            'assigned_id' => 'required|integer|exists:cms_users,id',
        ]);

        $assigned_id = $validated['assigned_id'];

        $total_unaccepted_jo = DB::table('returns_header')
            ->where('returns_header.technician_id', $assigned_id)
            ->whereNull('returns_header.technician_accepted_at')
            ->count();

        $total_accepted_jo = DB::table('returns_header')
            ->where('returns_header.technician_id', $assigned_id)
            ->whereNotNull('returns_header.technician_accepted_at')
            ->count();

        $total_ongoing_jo = DB::table('returns_header')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [self::OnGoingRepair, self::OnGoingRepairOOW])
            ->where('returns_header.technician_id', $assigned_id)
            ->count();

        $total_awaiting_jo = DB::table('returns_header')
            ->leftJoin('model', 'model.id', '=', 'returns_header.model')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'returns_header.repair_status')
            ->whereIn('returns_header.repair_status', [self::AwaitingAppleRepair, self::AwaitingAppleRepairOOW, self::AwaitingAppleRepairIW])
            ->where('returns_header.technician_id', $assigned_id)
            ->count();

        return response()->json([
            'success' => true,
            'total_unaccepted_jo' => $total_unaccepted_jo,
            'total_accepted_jo' => $total_accepted_jo,
            'total_ongoing_jo' => $total_ongoing_jo,
            'total_awaiting_jo' => $total_awaiting_jo,
        ]);
    }
}
