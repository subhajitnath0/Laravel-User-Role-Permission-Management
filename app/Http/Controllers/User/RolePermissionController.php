<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RoleAndPermission;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnCallback;

class RolePermissionController extends Controller
{
    public function index()
    {
        if (!hasPermissions('Role permission')) {
            abort(404, 'Page Not Found');
        }

        return view('user.role-permission.index');
    }

    public function data(Request $request)
    {
        if (!hasPermissions('Role permission')) {
            abort(404, 'Page Not Found');
        }

        $perPage = $request->get('per_page', 15);
        $roles = Roles::paginate($perPage);

        $rolePermissions = [];

        foreach ($roles->getCollection() as $role) {

            $rolePermission = Roles::join('role_and_permission', 'roles.role_id', '=', 'role_and_permission.role')
                ->join('permission', 'role_and_permission.permission', '=', 'permission.permission_id')
                ->select('role_and_permission.id', 'permission.permission_id', 'permission.permission_name')
                ->where('roles.role_id', '=', $role->role_id)
                ->get();

            if ($rolePermission->isNotEmpty()) {
                $rolePermissions[] = [
                    'role_id' => $role->role_id,
                    'role' => $role->role,
                    'Permission' => $rolePermission,
                    'Edit' => count(permissionList()) <= count($rolePermission) ? false : true,  // if permission count is less than or equal to 10 then edit button will be hidden
                ];
            }
        }

        $links = [];

        foreach ($roles->getUrlRange(1, $roles->lastPage()) as $index => $link) {
            $links[] = [
                'url' => $link,
                'label' => $index,
                'active' => $index === $roles->currentPage(),
            ];
        }

        return [
            'current_page' => $roles->currentPage(),
            'data' => $rolePermissions,
            'first_page_url' => $roles->url(1),
            'from' => $roles->firstItem(),
            'last_page' => $roles->lastPage(),
            'last_page_url' => $roles->url($roles->lastPage()),
            'links' => $links,
            'next_page_url' => $roles->nextPageUrl(),
            'path' => $request->url(),
            'per_page' => $perPage,
            'prev_page_url' => $roles->previousPageUrl(),
            'to' => $roles->lastItem(),
            'total' => $roles->total()
        ];
    }

    public function create()
    {

        if (!hasPermissions('Create Role permission')) {
            abort(404, 'Page Not Found');
        }


        $rolesWithoutPermissions = $roles = DB::table('roles')
            ->leftJoin('role_and_permission as rap', 'roles.role_id', '=', 'rap.role')
            ->select('roles.role_id', 'roles.role')
            ->whereNull('rap.role')
            ->whereNull('roles.deleted_at')
            ->groupBy('roles.role_id', 'roles.role', 'roles.description')
            ->get();

        $permissions = permissionList();

        return view('user.role-permission.create', compact('permissions', 'rolesWithoutPermissions'));
    }


    public function store(Request $request)
    {

        if (!hasPermissions('Create Role permission')) {
            abort(404, 'Page Not Found');
        }

        $request->validate([
            'role' => 'required',
            'permissions' => 'required'
        ]);

        if (count(permissionList()) > count($request->permissions)) {
            DB::beginTransaction();

            try {
                foreach ($request->permissions as $permission) {

                    RoleAndPermission::create([
                        'role' => $request->role,
                        'permission' => $permission
                    ]);
                }

                DB::commit();

                return redirect()->route('role-permission.index')->with(['status' => 'success', 'message' => 'Permissions assigned successfully']);
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->route('role-permission.index')->with(['status' => 'danger', 'message' => 'Failed to assign permissions']);
            }
        } else {
            return redirect()->route('role-permission.create')->with(['status' => 'warning', 'message' => 'You cannot provide similar permissions in another role.']);
        }
    }


    public function edit(Request $request, $id)
    {

        if (!hasPermissions('Edit Role permission')) {
            abort(404, 'Page Not Found');
        }

        $rolesPermissionsById = DB::table('roles')
            ->leftJoin('role_and_permission as rap', 'roles.role_id', '=', 'rap.role')
            ->leftJoin('permission as p', 'rap.permission', '=', 'p.permission_id')
            ->select(
                'roles.role_id',
                'roles.role',
                DB::raw('GROUP_CONCAT(p.permission_id) as permission_ids'),
            )
            ->groupBy('roles.role_id', 'roles.role', 'roles.description')
            ->where('roles.role_id', '=', $id)
            ->first();


        $permissions = permissionList();

        return view('user.role-permission.edit', compact('rolesPermissionsById', 'permissions'));
    }

    public function update(Request $request, $id)
    {

        if (!hasPermissions('Edit Role permission')) {
            abort(404, 'Page Not Found');
        }


        $request->validate([
            'permissions' => 'required'
        ]);

        if (count(permissionList()) > count($request->permissions)) {
            DB::beginTransaction();

            try {

                RoleAndPermission::where('role_and_permission.role', '=', $id)->delete();
                $roles = Roles::find($id);

                foreach ($request->permissions as $permission) {

                    RoleAndPermission::create([
                        'role' => $roles->role_id,
                        'permission' => $permission
                    ]);
                }

                DB::commit();

                return redirect()->route('role-permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'success', 'message' => 'Permissions assigned successfully']);
            } catch (\Exception $e) {
                DB::rollBack();
                return $e;

                return redirect()->route('role-permission.index', ['current_page' =>  request()->query('current_page')])->with(['status' => 'danger', 'message' => 'Failed to assign permissions']);
            }
        } else {
            return redirect()->route('role-permission.edit', ['id' => $id, 'current_page' =>  request()->query('current_page')])->with(['status' => 'warning', 'message' => 'You cannot provide similar permissions in another role.']);
        }
    }


    public function delete(Request $request, $id)
    {
        if (!hasPermissions('Delete Role permission')) {
            abort(404, 'Page Not Found');
        }

        $User = User::where('role', '=', $id)->get()->isNotEmpty();
        if (!$User) {
            DB::beginTransaction();

            try {
                RoleAndPermission::where('role_and_permission.role', '=', $id)->delete();

                DB::commit();

                return redirect()->route('role-permission.index', ['current_page' =>  request()->query('current_page')])
                    ->with(['status' => 'success', 'message' => 'Role & Permission Deleted Successfully']);
            } catch (\Exception $e) {

                DB::rollBack();

                return redirect()->route('role-permission.index', ['current_page' =>  request()->query('current_page')])
                    ->with(['status' => 'danger', 'message' => 'Role & Permission Not Found']);
            }
        } else {
            return redirect()->route('role-permission.index', ['current_page' => request()->query('current_page')])
                ->with(['status' => 'warning', 'message' => 'You cannot delete this Roles & Permissions because it is assigned to a user.']);
        }
    }
}
