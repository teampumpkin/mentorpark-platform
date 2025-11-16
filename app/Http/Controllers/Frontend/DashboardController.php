<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Normalize roles into an array (no matter the format)
        $roles = $user->role_names;
        $industry_type = IndustryType::all();
        // Now safely check roles
        if (in_array('Mentor', $roles)) {
            $breadcrumb = 'Mentor Dashboard Analytics';
            return redirect('/mentor-dashboard');
        }
        elseif (in_array('Mentee', $roles)) {
            $breadcrumb = 'Mentee Dashboard Analytics';
            return view('frontend.mentee.dashboard', compact('breadcrumb', 'user', 'industry_type'));
        }
        elseif (in_array('Organization', $roles)) {
            $breadcrumb = 'Or Dashboard Analytics';
            return redirect('/overview');
        }
        $breadcrumb = 'Dashboard Analytics';
        return view('frontend.skeleton', compact('breadcrumb', 'user', 'industry_type'));
    }
}
