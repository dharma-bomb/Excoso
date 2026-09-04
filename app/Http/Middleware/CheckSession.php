<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        // The login page itself: if someone is already logged in and lands
        // back here, force a fresh login instead of silently reusing the
        // old session.
        if ($request->routeIs('admin.login')) {
            if (Session::has('admin_id')) {
                Session::flush();
                Auth::logout();
            }
            return $next($request);
        }

        // Registration stays open (this is how the first/only admin account
        // gets created) — no session required to reach it.
        if ($request->routeIs('admin.register')) {
            return $next($request);
        }

        // Every other admin.* route (dashboard, product list/add/edit/delete,
        // categories, users) requires an active admin session.
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('status', 'Please log in to continue.');
        }

        return $next($request);
    }
}
