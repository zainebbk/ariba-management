<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class ZoneController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:zone-list', ['only' => ['Zone','OnChange','Search']]);
        $this->middleware('permission:city-list', ['only' => ['City']]);
    }

    public function Zone(Request $request)
    {
        //$products=Product::with('category')->where('product_id',139)->get();
        //dump($products[0]->category[0]->names[0]->name);
        $zones=DB::table('region')->leftJoin('province','region.region_id','province.region_id')->
        leftJoin('ville','province.province_id','ville.province_id')->leftJoin('quartier','ville.ville_id','quartier.ville_id')
        ->selectRaw("region.*,province.*,ville.ville,ville.code_postal as ville_code,quartier.quartier,quartier.code_postal as quartier_code")
        ->paginate('10');

        $regions=DB::table('region')->orderBy('region')->get();

        if ($request->ajax()) {
            return view('admin.mains-admin.zone.zone', compact('zones','regions'));
        }
        
        return view('admin.mains-admin.zone.zone-list', compact('zones','regions'));
    }

    public function City()
    {
        $cities=DB::table('region')->leftJoin('province','region.region_id','province.region_id')
        ->leftJoin('ville','province.province_id','ville.province_id')->leftJoin('quartier','ville.ville_id','quartier.ville_id')
        ->selectRaw("ville.ville,quartier.quartier,quartier.code_postal as quartier_code,ville.code_postal as ville_code")
        ->get();
   
        return view('admin.mains-admin.zone.city-list', compact('cities'));
    }

    public function OnChange(Request $request)
    {
        if ($request->has('region_id')) {
            $result = DB::table("province")->where("region_id","=","$request->region_id")->orderBy('province')->get();
        }
        if ($request->has('province_id')) {
            $result = DB::table("ville")->where("province_id","=","$request->province_id")->orderBy('ville')->get();
        }
        if ($request->has('ville_id')) {
            $result = DB::table("quartier")->where("ville_id","=","$request->ville_id")->orderBy('quartier')->get();
        }
       
        return response()->json(array("result"=>$result));
    }

    public function Search(Request $request)
    {
        $query='select region.*,province.*,ville.ville,ville.code_postal as ville_code,quartier.quartier,quartier.code_postal as quartier_code from `region` left join `province` on `region`.`region_id` = `province`.`region_id` left join `ville` on `province`.`province_id` = `ville`.`province_id` left join `quartier` on `ville`.`ville_id` = `quartier`.`ville_id` where 1';
        $zones=DB::table('region')->leftJoin('province','region.region_id','province.region_id')->
        leftJoin('ville','province.province_id','ville.province_id')->leftJoin('quartier','ville.ville_id','quartier.ville_id')
        ->selectRaw("region.*,province.*,ville.ville,ville.code_postal as ville_code,quartier.quartier,quartier.code_postal as quartier_code");
      
        if ($request->region_id!=0) {
            $zones->where('region.region_id','=',$request->region_id);
        }
        if ($request->province_id!=0) {
            $zones->where('province.province_id','=',$request->province_id);
        }
        if ($request->ville_id!=0) {
            $zones->where('ville.ville_id','=',$request->ville_id);
        }
        if ($request->quartier_id!=0) {
            $zones->where('quartier.quartier_id','=',$request->quartier_id);
        }
        $region_id1=$request->region_id;

        $zones=$zones->paginate(10)->appends(request()->query());
        $regions=DB::table('region')->get();

        if ($request->ajax()) {
            return view('admin.mains-admin.zone.zone', compact('zones','regions','region_id1'));
        }
        
        return view('admin.mains-admin.zone.zone-list', compact('zones','regions','region_id1'));
    }

}
