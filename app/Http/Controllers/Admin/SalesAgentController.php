<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SaleAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailFields;
use Illuminate\Validation\Rule;

class SalesAgentController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:salesagent-first-approve', ['only' => ['SalesAgentFirstApprove','FirstApprove']]);
         $this->middleware('permission:salesagent-pending', ['only' => ['SalesAgentPending','Disapprove']]);
         $this->middleware('permission:salesagent-edit', ['only' => ['UpdateSalesAgent']]);
         $this->middleware('permission:salesagent-second-approve', ['only' => ['SalesAgentSecondApprove','ShowUpdateSalesAgent']]);
         $this->middleware('permission:salesagent-approved', ['only' => ['SalesAgentApproved','ShowUpdateSalesAgentApproved','UpdateSalesAgentApproved']]);
         $this->middleware('permission:salesagent-blocked', ['only' => ['SalesAgentBlocked','ShowUpdateSalesAgentBlocked','UpdateSalesAgentBlocked']]);
    }

    public function salesAgentFirstApprove(){
        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',0)->where("status",'=',0)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.sales-agent.sales-agent-first-approval')->with("data",['sales_agents'=>$sales_agents]);
    }

    public function salesAgentPending(){
        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',0)
        ->where("send_informations",'=',0)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.sales-agent.sales-agent-pending-list')->with("data",['sales_agents'=>$sales_agents]);
    }

    public function salesAgentSecondApprove(){
        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',0)
        ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.sales-agent.sales-agent-second-approval')->with("data",['sales_agents'=>$sales_agents]);
    }

    public function salesAgentApproved(){
        $sales_agents=DB::table("oc_salesagent")->where("approved",'=',1)->where("status",'=',1)
        ->where("send_informations",'=',1)->where("tmp_blocked",'=',0)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.sales-agent.sales-agent-approved-list')->with("data",['sales_agents'=>$sales_agents]);
    }

    public function salesAgentBlocked(){
        $sales_agents=DB::table("oc_salesagent")->where("tmp_blocked",'=',1)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.sales-agent.blocked-list')->with("data",['sales_agents'=>$sales_agents]);
    }

    public function showUpdateSalesAgent($id){
        $sales_agent=DB::table("oc_salesagent")->where("salesagent_id",'=',$id)->where("status",'=',0)->where("approved",'=',1)->where("tmp_blocked",'=',0)->first();

        return view('admin.mains-admin.sales-agent.sales-agent-update')->with("data",['sales_agent'=>$sales_agent]);
    }

    public function showUpdateSalesAgentApproved($id){
        $sales_agent=DB::table("oc_salesagent")->where("salesagent_id",'=',$id)->where("status",'=',1)->first();

        return view('admin.mains-admin.sales-agent.sales-agent-update-approved')->with("data",['sales_agent'=>$sales_agent]);
    }

    public function showUpdateSalesAgentBlocked($id){
        $sales_agent=DB::table("oc_salesagent")->where("salesagent_id",'=',$id)->where("tmp_blocked",'=',1)->first();

        return view('admin.mains-admin.sales-agent.sales-agent-update-blocked')->with("data",['sales_agent'=>$sales_agent]);
    }

    public function firstApprove(Request $request){
        if($request->ajax()) {
            DB::table('oc_salesagent')->where('salesagent_id', "=","$request->salesagent_id")->update(['approved' => 1]);

            return response()->json(['id' => $request->salesagents_id]);
        }
    }

    public function disapprove(Request $request){
        if($request->ajax()) {
            DB::table('oc_salesagent')->where('salesagent_id', "=","$request->salesagent_id")->update(['approved' => 0]);

            return response()->json(['id' => $request->salesagents_id]);
        }
    }

    public function updateSalesAgent(Request $request,$id){
        if($request->action=="Send for modification"){
            $checkboxes = $request->input('send-email');
            $fields=array();
            if(in_array('image',  $checkboxes))
            array_push($fields, "user image");
            if(in_array('identity_picture1',  $checkboxes) || in_array('identity_picture2',  $checkboxes))
                array_push($fields, "identity card picture");
            if(in_array('address',  $checkboxes))
                array_push($fields, "address");
            if(in_array('postcode',  $checkboxes))
                array_push($fields, "post code");
            if(in_array('city',  $checkboxes))
                array_push($fields, "city");
            if(in_array('country',  $checkboxes))
                array_push($fields, "country");
            if(in_array('bank_name',  $checkboxes))
                array_push($fields, "bank name");
            if(in_array('rib',  $checkboxes))
                array_push($fields, "RIB");
            if(in_array('bank_owner_telephone', $checkboxes))
                array_push($fields, "bank owner phone");
            if(in_array('bank_owner_name',  $checkboxes))
                array_push($fields, "bank owner name");

            $email=DB::table("oc_salesagent")->where("salesagent_id","=",$request->id)->get("email");
            $firstname=DB::table('oc_salesagent')->where("salesagent_id","=",$request->id)->first()->firstname;
            //send email

            Mail::to($email)->send(new SendEmailFields($fields,$firstname));
            DB::table('oc_salesagent')->where('salesagent_id', "=","$request->id")->update(array('send_informations' => 0,'status'=>0));
            return Redirect::to('admin/sales-agent/second-approval')->with('success','The email has been sent successfully');

        }else
        {
            $validator = Validator::make ( $request->all(),self::Rules($id));
            $validator->setAttributeNames(self::AttributeNames());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            self::update($request,$id,0);

            return Redirect::to("admin/sales-agent/second-approval")->with('success','The record has been updated successfully');
         }
    }

    public function updateSalesAgentApproved(Request $request,$id){
        $validator = Validator::make ( $request->all(),self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }

        self::update($request,$id,0);

        return Redirect::to("admin/sales-agent/approved")->with('success','The record has been updated successfully');
    }

    public function updateSalesAgentBlocked(Request $request,$id){
        if (!$request->has('tmp_blocked'))
            $status=1;

        $validator = Validator::make ( $request->all(),self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        self::update($request,$id,$status);

        return Redirect::to("admin/sales-agent/blocked")->with('success','The record has been updated successfully');
    }

    public function AttributeNames(){
        $attributeNames = array(
            'firstname' =>'first name',
            'lastname' => 'last Name',
            'display_name' => 'user name',
            'birthday' => 'birthday',
            'email' => "email",
            'telephone' => 'phone number',
            'address' =>'address',
            'postcode' => 'post code',
            'city' => 'city',
            'country' => 'country',
            'bank_name' => 'bank name',
            'rib' => 'RIB',
            'bank_owner_telephone' =>'bank owner phone',
            'bank_owner_name' =>'bank owner name',
         );

         return $attributeNames;
    }

    public function Rules($id){
        $rules=array(
            'firstname' =>'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' => 'required|min:2',
            'birthday' => 'required',
            "email" => "required|email|unique:oc_salesagent,email,$id,salesagent_id",
            'telephone' => 'required|digits:10',
            'address' =>'',
            'postcode' => '',
            'city' => '',
            'country' => '',
            'bank_name' => '',
            'rib' => '',
            'bank_owner_telephone' =>'',
            'bank_owner_name' =>'',
        );

        return $rules;
    }

    public function update($request,$id,$status){
        $tmp_blocked=0;

        if ($request->has('status')) {
           $status=1;
        }

        if ($request->has('tmp_blocked')) {
            $tmp_blocked=1;
            $status=0;
        }

        $updateDetails = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'country' => $request->country,
            'bank_name' => $request->bank_name,
            'rib' => $request->rib,
            'bank_owner_telephone' => $request->bank_owner_telephone,
            'bank_owner_name' => $request->bank_owner_name,
            'status' => $status,
            'tmp_blocked' => $tmp_blocked
        ];

        DB::table('oc_salesagent')->where('salesagent_id', "=","$id")->update($updateDetails);
    }
}
