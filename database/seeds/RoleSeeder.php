<?php

use App\Http\Utils\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder     extends Seeder
{

    protected $permissions;
    public function __construct()
    {
        $this->permissions = new Permission();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\models\Roles::create([
            'name' => "Admin",
            'description'=> "User that have all permissions in the system",
            'permissions' => json_encode(["overview","admins","clients","employees","partners","cars","reservations","waiting","recive",
                "expenses","reports","partner","employee","client","settings"])
        ]);

        \App\models\Roles::create([
            'name' => "Partner",
            'description'=> "User that have a car that he wants to rent it",
            'permissions' => json_encode(['PartnerPanel'])
        ]);

        \App\models\Roles::create([
            'name' => "Employee",
            'description'=> "User that handle rents and invoices in the system",
            'permissions' => json_encode(['quickaccess','clients','reservations','waiting','recive','expenses','cars'])
        ]);
        \App\models\Roles::create([
            'name' => "Customer",
            'description'=> "User that handle rents and invoices in the system",
            'permissions' => json_encode([''])
        ]);
    }
}
