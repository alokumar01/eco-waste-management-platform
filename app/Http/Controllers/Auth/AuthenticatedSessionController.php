<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        
        // Clean up background AJAX/polling URLs from the intended redirect URL
        $intended = session()->get('url.intended');
        if ($intended && (
            str_contains($intended, 'notifications/unread-count') || 
            str_contains($intended, 'notifications/recent') ||
            (str_contains($intended, 'messages') && str_contains($intended, 'fetch'))
        )) {
            session()->forget('url.intended');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'provider') {
            if (!$user->profile_completed) {
                return redirect()->route('provider.profile.edit');
            }
            return redirect()->route('provider.dashboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        // DEFAULT: return redirect('/');

        return redirect('/');
    }
}
