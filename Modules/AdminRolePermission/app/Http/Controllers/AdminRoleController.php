<?php

namespace Modules\AdminRolePermission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Admin;
use Modules\AdminRolePermission\App\Http\Requests\Role\StoreRoleRequest;
use Modules\AdminRolePermission\App\Http\Requests\Role\UpdateRoleRequest;
use Modules\AdminRolePermission\App\Models\Permission;
use Modules\AdminRolePermission\App\Models\Role;

class AdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admincan_permission:roles_manager_list')->only(['index']);
        $this->middleware('admincan_permission:roles_manager_create')->only(['create', 'store']);
        $this->middleware('admincan_permission:roles_manager_edit')->only(['edit', 'update']);
        $this->middleware('admincan_permission:roles_manager_view')->only(['show']);
        $this->middleware('admincan_permission:roles_manager_delete')->only(['destroy']);
        $this->middleware('admincan_permission:assign_permission')->only(['editPermissionsAssign', 'updatePermissionsAssign']);
        $this->middleware('admincan_permission:assign_roles')->only(['editAssignAdminsRoles', 'updateAssignAdminsRoles']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('keyword');
            $roles = Role::filter($search)
                ->latest()
                ->paginate(Admin::getPerPageLimit())
                ->withQueryString();
            return view('adminrolepermission::admin.role.index', compact('roles'));
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Failed to load roles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('adminrolepermission::admin.role.createOrEdit');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Failed to open create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $validateData = $request->validated();
        DB::beginTransaction();
        try {
            Role::create($validateData);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Role $role)
    {
        try {
            $role->load('permissions');
            return view('adminrolepermission::admin.role.show', compact('role'));
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Failed to open show page: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            return view('adminrolepermission::admin.role.createOrEdit', compact('role'));
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Failed to open edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validateData = $request->validated();
        DB::beginTransaction();
        try {
            $role->update($validateData);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }

    public function editPermissionsAssign(Role $role)
    {
        $permissions = Permission::all();
        $assignedPermissionIds = $role->permissions->pluck('id')->toArray();
        return view('adminrolepermission::admin.role.assign-permissions', compact('role', 'permissions', 'assignedPermissionIds'));
    }

    public function updatePermissionsAssign(Request $request, Role $role)
    {
        $permissionIds = $request->input('permissions', []);
        DB::beginTransaction();
        try {
            $role->permissions()->sync($permissionIds);
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Permissions updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', 'Failed to assign permissions: ' . $e->getMessage());
        }
    }

    public function editAssignAdminsRoles(Request $request, Role $role)
    {
        if ($request->ajax()) {
            $search = $request->query('term');
            $admins = Admin::select('id', 'first_name', 'last_name')
                ->when($search, fn($q) => $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%"))
                ->get();

            return response()->json(
                $admins->map(fn($admin) => ['id' => $admin->id, 'text' => $admin->first_name . ' ' . $admin->last_name])
            );
        }

        $admins = Admin::select('id', 'first_name', 'last_name')->get();
        $assignedAdminIds = $role->admins()->pluck('admins.id')->toArray();

        return view('adminrolepermission::admin.role.assign-admins', compact('role', 'admins', 'assignedAdminIds'));
    }

    public function updateAssignAdminsRoles(Request $request, Role $role)
    {
        $request->validate([
            'admins' => 'required|array',
            'admins.*' => 'exists:admins,id',
        ]);

        DB::beginTransaction();
        try {
            $role->admins()->sync($request->admins);
            DB::commit();
            return back()->with('success', 'Admins assigned successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Failed to assign admins: ' . $e->getMessage());
        }
    }
}
