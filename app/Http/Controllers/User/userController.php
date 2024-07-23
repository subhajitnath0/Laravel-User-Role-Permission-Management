<?php

/**
 * File: UserController.php
 * Description: Controller for managing users.
 * Author: Subhajit Nath
 * Github: https://github.com/subhajitnath0
 * Linkedin: https://www.linkedin.com/in/subhajitnath/
 */


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RoleAndPermission;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{

    public function index()
    {
        // Check permissions to view user management page
        if (!hasPermissions('User')) {
            abort(404, 'Page Not Found');
        }

        // Load the view for managing users
        return view('user.user.index');
    }


    public function data(Request $request)
    {
        // Check permissions to view user data
        if (!hasPermissions('User')) {
            abort(404, 'Page Not Found');
        }

        // Determine number of items per page, default to 15 if not specified
        $perPage = $request->get('per_page', 15);

        // Retrieve paginated user data with associated roles
        $data = User::join('roles', 'users.role', '=', 'roles.role_id')
            ->select('users.*', 'roles.role', 'role_id')
            ->paginate($perPage);

        // Return paginated data as JSON response
        return response()->json($data);
    }



    public function create()
    {
        // Check permissions to create user
        if (!hasPermissions('Create User')) {
            abort(404, 'Page Not Found');
        }

        // Get the ID of the current authenticated user's role
        $roleId = authData()['id'];

        // Subquery to fetch permissions associated with the current user's role
        $role2PermissionsSubquery = RoleAndPermission::select('permission')
            ->where('role', $roleId);

        // Query to fetch roles that are accessible based on permissions
        $roles = RoleAndPermission::from('role_and_permission as rp1')
            ->select('role')
            ->where('role', '<>', $roleId)
            ->whereNotExists(function ($query) use ($role2PermissionsSubquery) {
                $query->select(DB::raw(1))
                    ->from('role_and_permission as rp2')
                    ->whereRaw('rp2.role = rp1.role')
                    ->whereNotIn('rp2.permission', $role2PermissionsSubquery);
            })
            ->groupBy('role')
            ->get();

        // Retrieve role details for roles allowed to be assigned to users
        $rolesInUser = [];
        foreach ($roles as $role) {
            $rolesInUser[] = Roles::where('role_id', $role->role)
                ->select('roles.role_id', 'roles.role')
                ->first();
        }

        // Load the create user view with available roles
        return view('user.user.create', compact('rolesInUser'));
    }


    public function store(Request $request)
    {
        // Check permissions
        if (!hasPermissions('Create User')) {
            abort(404, 'Page Not Found');
        }

        // Validate request data
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z ]{4,60}$/',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required',
            'pincode' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3080|dimensions:max_width=10000,max_height=10000|dimensions:ratio=1/1'
        ], [
            'image.dimensions' => 'Please upload a square image with a maximum width and height of 10,000 pixels and max size 3Mb.',
        ]);



        // Get the ID of the current authenticated user's role
        $roleId = authData()['id'];

        // Subquery to fetch permissions associated with the current user's role
        $role2PermissionsSubquery = RoleAndPermission::select('permission')
            ->where('role', $roleId);

        // Query to fetch roles that are accessible based on permissions
        $roles = RoleAndPermission::from('role_and_permission as rp1')
            ->select('role')
            ->where('role', '<>', $roleId)
            ->whereNotExists(function ($query) use ($role2PermissionsSubquery) {
                $query->select(DB::raw(1))
                    ->from('role_and_permission as rp2')
                    ->whereRaw('rp2.role = rp1.role')
                    ->whereNotIn('rp2.permission', $role2PermissionsSubquery);
            })
            ->groupBy('role')
            ->get();

        $role_chack  = false;
        foreach ($roles as $role) {
            if ($role->role == $request->role_id) {
                $role_chack = true;
                break;
            }
        }

        if (!$role_chack) {
            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again.']);
        }

        // Initialize filename variable
        $filename = null;

        // Transaction start
        DB::beginTransaction();
        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put('user/' . $filename, file_get_contents($image));
            }

            // Create user
            User::create([
                'name' => trim($request->name),
                'email' => trim($request->email),
                'phone' => trim($request->phone),
                'gender' => trim($request->gender),
                'role' => $request->role_id,
                'password' => '123456', // Consider hashing the password
                'address' => trim($request->address),
                'city' => trim($request->city),
                'state' => trim($request->state),
                'country' => trim($request->country),
                'pincode' => trim($request->pincode),
                'image' => $filename
            ]);

            // Commit transaction
            DB::commit();
            return redirect()->route('user.index')->with(['status' => 'success', 'message' => 'User created successfully.']);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Delete uploaded image if transaction fails
            if ($filename && Storage::disk('local')->exists('user/' . $filename)) {
                Storage::disk('local')->delete('user/' . $filename);
            }

            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again.']);
        }
    }

    public function edit(Request $request, $id)
    {

        // Check permissions to create user
        if (!hasPermissions('Edit User')) {
            abort(404, 'Page Not Found');
        }

        $selectedFields = [
            'user_id',
            'name',
            'email',
            'phone',
            'gender',
            'address',
            'city',
            'state',
            'country',
            'pincode',
            'image',
            'role',
        ];
        $user = User::select($selectedFields)->find($id);

        // Get the ID of the current authenticated user's role
        $roleId = authData()['id'];

        if ($user->role == $roleId) {
            return redirect()->route('user.index', ['current_page' => request()->query('current_page')])->with(['status' => 'danger', 'message' => 'Users cannot change their own role.']);
        }

        // Subquery to fetch permissions associated with the current user's role
        $role2PermissionsSubquery = RoleAndPermission::select('permission')
            ->where('role', $roleId);

        // Query to fetch roles that are accessible based on permissions
      $roles = RoleAndPermission::from('role_and_permission as rp1')
            ->select('role')
            ->where('role', '<>', $roleId)
            ->whereNotExists(function ($query) use ($role2PermissionsSubquery) {
                $query->select(DB::raw(1))
                    ->from('role_and_permission as rp2')
                    ->whereRaw('rp2.role = rp1.role')
                    ->whereNotIn('rp2.permission', $role2PermissionsSubquery);
            })
            ->groupBy('role')
            ->get();

        // Retrieve role details for roles allowed to be assigned to users
        $rolesInUser = [];
        $roles_acess = [];
        foreach ($roles as $role) {
            array_push($roles_acess, $role->role);
            $rolesInUser[] = Roles::where('role_id', $role->role)
                ->select('roles.role_id', 'roles.role')
                ->first();
        }
        
        
        if (!in_array($user->role, $roles_acess)){
            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. You have not acess to modyfy this data']);
        }
        
        


        

        // Load the create user view with available roles
        return view('user.user.edit', compact('rolesInUser', 'user'));
    }

    public function showImage($filename)
    {
        if (!Storage::disk('local')->exists('user/' . $filename)) {
            abort(404);
        }

        $imageContent = Storage::disk('local')->get('user/' . $filename);
        $mimeType = Storage::disk('local')->mimeType('user/' . $filename);

        return response($imageContent, 200)
            ->header('Content-Type', $mimeType);
    }

    public function deleteImage($id)
    {
        if (!hasPermissions('Edit User')) {
            abort(404, 'Page Not Found');
        }

       

        $user = User::find($id);

        if (!in_array($user->role, lowerPermissionsIDArray())){
            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. You have not acess to modyfy this data']);
        }


        $filename = $user->image;

        if ('default_image.png' != $user->image) {
            if (Storage::disk('local')->exists('user/' . $filename)) {
                $img = Storage::disk('local')->delete('user/' . $filename);
            }
        } else {
            $img = true;
        }

        $user->image = 'default_image.png';
        $user->save();


        return redirect()->route('user.edit', ['id' => $id, 'current_page' => request()->query('current_page')])->with(['status' => 'success', 'message' => 'User Image Delete Successfully.']);
    }




    public function update(Request $request, $id)
    {
        // Check permissions
        if (!hasPermissions('Create User')) {
            abort(404, 'Page Not Found');
        }

        $user = User::find($id);
        $roleId = authData()['id'];

        if ($user->role == $roleId) {
            return redirect()->route('user.index', ['current_page' => request()->query('current_page')])->with(['status' => 'danger', 'message' => 'Users cannot change their own role.']);
        }


        // Validate request data
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z ]{4,60}$/',
            'email' => 'required|email|unique:users,email,' .  $id . ',user_id',
            'phone' => 'required|numeric|unique:users,phone,' .  $id . ',user_id',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required',
            'pincode' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3080|dimensions:max_width=10000,max_height=10000|dimensions:ratio=1/1'
        ], [
            'image.dimensions' => 'Please upload a square image with a maximum width and height of 10,000 pixels and max size 3Mb.',
        ]);



        // Get the ID of the current authenticated user's role


        // Subquery to fetch permissions associated with the current user's role
        $role2PermissionsSubquery = RoleAndPermission::select('permission')
            ->where('role', $roleId);

        // Query to fetch roles that are accessible based on permissions
        $roles = RoleAndPermission::from('role_and_permission as rp1')
            ->select('role')
            ->where('role', '<>', $roleId)
            ->whereNotExists(function ($query) use ($role2PermissionsSubquery) {
                $query->select(DB::raw(1))
                    ->from('role_and_permission as rp2')
                    ->whereRaw('rp2.role = rp1.role')
                    ->whereNotIn('rp2.permission', $role2PermissionsSubquery);
            })
            ->groupBy('role')
            ->get();

        $role_chack  = false;

       
        $roles_acess = [];
        
        foreach ($roles as $role) {
            array_push($roles_acess, $role->role);
            if ($role->role == $request->role_id) {
                $role_chack = true;
                break;
            }
        }

        if (!in_array($user->role, $roles_acess)){
            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. You have not acess to modyfy this data']);
        }

        if (!$role_chack) {
            return redirect()->route('user.edit', ['id' => $id, 'current_page' => request()->query('current_page')])->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again.']);
        }

        // Initialize filename variable
        $Oldfilename = $user->image;
        $filename = null;

        // Transaction start
        DB::beginTransaction();
        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put('user/' . $filename, file_get_contents($image));
            }

            if ($filename) {

                if ('default_image.png' != $Oldfilename) {
                    if (Storage::disk('local')->exists('user/' . $Oldfilename)) {
                        $img = Storage::disk('local')->delete('user/' . $Oldfilename);
                    }
                } else {
                    $img = true;
                }
            }


            // Update user
            $user->name = trim($request->name);
            $user->email = trim($request->email);
            $user->phone = trim($request->phone);
            $user->gender = $request->gender;
            $user->role = $request->role_id;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->pincode = $request->pincode;
            if ($filename) {
                $user->image = $filename;
            }
            $user->save();

            DB::commit();
            return redirect()->route('user.index')->with(['status' => 'success', 'message' => 'User Update successfully.']);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Delete uploaded image if transaction fails
            if ($filename && Storage::disk('local')->exists('user/' . $filename)) {
                Storage::disk('local')->delete('user/' . $filename);
            }

            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again.']);
        }
    }


    public function delete($id)
    {
        // Check permissions
        if (!hasPermissions('Delete User')) {
            abort(404, 'Page Not Found');
        }
        
        $user = User::find($id);

        if (!in_array($user->role, lowerPermissionsIDArray())){
            return redirect()->route('user.index')->with(['status' => 'danger', 'message' => 'Something went wrong. You have not acess to modyfy this data']);
        }

        $roleId = authData()['id'];

        if ($user->role == $roleId) {
            return redirect()->route('user.index', ['current_page' => request()->query('current_page')])->with(['status' => 'danger', 'message' => 'Users cannot delete their own Profile.']);
        }
        if ($user) {
            // if (Storage::disk('local')->exists('user/' . $user->image)) {
            //     Storage::disk('local')->delete('user/' . $user->image);
            // }
            $user->delete();
            return redirect()->route('user.index')->with(['status' => 'success', 'message' => 'User Delete successfully.']);
        }
    }


    public function view($id){
        $selectedFields = [
            'users.user_id',
            'users.name',
            'users.email',
            'users.phone',
            'users.gender',
            'users.address',
            'users.city',
            'users.state',
            'users.country',
            'users.pincode',
            'users.image',
            'roles.role_id',
            'roles.role',
            'roles.description',
        ];

        $user = User::join('roles', 'users.role', '=', 'roles.role_id')
        ->select($selectedFields)
        ->find($id);

        $permissions = RoleAndPermission::where('role', $user->role_id)
        ->join('permission', 'permission.permission_id', '=', 'role_and_permission.permission')
        ->select('permission.permission_name')
        ->get();
       

        return view('user.user.view', compact('user','permissions'));
    }
}
