<?php

use Illuminate\Database\Seeder;

class OutComesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\models\OutComesType::create(['name' => 'PartnerSalary']);
        \App\models\OutComesType::create(['name' => 'PartnerCommission']);
        \App\models\OutComesType::create(['name' => 'EmployeeSalary']);
        \App\models\OutComesType::create(['name' => 'EmployeePenalty']);
        \App\models\OutComesType::create(['name' => 'CarExpenses']);
        \App\models\OutComesType::create(['name' => 'GeneralExpenses']);
        \App\models\OutComesType::create(['name' => 'PartnerDeptCommission']);
    }
}
