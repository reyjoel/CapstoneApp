<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
            switch ($guard) {
                case 'web_admin':
                    if (Auth::guard($guard)->check()) {
                        return redirect()->route('admin.home');
                    }
                    break;
                case 'web_student':
                    if (Auth::guard($guard)->check()) {
                        return redirect()->route('student.home');
                    }
                    break;
                case 'web_driver':
                    if (Auth::guard($guard)->check()) {
                        return redirect()->route('driver.home');
                    }
                    break;

                case 'web_guardian':
                    if (Auth::guard($guard)->check()) {
                        return redirect()->route('guardian.home');
                    }
                    break;

                default:
                    break;
            }

        return $next($request);
    }
}
