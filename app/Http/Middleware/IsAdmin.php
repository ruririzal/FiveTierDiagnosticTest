<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Gate;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if( ! \Auth::user()->is_admin){
            return abort(404);
        }
        
        return $next($request);
    }
}
