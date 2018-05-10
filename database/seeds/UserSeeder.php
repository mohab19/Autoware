<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->first_name = "Admin";
        $user->last_name = "";
        $user->birthdate = "";
        $user->address = "";
        $user->password  = bcrypt("admin");
        $user->email = "admin";
        $user->phone = "";
        $user->national_id = "";
        $user->role_id = "1";
        $user->save();
//        for($i=1;$i<=5;$i++)
//        {
//            $user = new \App\User();
//            $user->first_name = "Client";
//            $user->last_name = "#".$i;
//            $user->birthdate = "7-7-1996";
//            $user->address = "Ain Shams";
//            $user->password  = bcrypt("admin");
//            $user->email = "client".$i."@gmail.com";
//            $user->phone = "0123449365";
//            $user->national_id = "123456";
//            $user->role_id = "4";
//            $user->save();
//        }
//        for($i=1;$i<=5;$i++)
//        {
//            $user = new \App\User();
//            $user->first_name = "Partner";
//            $user->last_name = "#".$i;
//            $user->birthdate = "7-7-1996";
//            $user->address = "Ain Shams";
//            $user->password  = bcrypt("0123449365");
//            $user->email = "partner".$i."@gmail.com";
//            $user->phone = "0123449365";
//            $user->national_id = "123456";
//            $user->role_id = "2";
//            $user->save();
//        }
//        for($i=1;$i<=5;$i++)
//        {
//            $user = new \App\User();
//            $user->first_name = "Employee";
//            $user->last_name = "#".$i;
//            $user->birthdate = "7-7-1996";
//            $user->address = "Ain Shams";
//            $user->password  = bcrypt("0123449365");
//            $user->email = "employee".$i."@gmail.com";
//            $user->phone = "0123449365";
//            $user->national_id = "123456";
//            $user->role_id = "3";
//            $user->save();
//        }

    }
}
