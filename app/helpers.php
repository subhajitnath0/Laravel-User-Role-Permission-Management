<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\RoleAndPermission;
use App\Models\Roles;

function authData()
{
    $user = Auth::user();
    $data = array(
        'id' => $user->user_id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'role' => Roles::select('role_id', 'role', 'description')->where('role_id', $user->role)->first(),
        'address' => $user->address,
        'city' => $user->city,
        'state' => $user->state,
        'country' => $user->country,
        'pincode' => $user->pincode,
        'image' => $user->image,
        'gender' => $user->gender,
    );

    return $data;
}

function roleToPermission($role_id)
{
    return  $rolePermissions = RoleAndPermission::where('role', $role_id)
        ->join('permission', 'permission.permission_id', '=', 'role_and_permission.permission')
        ->select('permission.permission_id', 'permission.permission_name', 'permission.permission_description')
        ->get();
}



function permissionToRole($permission_id)
{
    return $rolePermissions = RoleAndPermission::where('permission', $permission_id)
        ->join('roles', 'roles.role_id', '=', 'role_and_permission.role')
        ->select('roles.role_id', 'roles.role', 'roles.description')
        ->get();
}

function permissionList()
{
    $authData = authData();
    $role_id = $authData['role']->role_id;
    $permissionList = roleToPermission($role_id);
    return $permissionList;
}


function hasPermissions($permissions)
{
    $data = permissionList();
    //  gettype($data);
    foreach ($data as $item) {
        if (strtolower($item['permission_name']) == strtolower($permissions)) {
            return true;
            break;
        }
        
    }

    return false;
}


function lowerPermissionsID(){
    $roleId = authData()['id'];

    $role2PermissionsSubquery = RoleAndPermission::select('permission')
        ->where('role', $roleId);

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
       
        return  $roles;
}

function lowerPermissionsIDArray(){
    $roles = lowerPermissionsID();

    $roles_acess = [];
        
    foreach ($roles as $role) {
        array_push($roles_acess, $role->role);
    }

    return $roles_acess;
}