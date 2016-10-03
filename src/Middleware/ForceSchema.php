<?php

namespace Lab1353\Monkyz\Middleware;

use Config;
use Closure;
use Illuminate\Http\Request;

class ForceSchema
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
		$use_https = config('monkyz.use_https');

        Request::setTrustedProxies([$request->getClientIp()]);
        if (!$request->isSecure() && $use_https) {
        	return redirect()->secure($request->getRequestUri());
        } elseif ($request->isSecure() && !$use_https) {
        	return redirect()->to($request->getRequestUri(), 302, array(), false);;
        }
        return $next($request);
	}
}
