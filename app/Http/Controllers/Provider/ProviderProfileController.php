<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\UpdateProviderProfileRequest;
use Illuminate\Http\RedirectResponse;

class ProviderProfileController extends Controller
{
    public function update(UpdateProviderProfileRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return back()->with('status', 'provider-profile-updated');
    }
}
