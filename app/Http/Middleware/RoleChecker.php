<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Utils\Permission;
use App\models\Roles;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class RoleChecker extends Permission
{

    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $permission 
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        $this->CheckPermission($this->user->role->name,$permission);
        return $next($request);
    }
}
