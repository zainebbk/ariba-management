<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:vendor-list', ['only' => ['Vendor','VendorPending','VendorVerified','ShowUpdateVendor']]);
         $this->middleware('permission:vendor-approve', ['only' => ['Approve']]);
         $this->middleware('permission:vendor-disapprove', ['only' => ['Disapprove']]);
         $this->middleware('permission:vendor-edit', ['only' => ['UpdateVendor']]);
         $this->middleware('permission:vendor-create', ['only' => ['ShowAddVendor','AddVendor']]);
    }

    public function Vendor(){
        $vendors=DB::select("SELECT *, CONCAT(firstname, ' ', lastname) AS vendorname , 
        (SELECT count(*) as total FROM  oc_vendor_to_product where vendor_id=v.vendor_id) 
        AS totalproduct, vd.name as store FROM oc_vendor v left join oc_vendor_description vd on 
        vd.vendor_id=v.vendor_id where vd.language_id=1 and v.vendor_id<>0 order by date_added DESC");

        return view('admin.mains-admin.vendor.vendor-list')->with("data",['vendors'=>$vendors]);
    }

    public function VendorFirstApproval(){
        $vendors=DB::table("oc_vendor")->where("approved",'=',0)->where("status",'=',0)->orderby('date_added',"desc")->get();

        return view('admin.mains-admin.vendor.vendor-first-approval')->with("data",['vendors'=>$vendors]);
    }

    public function VendorPending(){
        $vendors=DB::select("SELECT *, CONCAT(firstname, ' ', lastname) AS vendorname , 
        (SELECT count(*) as total FROM  oc_vendor_to_product where vendor_id=v.vendor_id) 
        AS totalproduct ,vd.name as store FROM oc_vendor v,oc_vendor_description vd 
        where vd.vendor_id=v.vendor_id and vd.language_id=1 and v.vendor_id<>0 and 
        status=0 and approved=1 and send_informations=0 order by date_added DESC");

        return view('admin.mains-admin.vendor.vendor-list-pending')->with("data",['vendors'=>$vendors]);
    }

    public function VendorSecondApproval(){
        $vendors=DB::select("SELECT *, CONCAT(firstname, ' ', lastname) AS vendorname ,
         (SELECT count(*) as total FROM  oc_vendor_to_product where vendor_id=v.vendor_id) 
         AS totalproduct, vd.name as store FROM oc_vendor v,oc_vendor_description vd 
        where vd.vendor_id=v.vendor_id and vd.language_id=1 and v.vendor_id<>0 and 
        status=0 and approved=1 and send_informations=1 order by date_added DESC");

        return view('admin.mains-admin.vendor.vendor-second-approval')->with("data",['vendors'=>$vendors]);
    }

    public function VendorVerified(){
        $vendors=DB::select("SELECT *, CONCAT(firstname, ' ', lastname) AS vendorname , 
        (SELECT count(*) as total FROM  oc_vendor_to_product where vendor_id=v.vendor_id) 
        AS totalproduct, vd.name as store FROM oc_vendor v,oc_vendor_description vd 
        where vd.vendor_id=v.vendor_id and vd.language_id=1 and v.vendor_id<>0 and
         status=1 and approved=1 and send_informations=1 order by date_added DESC");

        return view('admin.mains-admin.vendor.vendor-list-verified')->with("data",['vendors'=>$vendors]);
    }

    public function Approve(Request $request){
        if($request->ajax()) {
            DB::table('oc_vendor')->where('vendor_id', "=","$request->vendor_id")->update(['approved' => 1]);

            return response()->json(['success' => true]);
        }
    }

    public function Disapprove(Request $request){
        if($request->ajax()) {
            DB::table('oc_vendor')->where('vendor_id', "=","$request->vendor_id")->update(['approved' => 0]);

            return response()->json(['success' => true]);
        }
    }

    public function ShowAddVendor()
    {
        $countries=DB::table("oc_country")->where("status","=","1")->get();

        return view('admin.mains-admin.vendor.vendor-add')->with("data",['countries'=>$countries]);
    }

    public function ShowUpdateVendor($id)
    {
        $vendor=DB::table("oc_vendor")->where("vendor_id","=","$id")->first();
        $description_ar=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$id." AND pd.language_id=2");
        $description_fr=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$id." AND pd.language_id=4");
        $description_eng=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$id." AND pd.language_id=1 LIMIT 1");

        return view('admin.mains-admin.vendor.vendor-update',['vendor'=>$vendor,'description_ar'=>$description_ar,'description_fr'=>$description_fr,'description_eng'=>$description_eng]);
    }

    public function GetZones(Request $request)
    {
        if($request->ajax()) {
            $zones = DB::table("oc_zone")->where("country_id","=","$request->country_id")->where("status","=","1")->get();
            return response()->json(array("zone"=>$zones));
            $zone = array();
            foreach($zones as $zone){
                $zone[] = array("zone_id"=>$zone->zone_id,"name"=>$zone->name);
            }
            return response()->json($zone);
        }
    }
    public function AddVendor(Request  $request){
        //INPUT VALIDATION
        $validator = Validator::make ( $request->all(),self::RulesAdd());
        $validator->setAttributeNames(self::AttributeNames());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('image')) {
            $imageName = 'catalog/Vendors/'.$request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
        }
        if ($request->has('identity_picture1')) {
            $identity_picture1 = 'catalog/Vendors/'.$request->file('identity_picture1')->getClientOriginalName();
            Storage::disk('ftp')->put($identity_picture1, fopen($request->file('identity_picture1'), 'r+'));
        }

        if ($request->has('identity_picture2')) {
            $identity_picture2 = 'catalog/Vendors/'.$request->file('identity_picture2')->getClientOriginalName();
            Storage::disk('ftp')->put($identity_picture2, fopen($request->file('identity_picture2'), 'r+'));
        }
        if ($request->has('company_trade_register')) {
            $company_trade_register = 'catalog/Vendors/Register/' . $request->file('company_trade_register')->getClientOriginalName();
            Storage::disk('ftp')->put($company_trade_register, fopen($request->file('company_trade_register'), 'r+'));
        }
        if ($request->has('company_status')) {
            $company_status = 'catalog/Vendors/Status/' . $request->file('company_status')->getClientOriginalName();
            Storage::disk('ftp')->put($company_status, fopen($request->file('company_status'), 'r+'));
        }
        if ($request->has('company_tax')) {
            $company_tax = 'catalog/Vendors/Tax/' . $request->file('company_tax')->getClientOriginalName();
            Storage::disk('ftp')->put($company_tax, fopen($request->file('company_tax'), 'r+'));
        }
        if ($request->has('company_registration')) {
            $company_registration = 'catalog/Vendors/Registration/' . $request->file('company_registration')->getClientOriginalName();
            Storage::disk('ftp')->put($company_registration, fopen($request->file('company_registration'), 'r+'));
        }
        if ($request->has('logo')) {
            $logo = 'catalog/Vendors/Logo/' . $request->file('logo')->getClientOriginalName();
            Storage::disk('ftp')->put($logo, fopen($request->file('logo'), 'r+'));
        }
        if ($request->has('banner')) {
            $banner = 'catalog/Vendors/Banner/' . $request->file('banner')->getClientOriginalName();
            Storage::disk('ftp')->put($banner, fopen($request->file('banner'), 'r+'));
        }
        $salt = Str::random(9);

        $password=sha1($salt.sha1($salt.sha1($request->password)));

        //Store in product
        $id=DB::table('oc_vendor')->insertGetId([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'image' => $imageName ?? '',
            'identity_picture1' => $identity_picture1 ?? '',
            'identity_picture2' => $identity_picture2 ?? '',
            'telephone' => $request->telephone,
            'salt' => $salt,
            'password' => $password,
            'fax' => $request->fax,
            'type'=>$request->type,
            'is_pre_order'=>$request->is_pre_order ?? 0,
            'supplier_email'=>$request->supplier_email ?? "",
            'company_trade_register'=>$company_trade_register ?? '',
            'company_status'=>$company_status ?? '',
            'company_tax'=>$company_tax ?? '',
            'company_registration'=>$company_registration?? '',
            'logo'=>$request->logo ,
            'banner'=>$request->banner,
            'about'=>'',
            'company'=>'',
            'postcode'=>$request->postcode,
            'address_1'=>$request->address_1,
            'address_2'=>'',
            'country_id' => 144,
            'city' => $request->city,
            'map_url' =>' ',
            'facebook_url'=>'',
            'google_url' => '',
            'product_status' => 0,
            'approved' => $request->status,
            'status'=> $request->status,
            'language_id'=>1,
            'payment_method'=>'banktransfer',
            'paypal' => '',
            'bank_name' => $request->bank_name,
            'bank_branch_number' => '',
            'bank_swift_code' => '',
            'bank_account_name'=>$request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'store_about' => '',
            'tax_number' => '',
            'shipping_charge' => '',
            'store_logowidth'=>'',
            'store_logoheight' => '',
            'store_bannerheight' => '',
            'commission' => ''
    ]);

    DB::table('oc_vendor_description')->insert([
        'vendor_id'=>$id,
        'language_id' => 1,
        'name' => $request->name_1 ?? '',
        'description' => $request->description_1 ?? '',
        'shipping_policy' => $request->shipping_policy_1 ?? '',
        'return_policy' => $request->return_policy_1 ?? '',
    ]);

    DB::table('oc_vendor_description')->insert([
        'vendor_id'=>$id,
        'language_id' => 4,
        'name' => $request->name_2 ?? '',
        'description' => $request->description_2 ?? '',
        'shipping_policy' => $request->shipping_policy_2 ?? '',
        'return_policy' => $request->return_policy_2?? '',
    ]);

    DB::table('oc_vendor_description')->insert([
        'vendor_id'=>$id,
        'language_id' => 2,
        'name' => $request->name_3 ?? '',
        'description' => $request->description_3 ?? '',
        'shipping_policy' => $request->shipping_policy_3 ?? '',
        'return_policy' => $request->return_policy_3 ?? '',
    ]);

    $fullname=$request->firstname." ".$request->lastname;
    DB::table('depot')->insert([
        'name'=>$request->name_1 ?? '',
        'vendor_id' => $id,
        'vendor_name' => $fullname ?? NULL,
        'address' => $request->address_1 ?? '',
        'volume' => 0,
    ]);

    return Redirect::to("admin/vendor")->with('success','The record has been added successfully');
    }

    public function UpdateVendor(Request  $request,$id){
       // dd($request->file('banner'));
        $vendor=DB::table('oc_vendor')->where("vendor_id",$id)->first();;

        $validator = Validator::make ( $request->all(),self::RulesUpdate($id));
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('image')) {
            $imageName = 'catalog/Vendors/' . $request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
        }
        if ($request->has('identity_picture1')) {
            $id_image_1 = 'catalog/Vendors/ID/' . $request->file('identity_picture1')->getClientOriginalName();
            Storage::disk('ftp')->put($id_image_1, fopen($request->file('identity_picture1'), 'r+'));
        }
        if ($request->has('identity_picture2')) {
            $id_image_2 = 'catalog/Vendors/ID/' . $request->file('identity_picture2')->getClientOriginalName();
            Storage::disk('ftp')->put($id_image_2, fopen($request->file('identity_picture2'), 'r+'));
        }
        if ($request->has('company_trade_register')) {
            $company_trade_register = 'catalog/Vendors/Register/' . $request->file('company_trade_register')->getClientOriginalName();
            Storage::disk('ftp')->put($company_trade_register, fopen($request->file('company_trade_register'), 'r+'));
        }
        if ($request->has('company_status')) {
            $company_status = 'catalog/Vendors/Status/' . $request->file('company_status')->getClientOriginalName();
            Storage::disk('ftp')->put($company_status, fopen($request->file('company_status'), 'r+'));
        }
        if ($request->has('company_tax')) {
            $company_tax = 'catalog/Vendors/Tax/' . $request->file('company_tax')->getClientOriginalName();
            Storage::disk('ftp')->put($company_tax, fopen($request->file('company_tax'), 'r+'));
        }
        if ($request->has('company_registration')) {
            $company_registration = 'catalog/Vendors/Registration/' . $request->file('company_registration')->getClientOriginalName();
            Storage::disk('ftp')->put($company_registration, fopen($request->file('company_registration'), 'r+'));
        }
        if ($request->has('logo')) {
            $logo = 'catalog/Vendors/Logo/' . $request->file('logo')->getClientOriginalName();
            Storage::disk('ftp')->put($logo, fopen($request->file('logo'), 'r+'));
        }
        if ($request->has('banner')) {
            $banner = 'catalog/Vendors/Banner/' . $request->file('banner')->getClientOriginalName();
            Storage::disk('ftp')->put($banner, fopen($request->file('banner'), 'r+'));
        }
        if ($request->has('blocked')) {
            $blocked=1;
            $status=0;
        }
        //Update in product
        $updateDetails = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->display_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'fax' => $request->fax,
            'type' => $request->type,
            'postcode'=>$request->postcode,
            'address_1'=>$request->address_1,
            'logo'=>$logo ?? $vendor->logo,
            'banner'=>$banner ?? $vendor->banner,
            'image' => $imageName ?? $vendor->image,
            'identity_picture1'=>$id_image_1 ?? $vendor->identity_picture1,
            'identity_picture2'=>$id_image_2 ??  $vendor->identity_picture2,
            'company_trade_register'=>$company_trade_register ?? $vendor->company_trade_register,
            'company_status'=>$company_status ??  $vendor->company_status,
            'company_tax'=>$company_tax ??  $vendor->company_tax,
            'company_registration'=>$company_registration ??  $vendor->company_registration,
            'city' => $request->city,
            'approved' => $request->status,
            'blocked' => $blocked ?? 0,
            'status'=> $request->status,
            'bank_name' => $request->bank_name,
            'bank_account_name'=>$request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'is_pre_order'=>$request->is_pre_order ?? 0,
            'supplier_email'=>$request->supplier_email ?? "",
         ];
        DB::table('oc_vendor')->where('vendor_id', "=","$id")->update($updateDetails);

        DB::table('oc_vendor_description')->where('vendor_id', '=', $id)->delete();

        DB::table('oc_vendor_description')->insert([
        ['vendor_id'=>$id,'language_id' => 1,'name' => $request->name_1 ?? '','description' => $request->description_1 ?? '','shipping_policy' => $request->shipping_policy_1 ?? '','return_policy' => $request->return_policy_1 ?? ''],
        ['vendor_id'=>$id,'language_id' => 4,'name' => $request->name_2,'description' => $request->description_2 ?? '','shipping_policy' => $request->shipping_policy_2 ?? '','return_policy' => $request->return_policy_2 ?? ''],
        ['vendor_id'=>$id,'language_id' => 2,'name' => $request->name_3 ?? '','description' => $request->description_3 ?? '','shipping_policy' => $request->shipping_policy_3 ?? '','return_policy' => $request->return_policy_3 ?? '']
        ]);

        $fullname=$request->firstname." ".$request->lastname;
        DB::table('depot')->where("vendor_id",$id)->update([
            'name'=>$request->name_1 ?? '',
            'vendor_id' => $id,
            'vendor_name' => $fullname ?? NULL,
            'address' => $request->address_1 ?? '',
            'volume' => 0,
        ]);

        return Redirect::to("admin/vendor")->with('success','The record has been updated successfully');
    }

    public function RulesUpdate($id){
        $rules=array(
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' => 'required|min:2',
            'birthday' => 'required|date',
            "email" => "required|email|unique:oc_vendor,email,$id,vendor_id",
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'logo'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'banner'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_picture1' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_picture2' =>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'telephone' => 'required|digits:10',
            'fax' => 'nullable|digits:10',
            'postcode'=>'nullable|numeric',
            'address_1'=>'nullable|min:2',
            'city' => 'nullable|min:2',
            'status'=>  'required',
            'bank_name' => 'required',
            'bank_account_name'=>'nullable|min:2',
            'bank_account_number' =>'nullable|min:2|numeric',
            'company_trade_register'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_status'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_tax'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_registration'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'supplier_email'=>"nullable|email",
        );
        return $rules;
    }

    public function RulesAdd(){
        $rules=array(
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' => 'required|min:2',
            'birthday' => 'required|date',
            'email' =>"required|email|unique:oc_vendor",
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'logo'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'banner'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_picture1' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_picture2' =>'required|mimes:jpeg,jpg,png,gif|max:10000',
            'telephone' => 'required|digits:10',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required|min:5',
            'fax' => '',
            'postcode'=>'required|numeric',
            'address_1'=>'required|min:2',
            'city' => 'required|min:2',
            'status'=>  'required',
            'bank_name' => 'nullable|min:2',
            'bank_account_name'=>'nullable|min:2',
            'bank_account_number' =>'nullable|min:2|numeric',
            'company_trade_register'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_status'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_tax'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'company_registration'=>'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'supplier_email'=>"nullable|email",
        );
        return $rules;
    }

    public function AttributeNames(){
        $attributeNames = array(
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'display_name' => 'user name',
            'birthday' => 'birthday',
            'email' =>"email",
            'image' => 'image',
            'identity_picture1' => 'identity card front',
            'identity_picture2' =>'identity card back',
            'telephone' => 'telephone',
            'password' => 'password',
            'password_confirmation' => 'password confirmation',
            'fax' => 'fax',
            'postcode'=>'post code',
            'address_1'=>'address',
            'city' => 'city',
            'status'=>  'status',
            'bank_name' => 'bank name',
            'bank_account_name'=>'bank account name',
            'bank_account_number' =>'bank account number',
        );
        return $attributeNames;
    }
}
