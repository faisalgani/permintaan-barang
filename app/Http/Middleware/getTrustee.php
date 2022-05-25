<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class getTrustee
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
		if ($request->session()->exists('id_user')) {
            $response = app(\App\Http\Controllers\C_auth::class)->getTrustee($request->session()->get('id_user'));
            if(isset($response->original)){
                $request->request->add(['menu' => $response->original['menu']]);
            }
		}
		return $next($request);
    }
}
