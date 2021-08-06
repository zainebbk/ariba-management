<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeRegister;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;


class EmployeeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:employee-list', ['only' => ['Employee','ShowAddEmployee']]);
         $this->middleware('permission:employee-create', ['only' => ['ShowAddEmployee','EmployeeAdd']]);
         $this->middleware('permission:company-list', ['only' => ['Company','CompanyShow']]);

    }

    public function Employee()
    {
        $employees = DB::table("employee")->orderBy('employee_id', 'DESC')->get();
        
        return view('admin.mains-admin.employee.employee-list')->with("data", ['employees' => $employees]);
    }

    public function ShowAddEmployee(Request $request)
    {
        return view('admin.mains-admin.employee.employee-add');
    }

    public function EmployeeAdd(Request $request)
    {
        $validator = Validator::make($request->all(), self::RulesAdd());
        $validator->setAttributeNames(self::AttributeNames());
       
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_password = Str::random(10);
        $salt = Str::random(9);
        $password = sha1($salt . sha1($salt . sha1($user_password)));

        $id = DB::table('employee')->insertGetId([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'salt' => $salt,
            'password' => $password,
            'address' => $request->address,
            'city' => $request->city,
            'postcode' => $request->postcode,
        ]);

        Mail::to($request->email)->send(new EmployeeRegister($request->email, $user_password, $request->firstname));

        return Redirect::to("admin/employee")->with('success', 'The record has been added successfully');
    }

    public function Company()
    {
        $companies = DB::table("company")->leftJoin("employee", "company.user_id", "employee.employee_id")
            ->selectRaw("company.*,employee.firstname as e_firstname,employee.lastname as e_lastname,employee.employee_id as e_id")
            ->orderby('date_added', "desc")->get();
        $employees = DB::table("employee")->select('employee_id', 'firstname', 'lastname')->get();
        
        return view('admin.mains-admin.employee.company-list')->with("data", ['companies' => $companies, 'employees' => $employees]);
    }

    public function CompanyShow($id)
    {
        $company = DB::table("company")->where("id", $id)->leftJoin("employee", "company.user_id", "employee.employee_id")
            ->selectRaw("company.*,employee.firstname as e_firstname,employee.lastname as e_lastname,employee.employee_id as e_id")->orderby('date_added', "desc")->first();
        $images = DB::table("company_images")->where("company_id", $id)->get();
       
        $googlemap = "https://www.google.fr/maps/place/" . preg_replace('/[ ]+/', '+', trim($company->address1)) . "+" . $company->city;

        $googlemap2="https://www.google.fr/maps/place/".$company->latitude.",".$company->longitude;

        return view('admin.mains-admin.employee.company-show', ['company' => $company, 'maplink' => $googlemap,'maplink2' => $googlemap2, 'images' => $images]);
    }

    public function getProduct(Request $request)
    {
        $search = $request->search;
        $products = DB::select("SELECT DISTINCT pd.name as 'name',pd.product_id as 'id' FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) where pd.language_id='4' and pd.name Like '%' .$search . '%'  Order by pd.name");
        $response = array();

        foreach ($products as $product) {
            $response[] = array("value" => $product->id_product, "label" => $product->title_p);
        }

        return response()->json($response);
    }

    public function CompanySearch(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id == "none") {
                $companies = DB::table("company")->leftJoin("employee", "company.user_id", "employee.employee_id")
                    ->selectRaw("company.*,employee.firstname as e_firstname,employee.lastname as e_lastname,employee.employee_id as e_id")
                    ->orderby('date_added', "desc")->get();
                return view('admin.mains-admin.employee.company-select', ['companies' => $companies]);
            }
            $companies = DB::table("company")->leftJoin("employee", "company.user_id", "employee.employee_id")
                ->selectRaw("company.*,employee.firstname as e_firstname,employee.lastname as e_lastname,employee.employee_id as e_id")
                ->where("company.user_id", "=", $request->id)
                ->orderby('date_added', "desc")->get();
            
                return view('admin.mains-admin.employee.company-select', ['companies' => $companies]);
        }
    }

    public function RulesAdd()
    {
        $rules = array(
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' => '',
            "email" => "required|email|unique:employee",
            'birthday' => "date",
            'phone' => 'required|digits:10',
            'address' => '',
            'postcode' => '',
            'city' => '',
        );

        return $rules;
    }

    public function AttributeNames()
    {
        $attributeNames = array(
            'firstname' => 'first name',
            'lastname' => 'last Name',
            'display_name' => 'user name',
            'email' => "email",
            'birthday' => "birthday",
            'phone' => 'phone number',
            'address' => 'address',
            'postcode' => 'post code',
            'city' => 'city',
        );

        return $attributeNames;
    }
}
