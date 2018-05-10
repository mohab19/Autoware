<?php

namespace App\Http\Utils;

use App\models\Roles;

class Permission
{
    public function CheckPermission($role,$permission)
    {
        $roles = Roles::all();
        $permissions = $this->Make_Roles($roles);
        foreach ($permissions as $key => $roles)
        {
            for($i = 0; $i < sizeof($permissions[$key]);$i++)
            {
                if($key == $role && $permissions[$key][$i] == $permission)
                    return 1;
            }
        }
        abort(403,'Unauthorized action.');
    }

    protected function Make_Roles($roles)
    {
        $permissions = array();
        foreach($roles as $role)
        {
            $permissions[$role->name] = json_decode($role->permissions);
        }
        return $permissions;
    }
    
}