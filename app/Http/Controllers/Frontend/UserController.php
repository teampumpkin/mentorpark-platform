<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use App\Models\Organization;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function about_user()
    {
        $breadcrumb = 'Analytics';
        $industry_type = IndustryType::all();
        $organizations = Organization::all();
        $skills = Skill::all();
        return view('frontend.about-user', compact('breadcrumb', 'industry_type', 'skills', 'organizations'));
    }

    public function storeAbout(Request $request)
    {
        $validated = $request->validate([
            'industry'          => 'required|exists:industry_type,id',
            'organization'      => 'nullable|string|max:255',
            'your_level'        => 'required|string|max:255',
            'job_title'         => 'required|string|max:255',
            'total_experience'  => 'required|integer|min:0|max:100',
            'skills'            => 'required|array|min:3',
            'skills.*'          => 'exists:skills,id',
            'mentor_motivation' => 'required|string',
            'associate_yourself'=> 'required|string',
        ]);

        $user = auth()->user();

        $userInfo = $user->information ?? new UserInformation();
        $userInfo->industry_type_id = $validated['industry'];
        $userInfo->organization_name = $validated['organization'] ?? null;
        $userInfo->your_level = $validated['your_level'];
        $userInfo->job_title = $validated['job_title'];
        $userInfo->total_experience = $validated['total_experience'];
        $userInfo->mentor_motivation = $validated['mentor_motivation'];
        $userInfo->associate_yourself = $validated['associate_yourself'];

        $userInfo->user_id = $user->id;
        $userInfo->save();

        // Sync skills assuming userInfo has many-to-many relation 'skills'
//        $userInfo->skills()->sync($validated['skills']);
        if ($request->has('skills')) {
            $user->skills()->attach($request->skills);
        }

        if ($user->role_names[0] == 'Mentee')
        {
            return redirect()->route('frontend.mentee.dashboard')->with('success', 'About information saved successfully.');
        }

        return redirect()->route('frontend.profile')->with('success', 'About information saved successfully.');
    }

    public function saveGoals(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'goals' => 'required|array|min:3',
            'goals.*' => 'exists:goals,id',
        ]);

        // Attach or sync goals to user (assuming Many-to-Many relation)
        $user->goals()->sync($validated['goals']);

        return response()->json([
            'success' => true,
            'message' => 'Goals saved successfully!'
        ]);
    }

    public function setUserRole(Request $request)
    {
        // Ensure user is logged in
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        // Validate input
        $validated = $request->validate([
            'role' => 'required|string|in:Mentor,Mentee,Organization',
        ]);

        $role = [$validated['role']];

        // --- Update the user's role ---
        // If your column is `role_name` or `role_names`, adjust accordingly
        $user->role_names = $role;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => "Role updated successfully to {$validated['role']}",
            'role' => $role,
        ]);
    }

}
