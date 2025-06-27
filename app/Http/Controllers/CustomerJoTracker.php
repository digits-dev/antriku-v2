<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerJoTracker extends Controller
{
    public function credentials()
    {
        return view('FrontEnd.customer_jo_tracker_credentials');
    }

    public function startTracking(Request $request)
    {
        $request->validate([
            'referenceNumber' => 'required'
        ]);

        $referenceNumber = $request->referenceNumber;

        $jo_details = DB::table('returns_header')
            ->select(
                'returns_header.*',
                'm.model_name',
                'b.branch_name',
                'b.branch_contact',
                'b.branch_address',
                'b.branch_schedule',
                'cu.name as cu_name'
            )
            ->leftJoin('model as m', 'm.id', '=', 'returns_header.model')
            ->leftJoin('branch as b', 'b.id', '=', 'returns_header.branch')
            ->leftJoin('cms_users as cu', 'cu.id', '=', 'returns_header.technician_id')
            ->where('reference_no', $referenceNumber)
            ->first();

        if (!$jo_details) {
            return redirect()->back()->with('error', 'Reference number not found.');
        }

        // Start session timer (optional)
        $sessionKey = 'tracking_ref_' . $referenceNumber;
        if (!session($sessionKey)) {
            session()->put($sessionKey, true);
            session()->put($sessionKey . '_timestamp', now()->addMinutes(30));
        } else {
            if (now()->greaterThan(session($sessionKey . '_timestamp'))) {
                session()->forget($sessionKey);
                session()->forget($sessionKey . '_timestamp');
                return redirect()->back()->with('error', 'Tracking session expired. Please re-enter the reference number.');
            }
        }

        $jo_logs = DB::table('job_order_logs')
            ->select('job_order_logs.*', 'ts.status_name as logs_name')
            ->leftJoin('transaction_status as ts', 'ts.id', '=', 'job_order_logs.status_id')
            ->where('returns_header_id', $jo_details->id)
            ->get();

        return view('FrontEnd.customer_jo_tracker', [
            'jo_details' => $jo_details,
            'jo_logs' => $jo_logs
        ]);
    }
}
