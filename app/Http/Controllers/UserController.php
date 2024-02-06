<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use App\Models\Concern;
use App\Models\Template;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::latest('id')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
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

        return redirect()->route('users.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        // Get the authenticated user
        // $user = Auth::user();

        $templates = Template::where('user_id', auth()->id())->get();

        // Retrieve the templates published by the user whose profile is being viewed
        $userTemplates = Template::where('user_id', $user->id)->paginate(5);

        // Calculate monthly posting data
        $monthlyPostingsData = $userTemplates->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m');
        })->map(function($item, $key) {
            return $item->count();
        });

        // Retrieve the 4 most viewed templates
        $mostViewedTemplates = Template::orderBy('views', 'desc')->take(4)->get();

        // Loop through each template to count the likes
        foreach ($mostViewedTemplates as $template) {
            $template->likeCount = $template->likes()->count(); // Count the likes for each template
        }

        // Retrieve comments in descending order of creation date
        $comments = Comment::orderBy('created_at', 'desc')->get();

        // Retrieve concerns in descending order of creation date
        $concerns = Concern::orderBy('created_at', 'desc')->get();

        // Count the total number of posts, concerns, comments, and likes
        $totalPosts = Template::count();
        $totalConcerns = Concern::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();

        // Get the total number of posts created by the authenticated user
        $totalUserPosts = Template::where('user_id', $user->id)->count();

        // Get the total number of comments made by the authenticated user
        $totalUserComments = Comment::whereIn('temp_id', function ($query) use ($user) {
            $query->select('id')->from('templates')->where('user_id', $user->id);
        })->count();

        // Get the total number of comments made by the authenticated user
        $totalUserLikes = Like::whereIn('temp_id', function ($query) use ($user) {
            $query->select('id')->from('templates')->where('user_id', $user->id);
        })->count();

        // Get the total number of views for templates created by the authenticated user
        $totalUserViews = Template::where('user_id', $user->id)->sum('views');

        // Retrieve the latest template creation
        $latestTemplate = Template::latest('created_at')->first();
        $activityTemplate = Template::latest('created_at')->get();

        // Get the total number of views for templates created by each user
        $userViews = Template::select('user_id', DB::raw('SUM(views) as total_views'))
        ->groupBy('user_id')
        ->get();

        // You can also get the total views for the current user separately
        $currentUserViews = $userViews->where('user_id', $user->id)->first()->total_views ?? 0;

        // Get the total number of views for templates created by each user
        $userViews = Template::select('user_id', DB::raw('SUM(views) as total_views'))
        ->groupBy('user_id')
        ->get();

        // Retrieve the 4 most viewed templates for the current user
        $mostViewedTemplates = Template::where('user_id', $user->id)
            ->orderBy('views', 'desc')
            ->take(4)
            ->get();

        // Retrieve all users
        $users = User::all();

        // return view('users.show', [
        //     'user' => $user
        // ]);

        // Pass the variables to the view
        return view('users.show', compact('users', 'userViews', 'userTemplates', 'monthlyPostingsData', 'currentUserViews', 'activityTemplate', 'latestTemplate', 'templates', 'mostViewedTemplates', 'comments', 'concerns', 'user', 'totalPosts', 'totalUserLikes', 'totalConcerns', 'totalComments', 'totalLikes', 'totalUserPosts', 'totalUserComments', 'totalUserViews'));
    }
    public function show_pagination(Request $request)
    {
        if ($request->ajax()) {
            $userId = $request->input('user_id');
            $userTemplates = Template::where('user_id', $userId)->paginate(5);
            return view('users.show_pagination', compact('userTemplates', 'userId'))->render();
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();
        
        if(!empty($request->password)){
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

        return redirect()->route('users.index')->withSuccess('User is updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
                ->withSuccess('User is deleted successfully.');
    }
}