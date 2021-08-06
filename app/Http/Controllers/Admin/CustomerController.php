<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:customer-list', ['only' => ['Customer','ShowUpdateCustomer','ShowUpdateBlockedCustomer']]);
         $this->middleware('permission:customer-edit', ['only' => ['UpdateCustomer','UpdateBlockedCustomer']]);
         $this->middleware('permission:customer-create', ['only' => ['ShowAddCustomer','AddCustomer']]);

    }

    public function Customer(){

        $customers=DB::table("oc_customer")->leftJoin('oc_salesagent_customer', 'oc_customer.customer_id', '=', 'oc_salesagent_customer.customer_id')
            ->leftJoin("oc_salesagent","oc_salesagent.salesagent_id","=","oc_salesagent_customer.salesagent_id")
            ->selectRaw("oc_customer.*,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname,oc_customer.email as c_email")
            ->distinct("*")->where("blocked","=",0)->orderby('date_added',"desc")->get();
        
            return view('admin.mains-admin.customer.customer-list')->with("data",['customers'=>$customers]);
    }

    public function CustomerBlocked(){

        $customers=DB::table("oc_customer")->leftJoin('oc_salesagent_customer', 'oc_customer.customer_id', '=', 'oc_salesagent_customer.customer_id')
            ->leftJoin("oc_salesagent","oc_salesagent.salesagent_id","=","oc_salesagent_customer.salesagent_id")
            ->selectRaw("oc_customer.*,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname,oc_customer.email as c_email")
            ->distinct("*")->where("blocked","=",1)->orderby('date_added',"desc")->get();
        
            return view('admin.mains-admin.customer.customer_blocked')->with("data",['customers'=>$customers]);
    }

    public function ShowAddCustomer(){

        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
        ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();
       
        return view('admin.mains-admin.customer.customer-add')->with("data",['salesagents'=>$sales_agents]);
    }

    public function ShowUpdateCustomer($id){
        $customer=DB::table("oc_customer")->where("customer_id",'=',$id)->where("blocked",'=',0)->first();
        $salesagent_id=DB::table('oc_salesagent_customer')->where("customer_id","=",$id)->first();
        
        if($salesagent_id){
           
            $salesagent=DB::table("oc_salesagent")->where("salesagent_id",'=',$salesagent_id->salesagent_id);
            $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
            ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")
            ->union($salesagent)->get();  

        }else{

        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
            ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();  
        
        }

        $googlemap="https://www.google.fr/maps/place/". preg_replace('/[ ]+/', '+', trim($customer->address_1))."+".$customer->postcode."+".$customer->city."/@".$customer->latitude.",".$customer->longitude;

        return view('admin.mains-admin.customer.customer-update')->with("data",['customer'=>$customer,'salesagents'=>$sales_agents,'salesagent_id'=>$salesagent_id,'maplink'=>$googlemap]);
    }

    public function ShowUpdateBlockedCustomer($id){
        $customer=DB::table("oc_customer")->where("customer_id",'=',$id)->where("blocked",'=',1)->first();
        $salesagent_id=DB::table('oc_salesagent_customer')->where("customer_id","=",$id)->first();
        
        if($salesagent_id){
            $salesagent=DB::table("oc_salesagent")->where("salesagent_id",'=',$salesagent_id->salesagent_id);
            $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
            ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")
            ->union($salesagent)->get();  
        
        }else{
        
            $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
            ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();  
        }
        
        $googlemap="https://www.google.fr/maps/place/". preg_replace('/[ ]+/', '+', trim($customer->address_1))."+".$customer->postcode."+".$customer->city."/@".$customer->latitude.",".$customer->longitude;
        
        return view('admin.mains-admin.customer.customer_blocked_update')->with("data",['customer'=>$customer,'salesagents'=>$sales_agents,'salesagent_id'=>$salesagent_id,'maplink'=>$googlemap]);
    }   
    
    public function AddCustomer(Request $request){
        
        $validator = Validator::make ( $request->all(),self::RulesAdd());
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_password =$request->password;
        $salt = Str::random(9);
        $password = sha1($salt . sha1($salt . sha1($user_password)));

        $id=DB::table('oc_customer')->insertGetId([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'address_1' => $request->address_1,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'password' =>  $password,
            'salt' => $salt,
        ]);

        DB::table('oc_address')->insertGetId([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'customer_id' => $id,
            'address_1' => $request->address_1,
            'city' => $request->city,
            'postcode' => $request->postcode,
        ]);
       
        if(!$request->salesagent_id=='none'){
            DB::table('oc_salesagent_customer')->insert([
                'customer_id' => $id,
                'salesagent_id' => $request->salesagent_id,
            ]);
        }

        return Redirect::to("admin/customer")->with('success','The record has been added successfully');        
    }

    public function UpdateCustomer(Request $request,$id){
        
        $validator = Validator::make ( $request->all(),self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        self::update($request,$id);
        
        return Redirect::to("admin/customer")->with('success','The record has been updated successfully');
    
    }

    public function UpdateBlockedCustomer(Request $request,$id){
        
        $validator = Validator::make ( $request->all(),self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        self::update($request,$id);
        
        return Redirect::to("admin/customer/blocked")->with('success','The record has been updated successfully');
    }

    public function update($request,$id){
        $status=1;
        $blocked=0;
        
        if ($request->has('blocked')) {
            $blocked=1;
            $status=0;
        }

        $updateDetails = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'address_1' => $request->address_1,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'status' => $status,
            'blocked' => $blocked
        ];
    
        DB::table('oc_customer')->where('customer_id', "=","$id")->update($updateDetails);
        
        if($request->salesagent_id!='none'){
            DB::table('oc_salesagent_customer')->where('customer_id', "=","$id")->updateOrInsert(
                ['customer_id' => $id],
                ['salesagent_id'=>$request->salesagent_id]
            );

        }else{
            
            DB::table('oc_salesagent_customer')->where('customer_id', "=","$id")->delete();

        }
    }

    public function AttributeNames(){
        $attributeNames = array(
            'firstname' =>'first name',
            'lastname' => 'last Name',
            'display_name' => 'user name',
            'email' => "email",
            'telephone' => 'phone number',
            'address_1' =>'address',
            'postcode' => 'post code',
            'city' => 'city',
        );
        
        return $attributeNames;
    }

    public function Rules($id){
        $rules=array(
            'firstname' =>'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' =>'',
            "email" => "required|email|unique:oc_customer,email,$id,customer_id",
            'telephone' => 'required|digits:10',
            'address_1' =>'required||min:2',
            'postcode' => 'required|numeric',
            'city' => 'required',
        );
        
        return $rules;
    }

    public function RulesAdd(){
        $rules=array(
            'firstname' =>'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' =>'',
            "email" => "required|email|unique:oc_customer",
            'telephone' => 'required|digits:10',
            'address_1' =>'required||min:2',
            'postcode' => 'required|numeric',
            'city' => 'required',
        );
        
        return $rules;
    }
}
