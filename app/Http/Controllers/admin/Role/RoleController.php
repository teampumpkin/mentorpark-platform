<?php

namespace App\Http\Controllers\admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index()
    {
        $breadcrumb = 'Roles';
        $roles = Role::all();
        return view('admin.roles.index', compact('roles', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = 'Create Role';
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions', 'breadcrumb'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);

        if (!empty($request->permissions)) {
            // Convert permission IDs to model instances
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $breadcrumb = 'Edit Role';
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions', 'breadcrumb'));
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => trim($request->name)]);

        // Convert permission IDs to models
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

        $role->syncPermissions($permissions); // Accepts model collection

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }
}
