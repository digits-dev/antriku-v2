<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $ongoingRepairCount = DB::table('returns_header')->whereIn('repair_status', [13, 15, 18, 19])->count();
        View::share('ongoing_repair_count', $ongoingRepairCount);

        $fl_pending_call_out_dash_count = DB::table('returns_header')->whereIn('repair_status', [10, 21])->count();
        View::share('fl_pending_call_out_dash_count', $fl_pending_call_out_dash_count);
    }
}