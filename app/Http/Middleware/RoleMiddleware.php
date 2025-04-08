<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // if (!Auth::check() || Auth::user()->role !== $role) {
        //     return redirect('/login'); // Or any other route
        // }

        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user's role matches any of the allowed roles
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->back()->with('error', "Anda tidak memiliki akses");
        }

        return $next($request);
    }
}
