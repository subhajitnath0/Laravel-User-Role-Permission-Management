<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class roleController extends Controller
{
    public function index()
    {
        if (!hasPermissions('Role')) {
            abort(404, 'Page Not Found');
        }

        return view('user.role.index');
    }

    public function data(Request $request)
    {
        if (!hasPermissions('Role')) {
            abort(404, 'Page Not Found');
        }

        $perPage = $request->get('per_page', 15);
        $data = Roles::paginate($perPage);
        return response()->json($data);
    }

    public function create()
    {
        if (!hasPermissions('Create Role')) {
            abort(404, 'Page Not Found');
        }

        return view('user.role.create');
    }

    public function store(Request $request)
    {
        if (!hasPermissions('Create Role')) {
            abort(404, 'Page Not Found');
        }

        $request->validate([
            'role_name' => 'required',
            'role_description' => 'required',
        ]);


        $data = Roles::create([
            'role' => $request->role_name,
            'description' => $request->role_description,
        ]);

        if (!empty($data)) {
            return redirect()->route('role.index')->with(['status' => 'success', 'message' => 'Role Created Successfully']);
        } else {
            return redirect()->route('role.index')->with(['status' => 'danger', 'message' => 'Role Not Created']);
        }
    }

    public function edit(Request $request, $id)
    {
        if (!hasPermissions('Edit Role')) {
            abort(404, 'Page Not Found');
        }

        $data = Roles::select('roles.role_id', 'roles.role', 'roles.description')->find($id);
        return view('user.role.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        if (!hasPermissions('Edit Role')) {
            abort(404, 'Page Not Found');
        }


        $request->validate([
            'role_description' => 'required',
        ]);

        $roles = Roles::find($id);
        $roles->description = $request->role_description;
        $data = $roles->save();
        if (!empty($data)) {
            return redirect()->route('role.index')->with(['status' => 'success', 'message' => 'Role Updated Successfully']);
        } else {
            return redirect()->route('role.index')->with(['status' => 'danger', 'message' => 'Role Not Updated']);
        }
    }


    public function delete(Request $request, $id)
    {
        if (!hasPermissions('Delete Role')) {
            abort(404, 'Page Not Found');
        }

        $user =  User::where('users.role', '=',  $id)->first();

        if (empty($user)) {
            $Role = Roles::find($id);
            $data = $Role->delete();
            if (!empty($data)) {
                return redirect()->route('role.index')->with(['status' => 'success', 'message' => 'Role Deleted Successfully']);
            } else {
                return redirect()->route('role.index')->with(['status' => 'danger', 'message' => 'Role Not Deleted']);
            }
        } else {
            return redirect()->route('role.index')->with(['status' => 'warning', 'message' => 'Role is used by User']);
        }
    }
}
