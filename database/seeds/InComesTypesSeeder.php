<?php

use Illuminate\Database\Seeder;

class InComesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\models\InComesType::create(['name' => 'Renting']);
        \App\models\InComesType::create(['name' => 'Dept']);
        \App\models\InComesType::create(['name' => 'KM']);
    }
}
