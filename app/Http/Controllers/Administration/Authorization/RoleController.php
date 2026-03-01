<?php

namespace App\Http\Controllers\Administration\Authorization;

use App\Actions\Authorization\RoleDeleteAction;
use App\Actions\Authorization\RoleEditAction;
use App\Actions\Authorization\RoleForceDeleteAction;
use App\Actions\Authorization\RoleRestoreAction;
use App\Actions\Authorization\RoleShowAction;
use App\Actions\Authorization\RoleStoreAction;
use App\Actions\Authorization\RoleUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Authorization\RoleStoreRequest;
use App\Http\Requests\Administration\Authorization\RoleUpdateRequest;
use App\Http\Resources\Authorization\RoleResource;
use App\Utilities\StatusChanger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $rolesQuery = Role::query();

        $roles = $rolesQuery->select('id', 'name', 'order', 'status', 'is_system', 'is_assignable')
            ->when($request->filled('search'), function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->when($request->filled('status'), function ($query) use ($status) {
            if ($status == 'active') {
                $query->where('status', true);
            }
            else {
                $query->where('status', false);
            }
        })
            ->where('is_assignable', true)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Administration/Authorization/RoleList', [
            'rolesData' => RoleResource::collection($roles),
            'filters' => [
                'status' => $status,
                'search' => $search,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return Inertia::render('Administration/Authorization/RoleCreate');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(RoleStoreRequest $request, RoleStoreAction $action)
    {
        $data = $request->validated();
        try {
            $role = $action->handle($data);
            if ($data['assignPermission']) {
                return redirect()->route('roles.show', $role->id)->with('success', 'Role created successfully! Please assign permision to this role.');
            }
            return redirect()->route('roles.index')->with('success', 'Role created successfully!');
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(Role $role)
    {
        $permissionGroups = Permission::select('id', 'group_name', 'name')->get()->groupBy('group_name');
        return Inertia::render('Administration/Authorization/RoleDetails', [
            'role' => new RoleResource($role->load(['permissions:id,group_name,name'])),
            'permissionGroups' => $permissionGroups
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(RoleUpdateRequest $request, Role $role, RoleUpdateAction $action)
    {
        if ($role->is_system) {
            return redirect()->back()->with('error', 'This role is protected and cannot be modified.');
        }
        $data = $request->validated();
        try {
            $role = $action->handle($role, $data);
            return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Role $role, RoleDeleteAction $action)
    {
        if ($role->is_system) {
            return redirect()->back()->with('error', 'This role is protected and cannot be modified.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'This role is assigned to some users. Please remove the role from the users before deleting it.');
        }

        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
        }
        catch (Exception $e) {
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Change status of the specified resource.
     */

    public function changeStatus(Role $role)
    {
        return StatusChanger::changeStatus($role, 'Role');
    }

    /**
     * Update the permissions for a role
     */
    public function assignPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        if ($role->is_system) {
            return redirect()->back()->with('error', 'This role is protected and cannot be modified.');
        }

        try {
            DB::beginTransaction();
            $role->permissions()->sync($validated['permissions']);
            DB::commit();

            return redirect()
                ->route('roles.show', $role->id)
                ->with('success', 'Permissions updated successfully for role: ' . $role->name);

        }
        catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('roles.show', $role->id)
                ->with(['error' => 'Failed to update permissions: ' . $e->getMessage()]);
        }
    }
}
