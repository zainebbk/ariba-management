<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Permission as Permissions;
use App\Role as Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['User','UserShow']]);
         $this->middleware('permission:user-edit', ['only' => ['UserUpdate']]);
         $this->middleware('permission:user-create', ['only' => ['ShowAddUser','UserAdd']]);

         $this->middleware('permission:role-list', ['only' => ['Role','RoleShow']]);
         $this->middleware('permission:role-edit', ['only' => ['RoleUpdate']]);
         $this->middleware('permission:role-create', ['only' => ['ShowAddRole','RoleAdd']]);

         $this->middleware('permission:permission-list', ['only' => ['Permission','PermissionShow']]);
         $this->middleware('permission:permission-edit', ['only' => ['PermissionUpdate']]);
         $this->middleware('permission:permission-create', ['only' => ['ShowAddPermission','PermissionAdd']]);
    }
    
    //Users

    public function User()
    {
        $users = User::orderBy('user_id','DESC')->get();

        return view('admin.mains-admin.user.user-list')->with("data", ['users' => $users]);
    }

    public function ShowAddUser()
    {
        $roles = Role::pluck('name','name')->all();

        return view('admin.mains-admin.user.user-add',['roles' => $roles]);
    }

    public function UserShow($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        $userRoles = Role::join("model_has_roles","model_has_roles.role_id","=","id")
            ->where("model_has_roles.model_id",$id)
            ->get("name");

        return view('admin.mains-admin.user.user-show', ['user' => $user, 'roles' => $roles,'userRoles' => $userRoles]);
    }

    public function UserAdd(Request $request)
    {
        $validator = Validator::make($request->all(), self::RulesAdd());
        
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' =>  $request->display_name,
            'phone' =>  $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole($request->roles);

        return Redirect::to("admin/user")->with('success', 'The record has been added successfully');
    }

    public function UserUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), self::RulesAdd($id));
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $updateDetails = [
            'firstname' => $request->firstname ?? '',
            'lastname' => $request->lastname ?? '',
            'email' => $request->email ?? '',
            'display_name' => $request->display_name ?? '',
            'phone' => $request->phone ?? '',
        ];

        $user = User::find($id);
        DB::table('users')->where('user_id', "=", "$id")->update($updateDetails);
        $user->update($request->all());

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->roles);

        return Redirect::to("admin/user")->with('success', 'The record has been updated successfully');
    }

    //ROLES

    public function Role()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.mains-admin.user.role-list',['roles' => $roles]);
    }

    public function ShowAddRole()
    {
        $permissions = Permissions::pluck('name','name')->all();

        return view('admin.mains-admin.user.role-add',['permissions' => $permissions]);
    }

    public function RoleAdd(Request $request)
    {
        $validator = Validator::make($request->all(),  ['name' => 'required|string|max:25|unique:roles,name','permissions'=>'required']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return Redirect::to("admin/role")->with('success', 'The record has been added successfully');
    }
    
    public function RoleShow($id)
    {
        $role = Role::find($id);
        $permissions = Permissions::pluck('name','name')->all();
       
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get("name");

        return view('admin.mains-admin.user.role-show', ['role' => $role, 'rolePermissions' => $rolePermissions,'permissions'=>$permissions]);
    }

    public function RoleUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|string|max:25|unique:roles,name,'.$id,'permissions' =>'required']);
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);

         //app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();


        return Redirect::to("admin/role")->with('success', 'The record has been updated successfully');
    }

    //Permissions

    public function Permission()
    {
        $permissions = Permission::all()->sortBy("name");

        return view('admin.mains-admin.user.permission-list', ['permissions' => $permissions]);
    }

    public function ShowAddPermission()
    {
        return view('admin.mains-admin.user.permission-add',[]);
    }

    public function PermissionAdd(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|string|max:25|unique:permissions,name']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return Redirect::to("admin/permission")->with('success', 'The record has been added successfully');
    }

    public function PermissionShow($id)
    {
        $permission= Permission::find($id);

        return view('admin.mains-admin.user.permission-show', ['permission' => $permission]);
    }

    public function PermissionUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(),['name' => 'required|string|max:25|unique:permissions,name,'.$id]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();

        return Redirect::to("admin/permission")->with('success', 'The record has been updated successfully');
    }

    public function RulesAdd($id=NULL)
    {
        $rules = array(
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'phone' => 'required|digits:10|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required',
        );
        if(!$id==NULL)
        {
            Arr::set($rules, 'email','required|email|unique:users,email,'.$id.',user_id');
            Arr::set($rules, 'password','');
        }

        return $rules;
    }

    public function AttributeNames()
    {
        $attributeNames = array(
            'firstname' => 'first name',
            'lastname' => 'last Name',
            'display_name' => 'user name',
            'phone' => 'phone',
            'email' => "email",
            'roles' => 'role',
        );

        return $attributeNames;
    }
}
