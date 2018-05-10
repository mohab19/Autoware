<?php

use Illuminate\Database\Seeder;

class PartnerSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=5;$i<=8;$i++)
        {
            $user = new \App\models\Partner();
            $user->user_id = $i;
            $user->save();
        }
        for($i=10;$i<=19;$i++)
        {
            $user = new \App\models\Partner();
            $user->user_id = $i;
            $user->save();
        }
        for($i=67;$i<68;$i++)
        {
            $user = new \App\models\Partner();
            $user->user_id = $i;
            $user->save();
        }
        $user = new \App\models\Partner();
        $user->user_id = 114;
        $user->save();
        $user = new \App\models\Partner();
        $user->user_id = 117;
        $user->save();
        $user = new \App\models\Partner();
        $user->user_id = 130;
        $user->save();
        for($i=134;$i<=135;$i++)
        {
            $user = new \App\models\Partner();
            $user->user_id = $i;
            $user->save();
        }

            $user = new \App\models\Partner();
            $user->user_id = 143;
            $user->save();







    }
}
