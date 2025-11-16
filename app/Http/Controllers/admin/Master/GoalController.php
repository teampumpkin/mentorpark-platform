<?php

namespace App\Http\Controllers\admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\Permission\PermissionController;
use App\Models\Master\Goal;
use App\Models\User;
use Illuminate\Http\Request;

class GoalController extends Controller
{


    public function index()
    {
        $breadcrumb = 'Goals';
        $list = Goal::all(); // Retrieve all goals
        return view('admin.master.goals.list', compact('list', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = 'Create Goal';
        return view('admin.master.goals.create', compact( 'breadcrumb')); // Pass users and goal types to the view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',  // Validate that 'name' is required, a string, and has a max length of 255
        ]);

        try {
            // Store the new goal in the 'goals' table
            Goal::create([
                'name' => $validatedData['name'],  // Insert the 'name' field into the 'goals' table
            ]);
            session()->flash('success', 'Goal created successfully!');
            // Redirect back with a success message
            return redirect()->route('master.goals.index');
        } catch (\Exception $e) {
            // Return back with an error message in case of failure
            return back()->with('error', 'An error occurred while creating.');
        }
    }

    public function edit($id)
    {
        $breadcrumb = 'Edit Goal';
        $data = Goal::findOrFail($id); // Find the goal by ID

        // Return the edit view with the goal data
        return view('admin.master.goals.edit', compact('breadcrumb', 'data'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $data = Goal::findOrFail($id);
            $data->update([
                'name' => $validatedData['name'],
            ]);
            session()->flash('success', 'Updated successfully!');
            return redirect()->route('master.goals.index');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating.');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Goal::findOrFail($id);
            $data->delete();
            session()->flash('success', 'Deleted successfully!');
            return redirect()->route('master.goals.index');
        } catch (\Exception $e) {
            return redirect()->route('master.goals.index')->with('error', 'An error occurred while deleting.');
        }
    }
}
