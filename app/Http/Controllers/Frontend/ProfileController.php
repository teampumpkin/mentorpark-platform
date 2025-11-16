<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Locations\Country;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index($userType = null)
    {
        $breadcrumb = 'My Account';
        $user = auth()->user();
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $country = Country::all();
        return view('frontend.my-account', compact('breadcrumb', 'user', 'userType', 'industry_type', 'skills', 'organizations', 'goals', 'country'));
    }

    public function updateProfile(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email,' . auth()->id(), // unique except current user
            'mobile' => 'required|string',
            'password' => 'nullable|string|min:6',  // password optional on update
            'organization_id' => 'nullable|exists:organization,id',
            'about' => 'required|string',
            'job_title' => 'required|string',
            'total_experience' => 'required',
            'state' => 'required|exists:states,id',
            'country' => 'required|exists:countries,id',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();

            // Update user basic info with optional password update
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            // Handling user information relation
            if ($user->information) {
                $userInfo = $user->information;
            } else {
                $userInfo = new UserInformation();
                $userInfo->user_id = $user->id;
            }

            // Handle profile photo upload first before updating userInfo
            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
				
                //$path = $photo->store('profile_photos', 'public_users_profile');
				$path = $photo->store('profile_photos', 'public');
				
                $userInfo->profile_photo = $path;
            }



            // Prepare user details to update
            $userDetails = [
                'organization_id' => $request->organization_id,
                'about' => $request->about,
                'additional_description' => $request->additional_description,
                'job_title' => $request->job_title,
                'total_experience' => $request->total_experience,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'state' => $request->state,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code
                // 'profile_photo' updated above directly on $userInfo
            ];

            // Update or save user information
            $userInfo->fill($userDetails);
            $userInfo->save();

            // Sync goals & skills relationships if provided
            if ($request->has('goals')) {
                $user->goals()->sync($request->goals);
            }

            if ($request->has('skills')) {
                $user->skills()->sync($request->skills);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

//            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the user.');
        }
    }

}
