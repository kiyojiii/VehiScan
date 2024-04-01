<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use App\Models\Concern;
use App\Models\Template;
use App\Models\Notification;
use App\Models\Category;
use App\Models\ChMessage;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;



class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $totalusercount = User::count();
        $roles = Role::all();

        return view('users.index', compact('totalusercount'), [
            'users' => User::latest('id')->paginate(5),
            'roles' => $roles,
        ]);
    }

    //paginate user
    public function paginateUser(Request $request)
    {
        $searchString = $request->query('search_string');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $selectedRoles = $request->query('roles'); // Get the selected roles

        // Query builder for filtering by search string if it's provided
        $query = User::query();
        if ($searchString) {
            $query->where(function ($query) use ($searchString) {
                $query->where('name', 'like', '%' . $searchString . '%')
                    ->orWhere('email', 'like', '%' . $searchString . '%');
            });
        }

        // Apply date range filter if start date and end date are provided
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        // Apply role filter if selected roles are provided
        if ($selectedRoles) {
            // Join with model_has_roles table to get users with selected roles
            $query->join('model_has_roles', function ($join) use ($selectedRoles) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->whereIn('model_has_roles.role_id', $selectedRoles)
                    ->where('model_has_roles.model_type', '=', 'App\Models\User');
            });
        }

        // Paginate the results
        $users = $query->latest()->paginate(5);

        // Pass the start date, end date, and selected roles to the view
        $users->appends([
            'search_string' => $searchString,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'roles' => $selectedRoles
        ]);

        // Render the view with paginated users
        return view('users.user_pagination', compact('users'))->render();
    }

    //search user
    public function searchUser(Request $request)
    {
        $users = User::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search_string . '%')
                ->orWhere('email', 'like', '%' . $request->search_string . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($users->count() >= 1) {
            return view('users.user_pagination', compact('users'))->render();
        } else {
            return response()->json([
                'status' => 'nothing_found',
            ]);
        }
    }

    //filter user
    public function filterUser(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $selectedRoles = $request->roles; // Get the selected roles

        $query = User::query();

        // Apply date range filter if start date and end date are provided
        if ($start_date && $end_date) {
            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        }

        // Apply role filter if selected roles are provided
        if ($selectedRoles) {
            // Join with model_has_roles table to get users with selected roles
            $query->join('model_has_roles', function ($join) use ($selectedRoles) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->whereIn('model_has_roles.role_id', $selectedRoles)
                    ->where('model_has_roles.model_type', '=', 'App\Models\User');
            });
        }

        // Paginate the results
        $users = $query->latest()->paginate(5);

        // Pass the start date, end date, and selected roles to the view
        $users->appends([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'roles' => $selectedRoles
        ]);

        // Render the view with paginated users
        return view('users.user_pagination', compact('users'))->render();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        // Store user data
        $user = User::create($input);
        $user->assignRole($request->roles);

        // Store user photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = 'photo_' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/photos/'), $photoName);
            $user->photo = $photoName;
            $user->save();
        }

        // Set success message in session
        session()->flash('user_created_success', 'User created successfully.');

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        // Delete old photo and upload new photo
        if ($request->hasFile('photo')) {
            $oldPhoto = $user->photo;

            // Delete old photo
            if ($oldPhoto) {
                $oldPhotoPath = public_path('images/photos/') . $oldPhoto;
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Upload new photo
            $photo = $request->file('photo');
            $photoName = 'photo_' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/photos/'), $photoName);
            $user->update(['photo' => $photoName]);
        }


        // Set success message in session
        session()->flash('user_created_success', 'User has been updated successfully.');

        return back()->withSuccess('Your Profile has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('users.index');
    }
}
