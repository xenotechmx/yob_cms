<?php

namespace MetodikaTI\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use MetodikaTI\Console\Commands\DisabledJobs;
use MetodikaTI\Console\Commands\DisabledPackages;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DisabledJobs::class,
        DisabledPackages::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('disabled:jobs')->everyMinute();
        $schedule->command('disabled:package')->everyMinute();

        $schedule->command('checkpendingpayment:card')->everyFiveMinutes();
        $schedule->command('checkpendingpayment:oxxo')->everyThirtyMinutes();

        //$schedule->command('checkpendingpayment:card')->everyMinute()->sendOutputTo("cron_job_oxxo.txt");
        //$schedule->command('checkpendingpayment:oxxo')->everyMinute()->sendOutputTo("cron_job_oxxo.txt");

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
