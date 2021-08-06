<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use PDF;
use Storage;
use Response;

class AccountController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function account()
    {
        $vendor=DB::table("oc_vendor")->where("vendor_id","=","$this->vendor")->first();
        $description_ar=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=2");
        $description_fr=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=4");
        $description_eng=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=1 LIMIT 1");
       // dd($description_eng[0]->description);
        $count_product=DB::select("SELECT count(*) as total FROM  oc_vendor_to_product where vendor_id=".$this->vendor."");
        $count_review=DB::select("SELECT count(*) as total FROM  oc_vendor_review where vendor_id=".$this->vendor."");

        return view('vendor.account.profil',['vendor'=>$vendor,'count_product'=>$count_product,
        'count_review'=>$count_review,'description_fr'=>$description_fr,'description_ar'=>$description_ar,'description_eng'=>$description_eng]);
    }
   
    public function showUpdateAccount()
    {
        $vendor=DB::table("oc_vendor")->where("vendor_id","=","$this->vendor")->first();
        $description_ar=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=2");
        $description_fr=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=4");
        $description_eng=DB::select("SELECT * From oc_vendor_description pd where pd.vendor_id=".$this->vendor." AND pd.language_id=1 LIMIT 1");

        return view('vendor.account.profil-update',['vendor'=>$vendor,'description_ar'=>$description_ar,'description_fr'=>$description_fr,'description_eng'=>$description_eng]);
    }

    public function updateAccount(Request  $request)
    {
        $id=$this->vendor;
         $vendor=DB::table('oc_vendor')->where("vendor_id",$id)->first();;
 
         $validator = Validator::make ( $request->all(),self::RulesUpdate($id));
         $validator->setAttributeNames(self::AttributeNames());
         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }
 
         if ($request->has('image')) {
             $imageName = 'catalog/Vendors/'.$this->vendor.'/Picture/' . $request->file('image')->getClientOriginalName();
             Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
         }
         if ($request->has('identity_picture1')) {
             $id_image_1 = 'catalog/Vendors/'.$this->vendor.'/ID' . $request->file('identity_picture1')->getClientOriginalName();
             Storage::disk('ftp')->put($id_image_1, fopen($request->file('identity_picture1'), 'r+'));
         }
         if ($request->has('identity_picture2')) {
             $id_image_2 = 'catalog/Vendors/'.$this->vendor.'/ID' . $request->file('identity_picture2')->getClientOriginalName();
             Storage::disk('ftp')->put($id_image_2, fopen($request->file('identity_picture2'), 'r+'));
         }
         if ($request->has('company_trade_register')) {
             $company_trade_register = 'catalog/Vendors/'.$this->vendor.'/Register/' . $request->file('company_trade_register')->getClientOriginalName();
             Storage::disk('ftp')->put($company_trade_register, fopen($request->file('company_trade_register'), 'r+'));
         }
         if ($request->has('company_status')) {
             $company_status = 'catalog/Vendors/'.$this->vendor.'/Status/' . $request->file('company_status')->getClientOriginalName();
             Storage::disk('ftp')->put($company_status, fopen($request->file('company_status'), 'r+'));
         }
         if ($request->has('company_tax')) {
             $company_tax = 'catalog/Vendors/'.$this->vendor.'/Tax/'.$request->file('company_tax')->getClientOriginalName();
             Storage::disk('ftp')->put($company_tax, fopen($request->file('company_tax'), 'r+'));
         }
         if ($request->has('company_registration')) {
             $company_registration = 'catalog/Vendors/'.$this->vendor.'/Registration/'. $request->file('company_registration')->getClientOriginalName();
             Storage::disk('ftp')->put($company_registration, fopen($request->file('company_registration'), 'r+'));
         }
         if ($request->has('logo')) {
             $logo = 'catalog/Vendors/'.$this->vendor.'/Logo/' . $request->file('logo')->getClientOriginalName();
             Storage::disk('ftp')->put($logo, fopen($request->file('logo'), 'r+'));
         }
         if ($request->has('banner')) {
             $banner = 'catalog/Vendors/'.$this->vendor.'/Banner/' . $request->file('banner')->getClientOriginalName();
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
             'bank_name' => $request->bank_name,
             'bank_account_name'=>$request->bank_account_name,
             'bank_account_number' => $request->bank_account_number,
             'is_pre_order'=>$request->is_pre_order ?? 0,
             'supplier_email'=>$request->supplier_email ?? "",

            'company' =>"",
            'company_president' => "",
            'company_address1'=>"",
            'company_city'=>"",
            'company_zip_code'=>"",
            'company_country' =>"",
            'company_email' =>"" ,
            'company_phone'=>"",
            'company_fax'=>"",
            'company_register_number' =>"" ,
            'company_register_city' =>"",
            'company_country'=>"",
            'company_position'=>"",
          ];

          $updateCompany = [
            'company' => $request->company,
            'company_president' => $request->company_president,
            'company_address1'=>$request->company_address1,
            'company_city'=>$request->company_city,
            'company_zip_code'=>$request->company_zip_code,
            'company_country' => $request->company_country,
            'company_email' => $request->company_email,
            'company_phone'=>$request->company_phone,
            'company_fax'=>$request->company_fax,
            'company_register_number' => $request->company_register_number,
            'company_register_city' => $request->company_register_city,
            'company_position'=>$request->company_position,
         ];

         DB::table('oc_vendor')->where('vendor_id', "=","$id")->update($updateDetails);
 
         if($request->type=='Company')
            DB::table('oc_vendor')->where('vendor_id', "=","$id")->update($updateCompany);

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
 
         return Redirect::to("vendor/account")->with('success','The record has been updated successfully');
     }
 
    public function RulesUpdate($id){
        $rules=array(
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'display_name' => "required|unique:oc_vendor,display_name,$id,vendor_id",
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
            'bank_name' => '',
            'bank_account_name'=>'nullable|min:2',
            'bank_account_number' =>'nullable|min:2|numeric',
            'company_trade_register'=>'nullable|mimes:jpeg,jpg,png,gif,pdf,word,excel|max:10000',
            'company_status'=>'nullable|mimes:jpeg,jpg,png,gif,pdf,word,excel|max:10000',
            'company_tax'=>'nullable|mimes:jpeg,jpg,png,gif,pdf,word,excel|max:10000',
            'company_registration'=>'nullable|mimes:jpeg,jpg,png,gif,pdf,word,excel|max:10000',
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
            'bank_name' => 'bank name',
            'bank_account_name'=>'bank account name',
            'bank_account_number' =>'bank account number',
        );
        return $attributeNames;
    }

}
