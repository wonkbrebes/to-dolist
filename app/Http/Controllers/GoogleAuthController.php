<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google_login' => 'Could not authenticate with Google.']);
        }

        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            // Check if a user with this email already exists (e.g., registered via Breeze)
            $existingUserByEmail = User::where('email', $user->email)->first();

            if ($existingUserByEmail) {
                // If email exists, link Google ID to existing user
                $existingUserByEmail->google_id = $user->id;
                $existingUserByEmail->save();
                Auth::login($existingUserByEmail);
            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => bcrypt(uniqid()), // Random password, as Google handles auth
                ]);
                Auth::login($newUser);
            }
        }

        return redirect()->intended('/tasks');
    }
}