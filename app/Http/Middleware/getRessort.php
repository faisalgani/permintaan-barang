<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\M_departemen;

class getRessort
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $query = M_departemen::select("*")->where("active", "=" , true)->orderBy("order", "asc")->get();
        if(count($query) > 0){
            $request->request->add(['ressort' => $query]);
        }else{
            $request->request->add(['ressort' => array()]);
        }
        return $next($request);
    }
}
