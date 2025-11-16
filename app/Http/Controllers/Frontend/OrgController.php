<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Mail\InviteUser;
use App\Models\Locations\Country;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use App\Models\Organization;
use App\Models\RequestRaisedByMentee;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class OrgController extends Controller
{

    public function organizationDashboard()
    {
        $user = auth()->user();

        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }

        if (empty($user->organization_id)) {
            $role = Role::where(['name' => 'Organization'])->first();
            session([
                'user_email' => $user->email,
                'user_role_id' => $role->id, // Adjust field if it's named differently
            ]);
            return redirect()->route('enter.organization.details');
        }

        $breadcrumb = 'Dashboard Analytics';
        $industry_type = IndustryType::all();

        $skills = Skill::all();
        $goals = Goal::all();
        return view('frontend.organization.dashboard', compact('breadcrumb', 'user', 'skills', 'industry_type', 'goals'));
    }

    public function mentorList()
    {
        $breadcrumb = 'Mentors management';
        $user = auth()->user();
        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }
        $mentorsList = User::where('id', '!=', $user->id)
            ->whereJsonContains('role_names', 'Mentor')
//            ->where('id', '!=', $user->id)
            ->get();
        return view('frontend.organization.mentors', compact('breadcrumb', 'user', 'mentorsList'));
    }

    public function menteeList()
    {
        $breadcrumb = 'Mentee management';
        $user = auth()->user();
        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }
        $menteeList = User::where('id', '!=', $user->id)
            ->whereJsonContains('role_names', 'Mentee')
            ->where('organization_id', $user->organization_id)
            ->get();
        return view('frontend.organization.mentees', compact('breadcrumb', 'user', 'menteeList'));
    }

    public function createMentor($organization_id)
    {
        $breadcrumb = 'Create Mentor';
        $user = auth()->user();
        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }
        $country = Country::all();
        $industry_type = IndustryType::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $roles = Role::all();
        $userType = UserType::all();
        $organizations = Organization::all();
        return view('frontend.organization.create-mentor', compact('breadcrumb', 'userType', 'goals', 'skills', 'organizations', 'roles', 'country', 'industry_type', 'user', 'organization_id'));
    }

    public function createMentee($organization_id)
    {
        $breadcrumb = 'Create Mentee';
        $user = auth()->user();
        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }
        $country = Country::all();
        $industry_type = IndustryType::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $roles = Role::all();
        $userType = UserType::all();
        $organizations = Organization::all();
        return view('frontend.organization.create-mentee', compact('breadcrumb', 'userType', 'goals', 'skills', 'organizations', 'roles', 'country', 'industry_type', 'user', 'organization_id'));
    }

    public function storeMentor(Request $request, $organization_id)
    {
        $request->validate([
            // Basic Information
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile'     => ['required', 'string', 'max:10'],
            'password'   => ['required', 'string', 'min:6'],
            // Professional Details
            'organization_id' => ['nullable', 'exists:organization,id'],
            'job_title'       => ['required', 'string', 'max:255'],
            'total_experience'=> ['required', 'integer', 'min:0'],
            // Skills & Goals
            'skills'  => ['required', 'array'],
            'skills.*'=> ['integer', 'exists:skills,id'],
            'goals'   => ['required', 'array'],
            'goals.*' => ['integer', 'exists:goals,id'],
            'about'   => ['required', 'string'],
            // Social & Final Details
            'linkedin'      => ['nullable', 'url'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'state'         => ['required', 'exists:states,id'],
            'country'       => ['required', 'exists:countries,id'],
            'city'       => ['required', 'exists:cities,id'],
//            'checkmeout'    => ['accepted'],
        ]);

        DB::beginTransaction();

        try {
            // Create User instance and fill basic and professional details

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'user_slug' => CommonController::generateRandomString(),
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'role_names' => ['Mentor'],
                'organization_id' => $request->organization_id ?? $organization_id,
            ]);
            $user->syncRoles(['Mentor']);

            $userInfo = new UserInformation([
                'user_id' => $user->id,
                'organization_id' => $request->organization_id ?? $organization_id,
                'user_type' => ['Mentor'],
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
                'city' => $request->city,
                'postal_code' => $request->postal_code,
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

            return redirect()->route('frontend.organization.mentors')
                ->with('success', 'Mentor created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add mentor: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function storeMentee(Request $request, $organization_id)
    {
        $request->validate([
            // Basic Information
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile'     => ['required', 'string', 'max:10'],
//            'password'   => ['required', 'string', 'min:6'],
            // Professional Details
            'organization_id' => ['nullable', 'exists:organization,id'],
            'job_title'       => ['nullable', 'string', 'max:255'],
            'total_experience'=> ['nullable', 'integer', 'min:0'],
            // Skills & Goals
            'skills'  => ['required', 'array'],
            'skills.*'=> ['integer', 'exists:skills,id'],
            'goals'   => ['required', 'array'],
            'goals.*' => ['integer', 'exists:goals,id'],
            'about'   => ['nullable', 'string'],
            // Social & Final Details
            'linkedin'      => ['nullable', 'url'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'state'         => ['nullable', 'exists:states,id'],
            'country'       => ['nullable', 'exists:countries,id'],
            'city'       => ['nullable', 'exists:cities,id'],
//            'checkmeout'    => ['accepted'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'user_slug' => CommonController::generateRandomString(),
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => NULL,
                'role_names' => ['Mentee'],
                'organization_id' => $request->organization_id ?? $organization_id,
            ]);
            $user->syncRoles(['Mentee']);

            $userInfo = new UserInformation([
                'user_id' => $user->id,
                'organization_id' => $request->organization_id ?? $organization_id,
                'user_type' => ['Mentee'],
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
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ]);

            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $path = $photo->store('profile_photos', 'public_users_profile');
                $userInfo->profile_photo = $path;
            }

            $userInfo->save();

            $details = [
                'subject' => 'You are invited to join our platform!',
                'name' => $user->first_name . ' ' . $user->last_name,
                'message' => 'We’re excited to have you join our growing community.',
                'actionUrl' => url('/invite/accept/' . $user->user_slug),
                'actionText' => 'Accept Invitation',
            ];

            Mail::to($user->email)->queue(new InviteUser($details));
//            Mail::to('satyam.maurya@teampumpkin.com')->queue(new InviteUser($details));

            if ($request->has('goals')) {
                $user->goals()->attach($request->goals);
            }

            if ($request->has('skills')) {
                $user->skills()->attach($request->skills);
            }

            DB::commit();

            return redirect()->route('frontend.organization.mentees')
                ->with('success', 'Mentee created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add mentee: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function userProfile($organization_id, $user_id)
    {
        $mentor_user = User::where('user_slug', $user_id)->first();
        $breadcrumb = $mentor_user->name;
        $user = User::where('user_slug', $user_id)->first();
        $industry_type = IndustryType::all();
        $organizations = Organization::where('id', $organization_id)->get();
        $skills = Skill::all();
        $goals = Goal::all();
        $country = Country::all();
        return view('frontend.my-account', compact('breadcrumb', 'user', 'industry_type', 'skills', 'organizations', 'goals', 'country'));
//        dd($organization_id, $user_id);
    }

    public function menteesRequest()
    {
        $breadcrumb = 'Mentees Requests';
        $user = auth()->user();
        if (!in_array('Organization', $user->role_names)) {
            abort(403, 'Unauthorized access. Only organizations can view mentor list.');
        }
        $pendingRequests = RequestRaisedByMentee::where('organization_id', $user->organization_id)
            ->where('status', 'pending')->get();

        $rejectedRequests = RequestRaisedByMentee::where('organization_id', $user->organization_id)
            ->where('status', 'rejected')->get();

        $acceptedRequests = RequestRaisedByMentee::where('organization_id', $user->organization_id)
            ->where('status', 'accepted')->get();

        return view('frontend.organization.mentees-requests', compact('breadcrumb', 'user', 'pendingRequests', 'rejectedRequests', 'acceptedRequests'));
    }

    public function handleRequestAction(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:request_raised_by_mentee,id',
            'status' => 'required|in:accepted,rejected',
        ]);

        $req = RequestRaisedByMentee::find($request->id);
        $req->update([
            'status' => $request->status,
            'responded_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request ' . $request->status . ' successfully.',
        ]);
    }

}
