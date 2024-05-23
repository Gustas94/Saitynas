<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Hobbies;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = Auth::user()->load('roles'); // Load the roles relationship

        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $countries = Countries::all();
        $cities = Cities::all();
        $hobbies = Hobbies::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'countries' => $countries,
            'cities' => $cities,
            'hobbies' => $hobbies,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Sync user hobbies
        if ($request->has('hobbies')) {
            $user->hobbies()->sync($request->input('hobbies'));
        }

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}