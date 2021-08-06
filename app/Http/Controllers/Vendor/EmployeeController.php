<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\VendorEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    protected $vendor = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->vendor=auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    //VendorEmployees

    public function Employee()
    {
        $users = VendorEmployee::with('roles')->orderBy('vendor_employee_id','DESC')->where('vendor_id',$this->vendor)->get();

        return view('vendor.employee.user-list')->with("data", ['users' => $users]);
    }

    public function ShowAddEmployee()
    {
        $roles =DB::table('employee_role')->where("vendor_id",$this->vendor)->get();

        return view('vendor.employee.user-add',['roles' => $roles]);
    }

    public function EmployeeShow($id)
    {
        $user = VendorEmployee::find($id);
        $roles =DB::table('employee_role')->where("vendor_id",$this->vendor)->get();

        $userRoles = DB::table('employee_to_role')->where("employee_id",$id)->where("vendor_id",$this->vendor)
            ->get("role_id");

        return view('vendor.employee.user-show', ['user' => $user, 'roles' => $roles,'userRoles' => $userRoles]);
    }

    public function EmployeeAdd(Request $request)
    {
        $validator = Validator::make($request->all(), self::RulesAdd());

        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $salt = Str::random(9);
        $password=sha1($salt.sha1($salt.sha1($request['password'])));

        $user = VendorEmployee::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' =>  $request->display_name,
            'phone' =>  $request->phone,
            'email' => $request->email,
            'salt' => $salt,
            'password' =>$password,
            'vendor_id' => $this->vendor,
            'birthday' => $request->birthday,
        ]);

        foreach ($request->roles as $role) {
            DB::table('employee_to_role')->insert([
                ['employee_id'=>$user->vendor_employee_id,'vendor_id'=>$this->vendor,'role_id'=>$role]
            ]);
        }

        return Redirect::to("vendor/employee")->with('success', 'The record has been added successfully');
    }

    public function EmployeeUpdate(Request $request,$id)
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

        $user = VendorEmployee::find($id);
        DB::table('users')->where('user_id', "=", "$id")->update($updateDetails);
        $user->update($request->all());
        
        DB::table('employee_to_role')->where('employee_id', '=', $id)->where('vendor_id', '=', $this->vendor)->delete();
        foreach ($request->roles as $role) {
            DB::table('employee_to_role')->insert([
                ['employee_id'=>$id,'vendor_id'=>$this->vendor,'role_id'=>$role]
            ]);
        }

        return Redirect::to("vendor/employee")->with('success', 'The record has been updated successfully');
    }

    //ROLES

    public function Role()
    {
        $roles =DB::table('employee_role')->where('vendor_id',$this->vendor)->get();

        return view('vendor.employee.role-list', ['roles' => $roles]);
    }

    public function ShowAddRole()
    {
        $permissions =DB::table('employee_permission')->get();

        return view('vendor.employee.role-add',['permissions' => $permissions]);
    }

    public function RoleAdd(Request $request)
    {
        $name=$request->name;
        $vendor_id=$this->vendor;

        $validator =Validator::make($request->all(), [
                'name' => [
                    'required','string','max:25',
                    Rule::unique('employee_role')->where(function ($query) use($name,$vendor_id) {
                        return $query->where('name', $name)
                            ->where('vendor_id',$vendor_id);
                    }),
                ],
                'permissions'=>['required']
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = DB::table('employee_role')->insertGetId(['name' => $request->name,'vendor_id' =>  $vendor_id]);
        foreach ($request->permissions as $permission) {
            DB::table('employee_role_to_permission')->insert([
                ['role_id'=>$id,'vendor_id'=>$vendor_id,'permission_id'=>$permission]
            ]);
        }

        return Redirect::to("vendor/role")->with('success', 'The record has been added successfully');
    }

    public function RoleShow($id)
    {
        $role =DB::table('employee_role')->where("role_id",$id)->where("vendor_id",$this->vendor)->first();

        $permissions =DB::table('employee_permission')->get();

        $rolePermissions = DB::table('employee_role_to_permission')
            ->where("role_id",$id)->where('vendor_id',$this->vendor)
            ->get("permission_id");

        return view('vendor.employee.role-show', ['role' => $role, 'rolePermissions' => $rolePermissions,'permissions'=>$permissions]);
    }

    public function RoleUpdate(Request $request,$id)
    {
        $name=$request->name;
        $vendor_id=$this->vendor;

        $validator =Validator::make($request->all(), [
                'name' => [
                    'required','string','max:25',
                    Rule::unique('employee_role')->where(function ($query) use($name,$vendor_id,$id) {
                        return $query->where('name', $name)
                            ->where('vendor_id',$vendor_id) ->where('role_id','<>',$id);
                    }),
                ],
                'permissions'=>['required']
            ]
        );
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('employee_role')->where('role_id',$id)->where('vendor_id',$this->vendor)->update(['name' => $request->name]);

        DB::table('oc_product_to_category')->where('product_id', '=', $id)->delete();
        foreach ($request->permissions as $permission) {
            DB::table('employee_role_to_permission')->insert([
                ['role_id'=>$id,'vendor_id'=>$vendor_id,'permission_id'=>$permission]
            ]);
        }

        return Redirect::to("vendor/role")->with('success', 'The record has been updated successfully');
    }

    //Permissions

    public function Permission()
    {
        $permissions =DB::table('employee_permission')->get();

        return view('vendor.employee.permission-list', ['permissions' => $permissions]);
    }

    public function ShowAddPermission()
    {
        return view('vendor.employee.permission-add');
    }

    public function PermissionAdd(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'name' => ['required','string','max:25','unique:employee_permission,name'],
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission = DB::table('employee_permission')->insert(['name' => $request->name]);

        return Redirect::to("vendor/permission")->with('success', 'The record has been added successfully');
    }

    public function PermissionShow($id)
    {
        $permission= DB::table('employee_permission')->where("permission_id",$id)->first();

        return view('vendor.employee.permission-show', ['permission' => $permission]);
    }

    public function PermissionUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(),['name' => 'required|string|max:25|unique:permissions,name,'.$id]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::table('employee_permission')->where("permission_id",$id)->update(["name"=>$request->name]);

        return Redirect::to("vendor/permission")->with('success', 'The record has been updated successfully');
    }

    public function RulesAdd($id=NULL)
    {
        $rules = array(
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'phone' => 'required|digits:10|max:255',
            'email' => 'required|string|email|max:255|unique:oc_vendor',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'nullable',
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
