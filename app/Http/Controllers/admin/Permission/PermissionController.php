<?php

namespace App\Http\Controllers\admin\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        $breadcrumb = 'Permissions';
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = 'Create Permission';
        return view('admin.permissions.create', compact('breadcrumb'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission created.');
    }

    public function edit(Permission $permission)
    {
        $breadcrumb = 'Edit Permission';
        return view('admin.permissions.edit', compact('permission', 'breadcrumb'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted.');
    }
}
