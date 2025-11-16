<?php

namespace App\Http\Controllers\admin\Master;

use App\Http\Controllers\api\APIController;
use App\Http\Controllers\Controller;
use App\Models\Master\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $breadcrumb = 'Skills';
        $list = Skill::all();
        return view('admin.master.skills.list', compact('list', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = 'Create Skill';
        return view('admin.master.skills.create', compact( 'breadcrumb'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Skill::create([
                'name' => $validatedData['name'],
            ]);
            session()->flash('success', 'created successfully!');
            return redirect()->route('master.skills.index');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while creating.');
        }
    }

    public function edit($id)
    {
        $breadcrumb = 'Edit Skill';
        $data = Skill::findOrFail($id);
        return view('admin.master.skills.edit', compact('breadcrumb', 'data'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $data = Skill::findOrFail($id);
            $data->update([
                'name' => $validatedData['name'],
            ]);
            session()->flash('success', 'Updated successfully!');
            return redirect()->route('master.skills.index');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating.');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Skill::findOrFail($id);
            $data->delete();
            session()->flash('success', 'Deleted successfully!');
            return redirect()->route('master.skills.index');
        } catch (\Exception $e) {
            return redirect()->route('master.skills.index')->with('error', 'An error occurred while deleting.');
        }
    }

   /* public function europaSkillsPage(Request $request)
    {
        $breadcrumb = 'Europa Skill';
        $skillsResponse = APIController::get_europa_skills($request);
        $skillsData = $skillsResponse->getData(true);
//        dd($skillsData['titles']);
        $list = $skillsData["titles"];
        $limit = $skillsData["limit"];
        $offset = $skillsData["offset"];
        $existingSkills = Skill::whereIn('name', $list)->pluck('name')->toArray();
        return view('admin.master.skills.europa-skills', compact('breadcrumb', 'list', 'limit', 'offset', 'existingSkills'));
    }*/

    public function europaSkillsPage(Request $request)
    {
        $breadcrumb = 'Europa Skill';

        $desiredCount = 100; // how many new skills to display
        $limit = 100;        // how many to fetch per API call
        $offset = 0;        // API pagination offset
        $newSkills = [];    // final array of new skills

        do {
            // Fetch batch of skills from API
            $skillsResponse = APIController::get_europa_skills($request->merge([
                'limit' => $limit,
                'offset' => $offset
            ]));

            $skillsData = $skillsResponse->getData(true);
            $fetched = $skillsData['titles'] ?? [];

            if (empty($fetched)) {
                // No more data available from API
                break;
            }

            // Find which ones are already in DB
            $existingSkills = Skill::whereIn('name', $fetched)->pluck('name')->toArray();

            // Filter out existing ones — keep only new
            $fresh = array_diff($fetched, $existingSkills);

            // Merge into our newSkills list (ensure uniqueness)
            $newSkills = array_unique(array_merge($newSkills, $fresh));

            // If we still have fewer than desired, move to next batch
            if (count($newSkills) < $desiredCount) {
                $offset += $limit;
            } else {
                // limit to exactly desired count
                $newSkills = array_slice($newSkills, 0, $desiredCount);
                break;
            }

        } while (count($newSkills) < $desiredCount);

        // Pass only new skills to view
        return view('admin.master.skills.europa-skills', [
            'breadcrumb' => $breadcrumb,
            'list' => $newSkills,
            'limit' => $limit,
            'offset' => $offset,
            'existingSkills' => [], // all are new, but kept for consistency
        ]);
    }



    public function storeEuropaSkills(Request $request)
    {
        $skills = $request->input('skills', []);
        if (empty($skills)) {
            return response()->json(['message' => 'No skills selected'], 400);
        }
        $insertedCount = 0;
        foreach ($skills as $skillName) {
            $exists = Skill::where('name', $skillName)->exists();
            if (!$exists) {
                Skill::create(['name' => $skillName]);
                $insertedCount++;
            }
        }
        return response()->json([
            'message' => 'Skills processed successfully',
            'inserted' => $insertedCount,
            'total_selected' => count($skills),
        ]);
    }
}
