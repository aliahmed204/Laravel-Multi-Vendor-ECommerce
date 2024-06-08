<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

            if ($request->routeIs('admin.*')){
                session()->flash('fail', 'Please Login First');
                return route('admin.login');
            }

            if ($request->routeIs('seller.*')){
                session()->flash('fail', 'Please Login First');
                return route('seller.login');
            }

            if ($request->routeIs('client.*')){
                session()->flash('fail', 'Please Login First');
                return route('client.login');
            }
        }
    }
}
