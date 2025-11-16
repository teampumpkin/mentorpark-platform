<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Master\Goal;
use App\Models\Master\Skill;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class userController extends Controller
{

    public function index()
    {
        $breadcrumb = 'Users';
        $users = User::with('information')->latest()->get();
        return view('admin.users.users', compact('breadcrumb', 'users'));
    }

    public function show($id)
    {
        $breadcrumb = 'User Details';
        $user = User::with('information')->findOrFail($id);
        return view('admin.users.user_details', compact('breadcrumb', 'user'));
    }

    public function create()
    {
        $breadcrumb = 'Create User';
        $userType = UserType::all();
        $goals = Goal::all();
        $skills = Skill::all();
        $organizations = Organization::where('is_active', true)->get();
        $roles = Role::all();
        return view('admin.users.create-user', compact('breadcrumb', 'userType', 'goals', 'skills', 'organizations', 'roles'));
    }

    // UserController.php
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required|min:6',
            'user_types' => 'required|array',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'about' => 'required',
            'job_title' => 'required',
            'total_experience' => 'required',
            'state' => 'required',
            'country' => 'required',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'checkmeout' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'user_slug' => CommonController::generateRandomString(),
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'role_names' => $request->roles, // Store roles as JSON
            ]);

            $user->syncRoles($request->roles); // Assign roles via Spatie

            $userInfo = new UserInformation([
                'user_id' => $user->id,
                'organization_id' => $request->organization_id,
                'user_type' => $request->input('user_types'),
                'about' => $request->about,
                'mobile' => $request->mobile,
                'job_title' => $request->job_title,
                'total_experience' => $request->total_experience,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'state' => $request->state,
                'country' => $request->country,
            ]);

            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $path = $photo->store('profile_photos', 'public_users_profile');
                $userInfo->profile_photo = $path;
            }

            $userInfo->save();

            if ($request->has('goals')) {
                $user->goals()->attach($request->goals);
            }

            if ($request->has('skills')) {
                $user->skills()->attach($request->skills);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
//            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the user. Please try again.');
        }
    }

    public function edit($id)
    {
        $breadcrumb = 'Edit User';
        $user = User::findOrFail($id);
        $userTypes = UserType::all();
        $goals = Goal::all();
        $skills = Skill::all();
        $roles = Role::all();
        $organizations = Organization::where('is_active', true)->get();
//        dd($user->roles);
//        dd($user->getAllPermissions());
//        dd($user->hasPermissionTo('Users Management'));
        return view('admin.users.edit-user', compact('breadcrumb', 'userTypes', 'user', 'goals', 'skills', 'organizations', 'roles'));
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required',
            'password' => 'nullable|min:6',  // Password is optional on update
            'user_types' => 'required|array',  // Ensure that user_types is an array
            'about' => 'required',
            'job_title' => 'required',
            'total_experience' => 'required',
            'state' => 'required',
            'country' => 'required',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//            'checkmeout' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);  // Find user by ID

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                // If password is provided, hash it
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
            $user->syncRoles($request->roles);



            if ($user->userInformation) {
                $userInfo = $user->userInformation;
            } else {
                $userInfo = new UserInformation();
                $userInfo->user_id = $user->id; // Link to the user
            }

            $userDetails = [
                'user_type' => $request->input('user_types'),
                'organization_id' => $request->organization_id,
                'about' => '$request->about',
                'job_title' => $request->job_title,
                'total_experience' => $request->total_experience,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'state' => $request->state,
                'country' => $request->country,
            ];

            $user->information->update($userDetails);

            // Handle profile photo upload (if exists)
            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $path = $photo->store('profile_photos', 'public_users_profile');
                $user->information->profile_photo = $path;
                $user->information->save();
            }

            // Attach goals and skills to the user (update the relationships)
            if ($request->has('goals')) {
                $user->goals()->sync($request->goals); // Using sync to update the many-to-many relationship
            }

            if ($request->has('skills')) {
                $user->skills()->sync($request->skills); // Using sync to update the many-to-many relationship
            }

            DB::commit();
//            dd($user->information);
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the user.');
        }
    }

}
