<?php

use App\models\RentalType;
use Illuminate\Database\Seeder;

class RentalTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RentalType::create(['name' => 'ايجار']);
        RentalType::create(['name' => 'عمولة']);
    }
}
