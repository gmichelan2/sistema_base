<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Closure;

class PrimerLogin
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
        if($request->user()->username!=='admin' && $request->user()->changedpassword===0){
            return redirect()->route('primerIngreso');
        }
        return $next($request);
    }
}
