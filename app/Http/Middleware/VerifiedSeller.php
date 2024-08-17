<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifiedSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->isVerified()) {
           Auth::guard('seller')->logout();
           Session::flash('fail', 'Your Account Is Not Verified - Check your email and try the link in order to verify your seller account');
           return to_route('seller.login');
        }
        return $next($request);
    }
}
