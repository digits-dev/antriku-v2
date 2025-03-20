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
        $ongoingRepairCount = DB::table('returns_header')->whereIn('repair_status', [13, 18, 19])->count();
        View::share('ongoing_repair_count', $ongoingRepairCount);

        $sparePartsReceiveCount = DB::table('returns_header')->where('repair_status', 15)->count();
        View::share('spare_part_receive_count', $sparePartsReceiveCount);
    }
}