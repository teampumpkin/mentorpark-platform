<?php

namespace App\Http\Controllers;

use App\Mail\sendOTP;
use App\Models\Locations\Country;
use App\Models\Organization;
use App\Models\Otp;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    public function register()
    {
        if (auth()->check()) {
            return redirect()->route('frontend.dashboard');
        }
        $breadcrumb = 'Register';
        $countries = Country::all();
        $roles = Role::whereNotIn('name', ['Superadmin', 'Admin'])->get();
        return view('frontend.register', compact('breadcrumb', 'countries', 'roles'));
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('frontend.dashboard');
        }
        return view('frontend.login');
    }

    public function twoStepVarification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);
        $ipAddress = $request->ip();

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
        }

        // Block check: If last OTP failed 9 times, and not 48 hours passed
        $lastOtp = Otp::where('email', $email)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->attempts >= 9 && !$lastOtp->is_verified) {
            $blockedUntil = Carbon::parse($lastOtp->created_at)->addHours(48);

            if (now()->lessThan($blockedUntil)) {
                return back()->withErrors(['phone' => 'Too many failed attempts. Try again after ' . $blockedUntil->diffForHumans()]);
            }
        }
        $otpCount = Otp::where('email', $email)
            ->where('is_verified', false)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($otpCount >= 3) {
            return back()->withErrors(['phone' => 'OTP already sent 3 times. Try again later.']);
        }

        $otpCode = rand(1000, 9999);

        Otp::create([
            'email' => $email,
            'otp' => $otpCode,
            'ip_address' => $ipAddress,
            'is_verified' => false,
            'attempts' => 0,
            'expires_at' => now()->addMinutes(5),
        ]);

        session([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $details = [
            'name' => $user->name,
            'otp' => $otpCode
        ];
        Mail::to($request->email)->send(new sendOTP($details));

        /*Mail::raw("Your OTP is: $otpCode", function ($msg) {
            $msg->to('satyam.maurya@teampumpkin.com')->subject('Your OTP Code');
        });*/

        return redirect()->route('otp.form.login')->with('success', 'OTP sent successfully.');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
//            'phone' => 'required|digits_between:6,15',
//            'country_code' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,id',
        ]);

        $ipAddress = $request->ip();
        /*$phone = $request->input('phone');
        $cc = $request->input('country_code');
        $fullPhone = '+' . $cc . ' ' . $phone;*/

        $email = $request->input('email');

        // Block check: If last OTP failed 9 times, and not 48 hours passed
        $lastOtp = Otp::where('email', $email)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->attempts >= 9 && !$lastOtp->is_verified) {
            $blockedUntil = Carbon::parse($lastOtp->created_at)->addHours(48);

            if (now()->lessThan($blockedUntil)) {
                return back()->withErrors(['phone' => 'Too many failed attempts. Try again after ' . $blockedUntil->diffForHumans()]);
            }
        }

        // Count unverified OTPs in past hour (resend limit)
        $otpCount = Otp::where('email', $email)
            ->where('is_verified', false)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($otpCount >= 3) {
            return back()->withErrors(['phone' => 'OTP already sent 3 times. Try again later.']);
        }

        $otpCode = rand(1000, 9999);

        Otp::create([
//            'country_code' => $cc,
//            'phone' => $phone,
//            'full_phone' => $fullPhone,
            'email' => $email,
            'otp' => $otpCode,
            'ip_address' => $ipAddress,
            'is_verified' => false,
            'attempts' => 0,
            'expires_at' => now()->addMinutes(5),
        ]);

        session([
//            'otp_phone' => $request->phone,
            'otp_email' => $request->email,
//            'otp_country_code' => $request->country_code,
//            'otp_full_phone' => $fullPhone,
            'otp_role_id' => $request->role,
        ]);

        // ✅ Send OTP to email
        /*Mail::raw("Your OTP is: $otpCode", function ($msg) {
            $msg->to('satyam.maurya@teampumpkin.com')->subject('Your OTP Code');
        });*/

        $details = [
            'name' => 'User',
            'otp' => $otpCode
        ];
        Mail::to($request->email)->queue(new sendOTP($details));

        return redirect()->route('otp.form')->with('success', 'OTP sent successfully.');
    }

    public function otp_form()
    {
        if (
            !session()->has('otp_email') ||
            !session()->has('otp_role_id')
        ) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please enter details again.']);
        }

        $breadcrumb = 'Register';
        $countries = Country::all();
        $roles = Role::whereNotIn('name', ['Superadmin', 'Admin'])->get();

        $otpEmail = session('otp_email');
//        $otpPhone = session('otp_phone');
//        $otp_full_phone = session('otp_full_phone');
//        $otpCountryCode = session('otp_country_code');
        $otpRoleId = session('otp_role_id');

        return view('frontend.otp-form', compact(
            'breadcrumb',
            'countries',
            'roles',
            'otpEmail',
//            'otp_full_phone',
//            'otpCountryCode',
            'otpRoleId'
        ));
    }

    public function otp_form_login()
    {
        if (
            !session()->has('email') ||
            !session()->has('password')
        ) {
            return redirect()->back()->withErrors(['error' => 'Session expired. Please enter details again.']);
        }

        $breadcrumb = 'Login';
        $email = session('email');
        $password = session('password');

        return view('frontend.otp-form-login', compact(
            'breadcrumb',
            'email',
            'password',
        ));
    }

    public function verifyOtp(Request $request)
    {
        // Join array into a string
        $otpArray = $request->input('otp'); // array of characters
        $otpInput = is_array($otpArray) ? implode('', $otpArray) : $otpArray;

        // Validate after joining
        $request->merge(['full_otp' => $otpInput]);

        $request->validate([
            'full_otp' => 'required|digits:4', // Adjust to 6 if you're using 6-digit OTP
        ]);

        // Get full phone from session
//        $fullPhone = session('otp_full_phone');
        $email = session('otp_email');

        $roleId = $request->role;
        $role = Role::where('id', $roleId)->first();



        if (!$email) {
            return redirect()->route('register')->withErrors(['phone' => 'Session expired. Please try again.']);
        }

        // Get latest unverified OTP
        $otpEntry = Otp::where('email', $email)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (!$otpEntry) {
            return back()->withErrors(['otp' => 'No active OTP found. Please request a new OTP.']);
        }



        // Check if user is blocked
        if ($otpEntry->attempts >= 9) {
            $blockedUntil = Carbon::parse($otpEntry->created_at)->addHours(48);
            if (now()->lessThan($blockedUntil)) {
                return back()->withErrors(['otp' => 'Too many failed attempts. Blocked until ' . $blockedUntil->diffForHumans() . '.']);
            }
        }

        // Expiry check
        if ($otpEntry->expires_at && now()->greaterThan($otpEntry->expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Request a new one.']);
        }

        // Check OTP match
        if ($otpEntry->otp !== $otpInput) {
            $otpEntry->increment('attempts');

            if ($otpEntry->attempts >= 9) {
                return back()->withErrors(['otp' => 'Maximum attempts reached. You are blocked for 48 hours.']);
            }

            return back()->withErrors(['otp' => 'Invalid OTP. Attempts left: ' . (9 - $otpEntry->attempts)]);
        }

        $otpEntry->update([
            'is_verified' => true,
            'updated_at' => now(),
        ]);

        session()->forget(['otp_phone', 'otp_country_code', 'otp_role_id', 'otp_full_phone']);
        session([
            'user_email' => $email,
//            'user_phone' => $request->phone,
//            'user_country_code' => $request->country_code,
//            'user_full_phone' => $fullPhone,
            'user_role_id' => $request->role,
        ]);

        if ($role->name == 'Organization'){
            return redirect()->route('enter.organization.details');
        }
        return redirect()->route('enter.user.details')->with('success', 'OTP verified successfully!');
    }

    public function verifyOtpLogin(Request $request)
    {
        // Join array into a string
        $otpArray = $request->input('otp'); // array of characters
        $otpInput = is_array($otpArray) ? implode('', $otpArray) : $otpArray;

        // Validate after joining
        $request->merge(['full_otp' => $otpInput]);

        $request->validate([
            'full_otp' => 'required|digits:4', // Adjust to 6 if you're using 6-digit OTP
        ]);

        // Get full phone from session
//        $fullPhone = session('otp_full_phone');
        $email = session('email');


        if (!$email) {
            return redirect()->route('frontend.login')->withErrors(['phone' => 'Session expired. Please try again.']);
        }

        // Get latest unverified OTP
        $otpEntry = Otp::where('email', $email)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (!$otpEntry) {
            return back()->withErrors(['otp' => 'No active OTP found. Please request a new OTP.']);
        }

        // Check if user is blocked
        if ($otpEntry->attempts >= 9) {
            $blockedUntil = Carbon::parse($otpEntry->created_at)->addHours(48);
            if (now()->lessThan($blockedUntil)) {
                return back()->withErrors(['otp' => 'Too many failed attempts. Blocked until ' . $blockedUntil->diffForHumans() . '.']);
            }
        }

        // Expiry check
        if ($otpEntry->expires_at && now()->greaterThan($otpEntry->expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Request a new one.']);
        }

        // Check OTP match
        if ($otpEntry->otp !== $otpInput) {
            $otpEntry->increment('attempts');

            if ($otpEntry->attempts >= 9) {
                return back()->withErrors(['otp' => 'Maximum attempts reached. You are blocked for 48 hours.']);
            }

            return back()->withErrors(['otp' => 'Invalid OTP. Attempts left: ' . (9 - $otpEntry->attempts)]);
        }

        $otpEntry->update([
            'is_verified' => true,
            'updated_at' => now(),
        ]);

        $user = User::where('email', $email)->first();


        /*Auth::login($user);

        $request->session()->regenerate();
        if (in_array('Mentee', $user->role_names)) {
            return redirect()->route('frontend.mentee.dashboard');
        }

        if (in_array('Mentor', $user->role_names)) {
            return redirect()->route('frontend.dashboard');
        }
        if (in_array('Organization', $user->role_names)) {
            return redirect()->route('frontend.organization.dashboard');
        }*/

        if (in_array('Mentee', $user->role_names)) {
            Auth::login($user);

            $request->session()->regenerate();
            return redirect()->route('frontend.mentee.dashboard');
        }

        if (in_array('Mentor', $user->role_names)) {
            Auth::login($user);

            $request->session()->regenerate();
            return redirect()->route('frontend.dashboard');
        }
        if (in_array('Organization', $user->role_names)) {
            Auth::login($user);

            $request->session()->regenerate();
            return redirect()->route('frontend.organization.dashboard');
        }
        return redirect()->route('user.login')->with(['error' => 'You are not authorized to access this page.']);
//        return redirect()->route('frontend.dashboard');
    }

    public function userDetailsPage()
    {

        if (
            !session()->has('user_email') ||
            !session()->has('user_role_id')
        ) {
            return redirect()->route('user.register')->withErrors(['error' => 'Session expired. Please enter details again.']);
        }

        $roleId = session('user_role_id');
        $role = Role::where('id', $roleId)->first();
        $breadcrumb = $role->name;
        $countries = Country::all();
        $email = session()->get('user_email');
        return view('frontend.user-details', compact('breadcrumb', 'countries', 'role', 'email'));
    }

    public function submitUserDetails(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user_phone = session('user_phone');
        $user_country_code = session('user_country_code');
        $user_full_phone = session('user_full_phone');
        $user_role_id = session('user_role_id');
        $roleId = session('user_role_id');
        $role = Role::where('id', $roleId)->first();
        $user_type = [$role->name ?? ''];


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $user_full_phone,
            'mobile_verified_at' => Carbon::now(),
            'role_names' => $user_type,
            'email_verified_at' => Carbon::now(),
            'user_slug' => $this->generateRandomString()
        ]);

        $user->syncRoles($role);

        $user_information = UserInformation::create([
            'user_id' => $user->id,
            'user_type' => $user_type
        ]);

        event(new Registered($user));
        session()->forget(['user_phone', 'user_country_code', 'user_full_phone', 'user_role_id']);
        Auth::login($user);

        if ($role->name == 'Organization'){
            return redirect()->route('enter.organization.details');
        }
        return redirect()->route('frontend.about');

//        return redirect()->route('frontend.dashboard');
    }

    public function submitOrganizationDetails(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'required|string',
            'country' => 'required|integer',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'postal_code' => 'required|string|max:20',
            'industry_type' => 'required|integer',
            'registration_number' => 'nullable|string|max:100',
            'founded_date' => 'nullable|date',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8|confirmed', // added validation for password
        ]);

        $roleId = session('user_role_id');
        $role = Role::find($roleId);
        $user_type = [$role->name ?? ''];

        if ($request->hasFile('logo_path')) {
            $photo = $request->file('logo_path');
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($originalName);
            $extension = $photo->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $extension;
            $photo->storeAs('organization/logos/', $filename, 'public');
            $validated['logo_path'] = 'organization/logos/' . $filename;
        }

        $validated['is_active'] = 1;

        // ✅ Use Transaction — rollback if anything fails
        DB::beginTransaction();

        try {
            $organization = Organization::create($validated);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($request->password),
                'mobile' => $validated['phone'] ?? null,
                'mobile_verified_at' => now(),
                'role_names' => $user_type,
                'organization_id' => $organization->id,
                'email_verified_at' => Carbon::now(),
                'user_slug' => $this->generateRandomString()
            ]);

            UserInformation::create([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'user_type' => $user_type,
                'website' => $validated['website'] ?? null,
                'state' => $validated['state'],
                'country' => $validated['country'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'profile_photo' => null,
            ]);

            // Fire event and commit only after all is successful
            event(new Registered($user));

            DB::commit();

            // Cleanup and login user
                session()->forget(['user_phone', 'user_country_code', 'user_full_phone', 'user_role_id']);
            Auth::login($user);

            return redirect()->route('frontend.organization.dashboard');

        } catch (\Throwable $e) {
            DB::rollBack();

            // Optional: delete uploaded logo if rollback happens
            if (isset($validated['logo_path']) && Storage::disk('public')->exists($validated['logo_path'])) {
                Storage::disk('public')->delete($validated['logo_path']);
            }
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    public function aboutUSer()
    {
        echo 'logged_in';
//        return view('frontend.about-user', compact('breadcrumb', 'countries', 'role'));
    }

    public static function generateSlugWithUniqueSuffix($title)
    {
        // Slugify the title (convert to URL-friendly format)
        $slug = Str::slug($title);

        // Append current timestamp and a random 4-digit number
        $uniqueSuffix = '-' . time() . '-' . rand(1000, 9999);

        return $slug . $uniqueSuffix;
    }

    public function organizationDetailsPage()
    {
        if (
            /* !session()->has('user_phone') ||
             !session()->has('user_country_code') ||
             !session()->has('user_full_phone') ||*/
            !session()->has('user_email') ||
            !session()->has('user_role_id')
        ) {
//            return redirect()->back()->withErrors(['error' => 'Session expired. Please fill the form again.']);
            return redirect()->route('user.register')->withErrors(['error' => 'Session expired. Please enter details again.']);
        }

        $roleId = session('user_role_id');
        $role = Role::where('id', $roleId)->first();
        $breadcrumb = $role->name;
        $countries = Country::all();
        $email = session()->get('user_email');
        $organizations = Organization::all();
        $countries = Country::all();
        return view('frontend.organization.enter-details', compact('breadcrumb', 'countries', 'role', 'email', 'organizations'));
    }

    public static function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $maxIndex)];
        }

        return $result;
    }

    public function accept_invitation($user_slug)
    {
        $user = User::where('user_slug', $user_slug)->first();
        if (!$user) {
            return redirect('/')->with('error', 'Invalid invitation link.');
        }
        if (empty($user->password)) {
            return redirect()->route('user.set_password', ['slug' => $user->user_slug]);
        }
        return redirect('/')->with('message', 'Invitation already accepted.');
    }

    public function set_password($slug)
    {
        if (Auth::user())
        {
            return redirect()->route('home');
        }
        // Find user by slug
        $user = User::where('user_slug', $slug)->first();

        // Check if user exists
        if (!$user) {
            return redirect('/')->with('error', 'Invalid or expired invitation link.');
        }

        // If password already set, redirect
        if (!empty($user->password)) {
            return redirect('/')->with('message', 'Invitation already accepted.');
        }

        // Otherwise show password setup view
        return view('auth.set-password', compact('user'));
    }

    public function update_password(Request $request, $slug)
    {
        if (Auth::user())
        {
            return redirect()->route('home');
        }
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('user_slug', $slug)->firstOrFail();

        // If already accepted, redirect
        if (!empty($user->password)) {
            return redirect('/')->with('message', 'Invitation already accepted.');
        }

        // Save new password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', 'Password set successfully. Invitation accepted!');
    }


}
