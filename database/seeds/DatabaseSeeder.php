<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(RoleSeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(ClientSeedeer::class);
        $this->call(PartnerSeedeer::class);
//        $this->call(EmployeeSeedeer::class);
//        $this->call(RentalTypesSeeder::class);
//        $this->call(InComesTypesSeeder::class);
//        $this->call(OutComesTypesSeeder::class);
    }
}
