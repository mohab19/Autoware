<?php

namespace App\Policies;

use App\models\Roles;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolesPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {
    }

    public function admin($user,$roles)
    {
        return $user->role->name == "Admin";
    }

    public function partner(User $user)
    {
        return $user->role->name == "Partner";
    }

    public function employee(User $user)
    {
        return $user->role->name == "Employee";
    }

    public function customer(User $user)
    {
        return $user->role->name == "Customer";
    }
}
