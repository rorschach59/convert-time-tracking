<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Problème d'heure sur le serveur
        $hour = '16:00';
        $schedule->command('app:report daily')
            ->dailyAt($hour)
            ->appendOutputTo('./storage/logs/daily.log');

        $schedule->command('app:report weekly')
            ->fridays()
            ->at($hour)
            ->appendOutputTo('./storage/logs/weekly.log');
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
