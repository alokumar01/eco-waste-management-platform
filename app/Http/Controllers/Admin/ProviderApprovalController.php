<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ProviderApprovalController extends Controller
{
    public function approve(User $provider): RedirectResponse
    {
        abort_unless($provider->isProvider(), 404);

        $provider->update([
            'provider_status' => User::PROVIDER_APPROVED,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Provider profile approved.');
    }

    public function reject(User $provider): RedirectResponse
    {
        abort_unless($provider->isProvider(), 404);

        $provider->update([
            'provider_status' => User::PROVIDER_REJECTED,
            'approved_at' => null,
        ]);

        $provider->compostingServices()->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('status', 'Provider profile rejected and published services were unpublished.');
    }
}
