<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PartnersController;
use Illuminate\Console\Command;

class DailyUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = new NotificationsController();
        $notifications->DailyNotifications();
        $partner = new PartnersController();
        $partner->NewPartners();
    }
}
