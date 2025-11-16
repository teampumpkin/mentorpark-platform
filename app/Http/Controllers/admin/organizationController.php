<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class organizationController extends Controller
{
    public function index()
    {
        $breadcrumb = 'Organizations';
        $list = Organization::with(['countryRel', 'stateRel', 'cityRel', 'industryType'])->get();
        return view('admin.organization.list', compact('list', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = 'Organization';
        return view('admin.organization.create', compact('breadcrumb'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|integer',
            'state' => 'nullable|integer',
            'city' => 'nullable|integer',
            'postal_code' => 'nullable|string|max:20',
            'industry_type' => 'nullable|integer',
            'registration_number' => 'nullable|string|max:100',
            'founded_date' => 'nullable|date',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_path')) {
            $photo = $request->file('logo_path');
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($originalName);
            $extension = $photo->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $extension;
            $path = $photo->storeAs('organization/logos/', $filename, 'public');
            $validated['logo_path'] = 'organization/logos/' . $filename;
        }
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Organization::create($validated);
        return redirect()->route('organization.index')->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization)
    {
        $breadcrumb = 'Organization Details';
        return view('admin.organization.details', compact('organization', 'breadcrumb'));
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        $breadcrumb = 'Edit Organization';

        return view('admin.organization.edit', compact('organization', 'breadcrumb'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|integer',
            'state' => 'nullable|integer',
            'city' => 'nullable|integer',
            'postal_code' => 'nullable|string|max:20',
            'industry_type' => 'nullable|integer',
            'registration_number' => 'nullable|string|max:100',
            'founded_date' => 'nullable|date',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_path')) {
            // Delete old logo if exists
            if ($organization->logo_path && Storage::disk('public')->exists($organization->logo_path)) {
                Storage::disk('public')->delete($organization->logo_path);
            }

            $photo = $request->file('logo_path');
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($originalName);
            $extension = $photo->getClientOriginalExtension();
            $filename = $slug . '-' . time() . '.' . $extension;

            $path = $photo->storeAs('organization/logos/', $filename, 'public');
            $validated['logo_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $organization->update($validated);

        return redirect()->route('organization.index')->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organization.index')->with('success', 'Organization deleted successfully.');
    }
}
