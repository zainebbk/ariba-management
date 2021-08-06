<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ManufacturerController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function manufacturer()
    {
        $manufacturers = DB::table('oc_manufacturer', "m")
            ->leftJoin("oc_vendor_to_manufacturer", "m.manufacturer_id", 'oc_vendor_to_manufacturer.manufacturer_id')
            ->where("oc_vendor_to_manufacturer.vendor_id", $this->vendor)
            ->get();

        return view('vendor.manufacturer.manufacturer-list', [
            'manufacturers' => $manufacturers,
        ]);
    }

    public function showAddManufacturer()
    {
        return view('vendor.manufacturer.manufacturer-add');
    }

    public function addManufacturer(Request $request)
    {
        $validator = Validator::make($request->all(),['name'=>'required']);

        if($request->ajax()){
           
            if ($validator->fails())
            {
                return response()->json([
                    'errors' => $validator->getMessageBag()->toArray(),
                    ],400
                ); 
            }

            $id = DB::table('oc_manufacturer')->insertGetId([
                'name' => $request->name,
            ]);

            $result= DB::table('oc_manufacturer')->where("manufacturer.manufacturer_id", $this->vendor)
            ->get();

            return response()->json(array("result"=>$result),200);
        }


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = DB::table('oc_manufacturer')->insertGetId([
            'name' => $request->name,
        ]);
        DB::table('oc_vendor_to_manufacturer')->insert([
            ['vendor_id' => $this->vendor,'manufacturer_id' => $id]
        ]);

        return Redirect::to(route('vendor-manufacturer-list'))->with('success', 'The record has been added successfully');
    }

    public function showUpdateManufacturer($id)
    {
        $manufacturer=DB::table("oc_manufacturer")->where("manufacturer_id",'=',$id)->first();

        return view('vendor.manufacturer.manufacturer-show',['manufacturer'=>$manufacturer]);
    }

    public function updateManufacturer(Request $request,$id)
    {
        $validator = Validator::make($request->all(),['name'=>'required']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('oc_manufacturer')->where("manufacturer_id","$id")->update([
            'name' => $request->name,
        ]);
        return Redirect::to(route('vendor-manufacturer-list'))->with('success', 'The record has been updated successfully');
    }
}
