<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use App\Models\Customer;
use App\Models\Driver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->header('Authorization');
        if (!Str::startsWith($token, 'DRV' )){
            throw new AuthenticationException();
        }

        $driverId = Driver::accessToken($token)->first(['id']);
        if (is_null($driverId)){
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
