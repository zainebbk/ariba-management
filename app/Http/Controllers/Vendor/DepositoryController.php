<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DepositoryController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function depository()
    {
        // $depositories = DB::table('depot', "d")
        //     ->leftJoin("oc_vendor_to_manufacturer", "m.manufacturer_id", 'oc_vendor_to_manufacturer.manufacturer_id')
        //     ->where("oc_vendor_to_manufacturer.vendor_id", $this->vendor)
        //     ->get();

            $depositories = DB::select("SELECT d.name, d.vendor_id, d.depot_id, d.date_added, d.volume
            FROM depot d
            left join oc_vendor ov ON (d.vendor_id = ov.vendor_id)
            where d.vendor_id=$this->vendor");

        return view('vendor.depository.depository-list', [
            'depositories' => $depositories,
        ]);
    }

    public function showAddDepository()
    {
        return view('vendor.depository.depository-add');
    }

    public function addDepository(Request $request)
    {
        // $validator = Validator::make($request->all(),['name'=>'required']);

        // if($request->ajax()){

        //     if ($validator->fails())
        //     {
        //         return response()->json([
        //             'errors' => $validator->getMessageBag()->toArray(),
        //             ],400
        //         );
        //     }

        //     $id = DB::table('oc_manufacturer')->insertGetId([
        //         'name' => $request->name,
        //     ]);

        //     $result= DB::table('oc_manufacturer')->where("manufacturer.manufacturer_id", $this->vendor)
        //     ->get();

        //     return response()->json(array("result"=>$result),200);
        // }


        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // $id = DB::table('oc_manufacturer')->insertGetId([
        //     'name' => $request->name,
        // ]);
        // DB::table('oc_vendor_to_manufacturer')->insert([
        //     ['vendor_id' => $this->vendor,'manufacturer_id' => $id]
        // ]);

        DB::insert(
            'insert into depot (depot_id,name,vendor_id,address,volume) values (?, ?, ?, ?,?)',
            [$request->depot_id,$request->name,$this->vendor, $request->address,$request->volume]

        );

        return Redirect::to(route('vendor-depository-list'))->with('success', 'The record has been added successfully');
    }

    public function showUpdateDepository($id)
    {
        $depository=DB::table("depot")->where("depot_id",'=',$id)->first();

        return view('vendor.depository.depository-show',['depository'=>$depository]);
    }

    public function updateDepository(Request $request,$id)
    {
        DB::table('depot')->where('depot_id',$id)->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'volume' => $request->input('address')
        ]);

        return Redirect::to(route('vendor-depository-list'))->with('success', 'The record has been updated successfully');
    }
}
