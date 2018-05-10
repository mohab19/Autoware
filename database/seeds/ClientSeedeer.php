<?php

use Illuminate\Database\Seeder;

class ClientSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=20;$i<=66;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=68;$i<=90;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=93;$i<=113;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=115;$i<=116;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=118;$i<=129;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=131;$i<=133;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=136;$i<=142;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
        for($i=144;$i<=153;$i++)
        {
            $user = new \App\models\Client();
            $user->user_id = $i;
            $user->save();
        }
    }
}
