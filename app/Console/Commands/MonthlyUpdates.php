<?php

namespace App\Console\Commands;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PartnersController;
use Illuminate\Console\Command;

class MonthlyUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'montly:updates';

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
        $employee = new EmployeeController();
        $employee->NewEmployees();
    }
}
