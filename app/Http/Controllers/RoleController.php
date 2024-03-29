<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $totalrolecount = Role::count();
        return view('roles.index', compact('totalrolecount'), [
            'roles' => Role::orderBy('id', 'DESC')->paginate(5),
        ]);
    }

    //paginate permission
    public function paginateRole(Request $request)
    {
        $searchString = $request->query('search_string');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Query builder for filtering by search string if it's provided
        $query = Role::query();
        if ($searchString) {
            $query->where('name', 'like', '%' . $searchString . '%');
        }

        // Apply date range filter if start date and end date are provided
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        // Paginate the results
        $roles = $query->latest()->paginate(5);

        // Pass the start date and end date to the view
        $roles->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        // Render the view with paginated permissions
        return view('roles.role_pagination', compact('roles'))->render();
    }

    //search role
    public function searchRole(Request $request)
    {
        $roles = Role::where('name', 'like', '%' . $request->search_string . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($roles->count() >= 1) {
            return view('roles.role_pagination', compact('roles'))->render();
        } else {
            return response()->json([
                'status' => 'nothing_found',
            ]);
        }
    }

    //filter permission
    public function filterRole(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $roles = Role::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->paginate(5);

        return view('roles.role_pagination', compact('roles'))->render();
    }

    // public function fetch_data_role(Request $request)
    // {
    //     $notifications = Notification::where('is_read', false)->get();
    //     $allNotif = Notification::orderBy('created_at', 'desc')->get();

    //     $chats = ChMessage::latest('created_at')->where('to_id', auth()->id())->where('seen', 0)->get();
    //     $userNames = User::whereIn('id', $chats->pluck('to_id'))->pluck('name');

    //     if ($request->ajax()) {
    //         $roles = Role::latest('created_at')->paginate(5);
    //         return view('roles.pagination_role', compact('chats', 'userNames', 'roles', 'notifications', 'allNotif'))->render();
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        // Set success message in session
        session()->flash('role_created_success', 'Role created successfully.');

        return redirect()->route('roles.index');
        //->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        // Set success message in session
        session()->flash('role_updated_success', 'Role has been updated successfully.');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();

        return redirect()->route('roles.index');
        //  ->withSuccess('Role is deleted successfully.');
    }
}
