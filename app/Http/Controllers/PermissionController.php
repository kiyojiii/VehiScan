<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Notification;
use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use \Illuminate\Support\Facades\Facade;
use RealRashid\SweetAlert\Facades\Alert;


class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-permission|edit-permission|delete-permission', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $totalpermissioncount = Permission::count();
        $permissions = Permission::latest()->paginate(5);
        return view('permissions.index', compact('totalpermissioncount', 'permissions'));
    }

    //paginate permission
    public function paginatePermission(Request $request)
    {
        $searchString = $request->query('search_string');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Query builder for filtering by search string if it's provided
        $query = Permission::query();
        if ($searchString) {
            $query->where('name', 'like', '%' . $searchString . '%');
        }

        // Apply date range filter if start date and end date are provided
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        // Paginate the results
        $permissions = $query->latest()->paginate(5);

        // Pass the start date and end date to the view
        $permissions->appends(['start_date' => $startDate, 'end_date' => $endDate]);

        // Render the view with paginated permissions
        return view('permissions.permission_pagination', compact('permissions'))->render();
    }

    //search permission
    public function searchPermission(Request $request)
    {
        $permissions = Permission::where('name', 'like', '%' . $request->search_string . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($permissions->count() >= 1) {
            return view('permissions.permission_pagination', compact('permissions'))->render();
        } else {
            return response()->json([
                'status' => 'nothing_found',
            ]);
        }
    }

    //filter permission
    public function filterPermission(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $permissions = Permission::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->paginate(5);

        return view('permissions.permission_pagination', compact('permissions'))->render();
    }


    public function create()
    {
        $permissions = Permission::paginate(5);
        return view('permissions.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name.*' => 'required|string|max:255', // Validate each name field in the array
            ]);

            $names = $request->input('name'); // Get array of names from the form

            // Iterate over each name and create a new Permission instance
            foreach ($names as $name) {
                Permission::create([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
            }

            // Set success message in session
            session()->flash('permission_created_success', 'Permission created successfully.');

            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function edit($id)
    {

        $permission = Permission::findOrFail($id);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name.*' => 'required|string|max:255', // Validate each name field in the array
            ]);

            $permission = Permission::findOrFail($id);

            // Update each permission name individually
            foreach ($validatedData['name'] as $index => $name) {
                $permission->update([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
            }

            // Set success message in session
            session()->flash('permission_created_success', 'Permission has been updated successfully.');

            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index');
    }
}
