<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Services\RandomUserServices;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $randomUserServices = new RandomUserServices();
            $randomUserServices->createUser();
            $randomUserServices->countRecord();
        })->hourly();

        $schedule->call(function () {
            $randomUserServices = new RandomUserServices();
            $randomUserServices->eod();
        })
        ->dailyAt('17:00');


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
