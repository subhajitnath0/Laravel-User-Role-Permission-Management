<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RoleAndPermission;
use Illuminate\Http\Request;

class permissionController extends Controller
{
    public function index()
    {
        if (!hasPermissions('Permission')) {
            abort(404, 'Page Not Found');
        }

        return view('user.permission.index');
    }

    public function data(Request $request)
    {
        if (!hasPermissions('Permission')) {
            abort(404, 'Page Not Found');
        }

        $perPage = $request->get('per_page', 15);
        $data = Permission::select('permission_id', 'permission_name', 'permission_description')->paginate($perPage);
        return response()->json($data);
    }

    public function create()
    {
        if (!hasPermissions('Create Permission')) {
            abort(404, 'Page Not Found');
        }
        return view('user.permission.create');
    }

    public function store(Request $request)
    {
        if (!hasPermissions('Create Permission')) {
            abort(404, 'Page Not Found');
        }

        $request->validate([
            'permission_name' => 'required',
            'permission_description' => 'required',
        ]);

        $permission = new Permission();
        $permission->permission_name = $request->permission_name;
        $permission->permission_description = $request->permission_description;
        $permission->save();

        return redirect()->route('permission.index')->with(['status' => 'success', 'message' => 'Permission Created Successfully']);
    }

    public function edit(Request $request, $id)
    {
        if (!hasPermissions('Edit Permission')) {
            abort(404, 'Page Not Found');
        }

        $permission = Permission::select('permission_id', 'permission_name', 'permission_description')->find($id);
        if (empty($permission)) {
            return redirect()->route('permission.index')->with(['status' => 'warning', 'message' => 'Permission Not Exist']);
        }
        $roleAndPermissionExists = RoleAndPermission::where('permission', '=', $id)->get()->isNotEmpty();

        return view('user.permission.edit', compact('permission', 'roleAndPermissionExists'));
    }

    public function update(Request $request, $id)
    {
        if (!hasPermissions('Edit Permission')) {
            abort(404, 'Page Not Found');
        }

        $roleAndPermissionExists = RoleAndPermission::where('permission', '=', $id)->get()->isNotEmpty();
        $permission = Permission::select('permission_id', 'permission_name', 'permission_description')->find($id);

        if (empty($permission)) {
            return redirect()->route('permission.index')->with(['status' => 'warning', 'message' => 'Permission Not Exist']);
        }

        if ($roleAndPermissionExists) {
            $request->validate([
                'permission_description' => 'required',
            ]);

            $permission->permission_description = $request->permission_description;
            $permission->save();

            return redirect()->route('permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'success', 'message' => 'Permission Permission Description Successfully']);
        } else {
            $request->validate([
                'permission_name' => 'required',
                'permission_description' => 'required',
            ]);
            $permission->permission_name = $request->permission_name;
            $permission->permission_description = $request->permission_description;
            $permission->save();

            return redirect()->route('permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'success', 'message' => 'Permission Update Successfully']);
        }
    }

    public function delete(Request $request, $id)
    {
        if (!hasPermissions('Delete Permission')) {
            abort(404, 'Page Not Found');
        }

        $roleAndPermissionExists = RoleAndPermission::where('permission', '=', $id)->get()->isNotEmpty();
        $permission = Permission::select('permission_id', 'permission_name', 'permission_description')->find($id);


        if (empty($permission)) {
            return redirect()->route('permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'warning', 'message'  => 'Permission Not Exist']);
        }


        if ($roleAndPermissionExists) {
            return redirect()->route('permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'warning', 'message' => 'Permission is used by Role']);
        } else {
            $permission->delete();
            return redirect()->route('permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'success', 'message' => 'Permission Delete Successfully']);
        }
    }
}
