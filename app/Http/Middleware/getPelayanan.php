<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\M_unit_pelayanan;

class getPelayanan
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
        $query = M_unit_pelayanan::select("*")->orderBy("order", "asc")->get();
        if(count($query) > 0){
            $request->request->add(['unit_pelayanan' => $query]);
        }else{
            $request->request->add(['unit_pelayanan' => array()]);
        }
        return $next($request);
    }
}
