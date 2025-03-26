<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CRUDBooster;

class AdminCustomDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function index()
    {
        if (!CRUDBooster::isSuperadmin() && !CRUDBooster::myPrivilegeId()) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), "You don't have permission to access this page!", 'warning');
        }

        // Custom Data (Fetch any statistics or details you need)
        // $totalUsers = \DB::table('users')->count();
        // $totalOrders = \DB::table('orders')->count();

        return view('frontliner.admin_dashboard_custom');
    }
}
