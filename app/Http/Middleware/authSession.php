<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class authSession
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
		if (!$request->session()->exists('id_user')) {
			return redirect()->route('/');
		}
		return $next($request);
    }
}
