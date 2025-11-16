<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->user();
            // Check if user exists
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            $firstName = $googleUser->user['given_name'] ?? null;
            $lastName = $googleUser->user['family_name'] ?? null;
            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();
            $avatar = $googleUser->getAvatar(); // profile photo URL
            $phone = null;
            $isNewUser = false;
            if (!$user) {
                // Create new user
                $user = User::create([
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(uniqid()),
                ]);
                $isNewUser = true;
            } else {
                // Update google_id if missing
                if (!$user->google_id) {
                    $user->first_name = $firstName;
                    $user->last_name  = $lastName;
                    $user->name  = $googleUser->name;
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            }

            Auth::login($user);

//            dd($user);

            if ($isNewUser) {
                return redirect()->route('frontend.about')->with('success', 'Welcome! Please complete your profile.');
            } else {
                return redirect()->route('frontend.dashboard')->with('success', 'Successfully logged in!');
            }
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('user.login')->with('error', 'Login failed: ' . $e->getMessage());
        }
    }
}
