<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserInformation;

class LinkedinController extends Controller
{
    /**
     * Redirect user to LinkedIn for authentication
     */
    public function redirectToLinkedin()
    {
        $redirectUri = config('services.linkedin.redirect');

        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.linkedin.client_id'),
           // 'redirect_uri' => 'http://intern-park.io/auth/linkedin/callback',
		   'redirect_uri' => 'https://staging.thementorpark.com/auth/linkedin/callback',
            'scope' => 'openid profile email',
            'state' => Str::random(40),
        ]);

        return redirect('https://www.linkedin.com/oauth/v2/authorization?' . $query);
    }

    /**
     * Handle LinkedIn callback
     */
    public function handleLinkedinCallback(Request $request)
    {

        if ($request->has('error')) {
            return redirect('/login')->with('error', 'LinkedIn authorization failed: ' . $request->error_description);
        }

        if (!$request->has('code')) {
            return redirect('/login')->with('error', 'Missing authorization code from LinkedIn.');
        }

        try {
            // 1️⃣ Exchange authorization code for access token
            $tokenResponse = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => env('LINKEDIN_REDIRECT_URI'),
                'client_id' => env('LINKEDIN_CLIENT_ID'),
                'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            ]);

            if ($tokenResponse->failed()) {
                return redirect('/login')->with('error', 'LinkedIn token request failed.');
            }

            $accessToken = $tokenResponse->json('access_token');

            // 2️⃣ Fetch user info via OpenID endpoint
            $userInfo = Http::withToken($accessToken)->get('https://api.linkedin.com/v2/userinfo')->json();

            if (!isset($userInfo['email'])) {
                // Optional fallback: fetch email via legacy endpoint (if allowed)
                $emailResponse = Http::withToken($accessToken)
                    ->get('https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))');
                $userInfo['email'] = $emailResponse->json('elements.0.handle~.emailAddress') ?? null;
            }

            // 3️⃣ Create or update user
            $user = User::updateOrCreate(
                ['email' => $userInfo['email']],
                [
                    'name' => $userInfo['name'] ?? ($userInfo['given_name'] ?? '') . ' ' . ($userInfo['family_name'] ?? ''),
                    'first_name' => $userInfo['given_name'] ?? '',
                    'last_name' => $userInfo['family_name'] ?? '',
                    'user_slug' => Str::slug($userInfo['given_name'] ?? Str::random(6)),
                    'role_names' => [],
                ]
            );

            if ($user->wasRecentlyCreated) {
                $user->role_names = [];
                $user->save();
            }

            $profileResponse = Http::withToken($accessToken)
                ->get('https://api.linkedin.com/v2/me?projection=(id,vanityName)');
            $vanityName = $profileResponse->json('vanityName') ?? null;
            $profileUrl = $vanityName ? 'https://www.linkedin.com/in/' . $vanityName : null;


            // 4️⃣ Sync UserInformation table
            UserInformation::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profile_photo' => $userInfo['picture'] ?? null,
                    'linkedin' =>$profileUrl ?? null,
                    'job_title' => null,
                    'skills' => null,
                    'goal' => null,
                    'total_experience' => null,
                ]
            );

            // 5️⃣ Login and redirect
            Auth::login($user, true);
            return redirect()->intended('/dashboard')->with('success', 'Logged in via LinkedIn successfully.');
        } catch (\Throwable $e) {
            return redirect('/login')->with('error', 'LinkedIn login failed. ' . $e->getMessage());
        }
    }
}
