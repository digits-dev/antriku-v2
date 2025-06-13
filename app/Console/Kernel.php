<?php

namespace App\Console;

use App\Http\Controllers\AdminProductItemMasterController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TaskCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('task:cron')->everyFiveMinutes();
        
        $schedule->call(function(){
            $productSync = new AdminProductItemMasterController();
            $productSync->getPartsItemsCreatedAPI();
            $productSync->getItemsCreatedAPI();
        })->hourly()->between('9:00', '23:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
