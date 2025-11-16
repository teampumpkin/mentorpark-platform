<?php

namespace App\Http\Controllers\mentor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function dashboard()
    {
        $breadcrumb = 'Dashboard';
        $user = auth()->user();
        if (!in_array('Mentor', $user->role_names)) {
            abort(403, 'Unauthorized access. Only Mentor can view page.');
        }
        return view('frontend.mentor-dashboard', compact('breadcrumb'));
    }

    public function assignments()
    {
        $authUser = auth()->user();
        $breadcrumb = 'Assignments';
        if (!in_array('Mentor', $authUser->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view.');
        }

        $mentee_orders = Order::where(['organizer_id' => $authUser->id])->get();

        return view('frontend.assignments', compact('breadcrumb','authUser', 'mentee_orders'));
    }
}
