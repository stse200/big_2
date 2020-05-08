<?php

namespace App\Http\Middleware;

use Closure;
use App\Users;
use Illuminate\Support\Facades\Auth;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_admin = Users::select("is_admin")->where("id", Auth::user()->id)->first()->is_admin;
        if($is_admin){
          return $next($request);
        }
        else{
          return redirect("home");
        }
    }
}
