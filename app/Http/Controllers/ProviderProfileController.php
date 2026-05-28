<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('provider.profile', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'verification_document' => ($request->user()->verification_document ? 'nullable' : 'required') . '|file|mimes:pdf,jpeg,png,jpg,zip,doc,docx|max:5120',
        ]);

        $user = $request->user();

        $data = [
            'business_name' => $request->business_name,
            'business_address' => $request->business_address,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'bio' => $request->bio,
            'profile_completed' => true,
        ];

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        if ($request->hasFile('verification_document')) {
            $data['verification_document'] = $request->file('verification_document')->store('documents', 'public');
        }

        $user->update($data);

        return redirect()->route('provider.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
