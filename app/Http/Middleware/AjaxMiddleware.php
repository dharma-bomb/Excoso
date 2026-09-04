<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {


        // $response = $next($request);

        // // Check if the session has expired
        // if (!$request->session()->exists()) {
        //     // Clear temporary data from the database or session variable
        //     // Example: Clear session variable
        //     $request->session()->forget('tempFormData');

        //     // Example: Clear temporary database table records
        //     // TemporaryFormData::where('created_at', '<', now()->subHours(1))->delete(); // Adjust as per your expiry logic
        // }

        // return $next($request);
    // }
}
