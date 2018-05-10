<?php

namespace App\Http\Middleware;

use App\Http\Utils\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;

class RegisterPermitter extends Permission
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $this->CheckPermission($this->user->role->name,$request->role);
        return $next($request);
    }
}
