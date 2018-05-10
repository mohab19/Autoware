<?php

use Illuminate\Database\Seeder;

class EmployeeSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=12;$i<=16;$i++)
        {
            $user = new \App\models\Employee();
            $user->user_id = $i;
            $user->salary = 5000;
            $user->save();
        }
    }
}
