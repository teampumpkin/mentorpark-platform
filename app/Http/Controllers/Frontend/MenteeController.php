<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Locations\City;
use App\Models\Locations\Country;
use App\Models\Locations\State;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassSession;
use App\Models\Order;
use App\Models\RequestRaisedByMentee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenteeController extends Controller
{
    public function menteeDashboard()
    {
        $user = auth()->user();
        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view page.');
        }

        $breadcrumb = 'Welcome';
        $industry_type = IndustryType::all();
        $skills = Skill::all();
        $goals = Goal::all();
        $mentorsList = User::where('id', '!=', $user->id)
            ->whereJsonContains('role_names', 'Mentor')
            ->where('organization_id', $user->organization_id ?? null)
            ->get();
        return view('frontend.mentee.dashboard', compact('breadcrumb', 'user', 'skills', 'industry_type', 'goals', 'mentorsList'));
    }

    public function mentorList($skill = null)
    {
        $breadcrumb = 'Find Mentors/Coaches';
        $user = auth()->user();

        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view mentor list.');
        }

        $skills = Skill::all();
        /*$mentorsList = User::where('id', '!=', $user->id)
            ->whereJsonContains('role_names', 'Mentor')
            ->where('organization_id',  $user->organization_id ?? null)
            ->get();*/

        $mentorsQuery = User::where('id', '!=', $user->id)
            ->whereJsonContains('role_names', 'Mentor')
            ->where('organization_id', $user->organization_id ?? null);

        if ($skill) {
            $mentorsQuery->whereHas('skills', function ($query) use ($skill) {
                $query->where('name', $skill); // you can also use where('id', $skill_id)
            });
        }

        $mentorsList = $mentorsQuery->get();
        return view('frontend.mentee.mentors', compact('breadcrumb', 'user', 'mentorsList', 'skills'));
    }

    public function masterClasses(Request $request)
    {

        $breadcrumb = 'Master Classes';
        $user = auth()->user();

        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access.');
        }

        $skills = Skill::all();
        $countries = Country::all();

        $start_date = $request->query('start_date');
        $end_date   = $request->query('end_date');
        $country    = $request->query('country');
        $state      = $request->query('state');
        $city       = $request->query('city');
        $mode       = $request->query('mode');   // if you also send mode
        $skill      = $request->query('skill');


        $userSkillIds = $user->skills()->pluck('skills.id')->toArray();
        $organization_id = $user->organization_id;

        $masterClasses = MasterClass::where(['organization_id' => $organization_id])->get();

        // Filter master classes with matching session skills
        $suggested_masterClassIDs = $masterClasses->filter(function ($masterClass) use ($userSkillIds) {
            foreach ($masterClass->sessions as $session) {
                $sessionSkills = $session->skills ?? [];
                if (count(array_intersect($userSkillIds, $sessionSkills)) > 0) {
                    return true;
                }
            }
            return false;
        })->pluck('id')->toArray();

        $suggested_masterClasses = MasterClass::whereIn('id', $suggested_masterClassIDs)->get();
        /*$upskill_masterClass = MasterClass::where('organization_id', $organization_id)
            ->whereNotIn('id', $masterClasses->pluck('id'))
            ->get();*/
       /* $upskill_masterClass = MasterClass::whereNotIn('id', $masterClasses->pluck('id'))
            ->get();*/

        DB::enableQueryLog();
//        dump($suggested_masterClassIDs);
        $upskill_masterClass = MasterClass::whereNotIn('id', $suggested_masterClassIDs ?? [])
            ->whereHas('sessions', function ($query) use ($start_date, $end_date, $country, $state, $city, $mode, $skill) {
                if ($start_date) {
                    $query->whereDate('start_date_time', '>=', $start_date);
                }
                if ($end_date) {
                    $query->whereDate('end_date_time', '<=', $end_date);
                }
                if ($country) {
                    $query->where('country', $country);
                }
                if ($state) {
                    $query->where('state', $state);
                }
                if ($city) {
                    $query->where('city', $city);
                }
                if ($mode) {
                    $query->where('session_type', $mode);
                }
                if ($skill) {
                    $query->whereJsonContains('skills', (int) $skill);
                }
            })
            ->with('sessions')
            ->get();

        $queries = DB::getQueryLog();
//        dd($queries);

        /*if (!empty($queries)) {
            $query = end($queries);
            $rawSql = str_replace(['%', '?'], ['%%', '"%s"'], $query['query']);
            $sql = vsprintf($rawSql, array_map('addslashes', $query['bindings']));
            dd($sql);
        } else {
            dd('No query found in log');
        }*/

        $stateList = [];
        $cityList  = [];

        if ($country) {
            $stateList = State::where('country_id', $country)->get();
        }

        if ($state) {
            $cityList = City::where('state_id', $state)->get();
        }

        return view('frontend.mentee.master-classes', compact(
            'breadcrumb',
            'user',
            'masterClasses',
            'suggested_masterClasses',
            'upskill_masterClass',
            'skills',
            'countries',
            'start_date',
            'end_date',
            'country',
            'state',
            'city',
            'mode',
            'skill',
            'stateList',
            'cityList'
        ));

    }

    public function masterClassesDetail($slug){
        $user = auth()->user();
        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access.');
        }

        $masterClass = MasterClass::where('slug', $slug)->first();

        return view('frontend.master-class-detail', compact(
            'user',
            'masterClass'
        ));
    }

    public function searchSuggestions(Request $request)
    {
        $user = auth()->user();

        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view mentor list.');
        }
        $query = $request->get('query');

        $mentors = User::whereHas('roles', function ($q) {
            $q->where('name', 'Mentor');
        })
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhereHas('skills', function ($q2) use ($query) {
                        $q2->where('name', 'LIKE', "%$query%");
                    });
            })
            ->with('skills')
            ->take(5)
            ->get();

        $result = $mentors->map(function ($mentor) {
            return [
                'name' => $mentor->name,
                'skills' => $mentor->skills->pluck('name')->toArray(),
            ];
        });

        return response()->json($result);
    }

    public function mentorDetail($mentor_id)
    {
        $user = auth()->user();

        if (!in_array('Mentee', $user->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view.');
        }
        $mentorDetail = User::where('user_slug', $mentor_id)->first();
        return view('frontend.mentee.mentorDetail', compact('mentorDetail'));
    }

    public function raiseRequest(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'master_class_id' => 'required|integer|exists:master_classes,id',
            'sessions' => 'nullable|array',
            'sessions.*' => 'integer',
            'complete_masterclass' => 'nullable|boolean',
        ]);
        $requestRaised = RequestRaisedByMentee::create([
            'mentee_id' => $user->id,
            'mentor_id' => null, // if available, set mentor id here
            'organization_id' => $user->organization_id, // optional
            'master_class_id' => $validated['master_class_id'],
            'sessions' => $validated['sessions'] ?? [],
            'complete_master_class' => $validated['complete_masterclass'] ?? 0,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request raised successfully.',
            'data' => $requestRaised,
        ]);

    }

    public function mySessions()
    {
        $authUser = auth()->user();
        $breadcrumb = 'My Sessions';
        if (!in_array('Mentee', $authUser->role_names)) {
            abort(403, 'Unauthorized access. Only mentee can view.');
        }

        $orders = Order::where(['user_id' => $authUser->id])->get();

        return view('frontend.mentee.my-sessions', compact('breadcrumb','authUser', 'orders'));
    }

}
