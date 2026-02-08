<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set role-specific session cookie name if user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $sessionName = 'ditascom_' . $user->role . '_session';
            config(['session.cookie' => $sessionName]);
        }

        return $next($request);
    }
}
