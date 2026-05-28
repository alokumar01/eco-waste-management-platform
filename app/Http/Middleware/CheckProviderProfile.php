<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProviderProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If the user and is a provider
        if ($user && $user->role === 'provider') {
            // EXEMPT the profile edit and update routes AND the logout route
            // Check both current path and full URL to be safe across environments
            if ($request->is('provider/profile*') || 
                $request->is('*/provider/profile*') || 
                $request->routeIs('provider.profile.*') ||
                $request->is('logout') || 
                $request->is('logout-now')) {
                return $next($request);
            }

            if (!$user->profile_completed) {
                return redirect()->route('provider.profile.edit')->with('error', 'Please complete your service provider profile first.');
            }
            
            // If they are on the dashboard and not verified, we let them see the dashboard 
            // but might show a notice. However, we should NOT throw a blocking error redirect 
            // if they are just trying to VIEW the dashboard.
            // We only block "actions" like creating services.
            
            if (!$user->is_verified && !$request->routeIs('provider.dashboard')) {
                return redirect()->route('provider.dashboard')->with('error', 'Your profile is pending manual verification by an Admin. You cannot access this feature yet.');
            }
        }

        return $next($request);
    }
}
