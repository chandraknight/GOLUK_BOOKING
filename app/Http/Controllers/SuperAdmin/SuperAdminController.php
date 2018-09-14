<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Hotel;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    /**
     * roles function
     */

    public function roles()
    {
        $roles = Role::all();
        return view('superadmin.roles', ['roles' => $roles]);
    }

    public function addroles(Request $request)
    {
        $role = new Role;

        $role->name = $request->name;
        $role->description = $request->description;

        $role->save();
        return redirect()->back()->withSuccess('Role Successfully Added');
    }

    public function deleterole($id)
    {
        $role = Role::findorfail($id);
        $role->delete();
        return redirect()->back()->withSuccess('Role Successfully deleted');
    }

    public function editrole($id)
    {
        $roles = Role::all();
        $editrole = Role::findorfail($id);
        return view('superadmin.editrole', ['role' => $editrole, 'roles' => $roles]);
    }

    public function updaterole(Request $request)
    {
        $role = Role::findorfail($request->id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('roles')->withSuccess('Role Successfully Updated');
    }

    public function roleAssign()
    {
        $roles = Role::all();
        $users = User::all();
        return view('superadmin.assignrole', ['users' => $users, 'roles' => $roles]);
    }

    public function assignRole(Request $request)
    {
        // dd($request);
        $user = User::findorfail($request->user_id);
        $user->roles()->sync($request->role_id);
        return redirect()->route('users')->withSuccess('Role Assigned Successfully');
    }


    /**
     * users function
     */

    public function users()
    {
        $roles = Role::all();
        $users = User::all();

        return view('superadmin.users', ['roles' => $roles, 'users' => $users]);
    }

    public function viewusers($role)
    {
        $roles = Role::all();
        $users = User::all();
        return view('superadmin.viewusers', ['users' => $users, 'roles' => $roles, 'viewrole' => $role]);
    }

    /**
     * hotels function
     */

    public function hotels()
    {
        $hotels = Hotel::all();
        return view('superadmin.hotels', ['hotels' => $hotels]);
    }

    public function deleteHotel($id)
    {
        if (Auth::user()->hasRole('superadmin')) {
            $hotel = Hotel::findorfail($id);
            $hotel->delete();

            return redirect()->route('hotels')->withSuccess('Hotel Successfully Deleted');
        }
        return redirect()->route('hotels')->withError('Permission Denied');
    }

    public function editUserRole($id) {
        $user = User::findorfail($id);
        $roles = Role::all();
        return view('superadmin.edituserrole',['user'=>$user,'roles'=>$roles]);
    }

    /**
     * Permissions function
     */

    public function permissions()
    {
        $permissions = Permission::all();
        return view('superadmin.permissions', ['permissions' => $permissions]);
    }

    Public function addPermission(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->description = $request->description;

        $permission->save();

        return redirect()->route('permissions')->withSuccess('Permission Succesfully Added');
    }

    public function editPermission($id)
    {
        $permission = Permission::findorfail($id);

        $permissions = Permission::all();

        return view('superadmin.editpermission', ['editpermission' => $permission, 'permissions' => $permissions]);
    }

    public function updatePermission(Request $request)
    {
        $permission = Permission::findorfail($request->id);

        $permission->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('permissions')->withSuccess('Permission Succesfully Updated');
    }

    public function deletePermission($id)
    {
        $permission = Permission::findorfail($id);

        $permission->delete();

        return redirect()->route('permissions')->withSuccess('Permission Successfully Deleted');
    }

    public function permissionAssign()
    {
        $users = User::all();
        $permissions = Permission::all();

        return view('superadmin.assignpermission', ['users' => $users, 'permissions' => $permissions]);
    }

    public function assignPermission(Request $request)
    {
        $user = User::findorfail($request->user_id);
        $permission = Permission::findorfail($request->permission_id);

        $user->permissions()->sync($permission);

        return redirect()->route('users')->withSuccess('Permission Successfully Granted');
    }
}
