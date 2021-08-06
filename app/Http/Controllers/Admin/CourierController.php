<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CourierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:courier', ['only' => ['Courier','ShowUpdateCourier']]);
        $this->middleware('permission:courier-edit', ['only' => ['UpdateCourier','UpdateBlockedCourier']]);
        $this->middleware('permission:courier-create', ['only' => ['ShowAddCourier','AddCourier']]);
    }

    public function Courier()
    {
        $couriers=DB::table("courier")->where("status", '=', 1)->orderby('date_added', "desc")->get();
        
        return view('admin.mains-admin.courier.courier-list')->with("data", ['couriers'=>$couriers]);
    }

    public function ShowAddCourier()
    {
        $cities=DB::table("oc_zone")->where("status", '=', 1)->orderby('zone_id', "asc")->get();
       
        return view('admin.mains-admin.courier.courier-add')->with("data", ['cities'=>$cities]);
    }

    public function ShowUpdateCourier($id)
    {
        $courier=DB::table("courier")->where("courier_id", '=', $id)->first();
        $courier_city=DB::table("courier_city")->where("courier_id", '=', $id)->get();

        return view('admin.mains-admin.courier.courier-update')->with("data", ['courier'=>$courier,'courier_city'=>$courier_city]);
    }
    
    public function AddCourier(Request $request)
    {
        $validator = Validator::make($request->all(), self::Rules());
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contactor = ($request->contactor == "on" ? 1 : 0);
        $id=DB::table('courier')->insertGetId([
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'transportation' => $request->transportation,
            'contractor' => $contactor,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'price' => $request->price,
            'status' => 1
        ]);

        //Store categories
        foreach ($request->cities as $city) {
            DB::table('courier_city')->insert([
                ['courier_id' => $id, 'city' => $city]
            ]);
        }
        
        return Redirect::to("admin/courier")->with('success', 'The record has been added successfully');
    }

    public function UpdateCourier(Request $request, $id)
    {
        $validator = Validator::make($request->all(), self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        self::update($request, $id);
        
        return Redirect::to("admin/courier")->with('success', 'The record has been updated successfully');
    }

    public function UpdateBlockedCourier(Request $request, $id)
    {
        $validator = Validator::make($request->all(), self::Rules($id));
        $validator->setAttributeNames(self::AttributeNames());
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        self::update($request, $id);
        
        return Redirect::to("admin/courier/blocked")->with('success', 'The record has been updated successfully');
    }

    public function update($request, $id)
    {
        $contactor = ($request->contactor == "on" ? 1 : 0);
        $updateDetails = [
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'transportation' => $request->transportation,
            'contractor' => $contactor,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'price' => $request->price,
            'status' => 1
        ];
    
        DB::table('courier')->where('courier_id', "=", "$id")->update($updateDetails);
        
        if ($request->salesagent_id!='none') {
            DB::table('oc_salesagent_customer')->where('customer_id', "=", "$id")->updateOrInsert(
                ['customer_id' => $id],
                ['salesagent_id'=>$request->salesagent_id]
            );
        } else {
            DB::table('oc_salesagent_customer')->where('customer_id', "=", "$id")->delete();
        }
    }

    public function AttributeNames()
    {
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

    public function Rules()
    {
        $rules=array(
            'name' =>'required|min:5',
            'address' => 'required|min:5',
            'transportation' =>'required|min:2',
            'whatsapp' => 'digits:10',
            'phone' => 'required|digits:10',
            'price' => 'required',
            'cities' => 'required'
        );
        
        return $rules;
    }
}
