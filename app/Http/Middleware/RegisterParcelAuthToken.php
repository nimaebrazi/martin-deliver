<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterParcelAuthToken
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
        if (!Str::startsWith($token, 'CU' )){
            throw new AuthenticationException();
        }

        $customerId = Customer::accessToken($token)->first(['id']);
        if (is_null($customerId)){
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
