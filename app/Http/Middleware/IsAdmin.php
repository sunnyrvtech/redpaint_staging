<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use View;

class IsAdmin
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
        if (Auth::check() && Auth::user()->role_id != 1) {
            return redirect()->to('/');
        } else if (!Auth::check()) {
            return response()->view('admin.accounts.login');
        }
        return $next($request);
    }
}
