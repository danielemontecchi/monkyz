<?php

namespace Lab1353\Monkyz\Middleware;

use Closure;
use Auth;

class AdminAccess
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (!Auth::check()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->route('monkyz.users.login');
			}
		}

		return $next($request);
	}
}
