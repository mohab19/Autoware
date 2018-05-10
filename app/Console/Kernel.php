<?php

namespace App\Console;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PartnersController;
use App\models\Employee;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
             Commands\Inspire::class,
             Commands\DailyUpdates::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daily:updates')->dailyAt('00:30')->timezone('Africa/Cairo');
        $schedule->command('monthly:updates')->monthlyOn(1,'00:30')->timezone('Africa/Cairo');

    }
}
