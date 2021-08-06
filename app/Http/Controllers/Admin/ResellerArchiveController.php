<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Product;

class ResellerArchiveController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:depot-list', ['only' => ['Depot','DepotShow']]);
         $this->middleware('permission:depot-edit', ['only' => ['DepotUpdate']]);
         $this->middleware('permission:depot-create', ['only' => ['ShowAddDepot','DepotAdd']]);

         $this->middleware('permission:archive-list', ['only' => ['ResellerArchive','ArchiveShow']]);
         $this->middleware('permission:archive-edit', ['only' => ['ArchiveUpdate']]);
         $this->middleware('permission:archive-create', ['only' => ['ShowAddArchive','ArchiveAdd']]);
    }

    public function Depot(){
        $depots=DB::table("depot")->get();

        return view('admin.mains-admin.reseller-archive.depot-list',['depots'=>$depots]);
    }

    public function ResellerArchive(){
        $archives=DB::table("depot_product_movement")->leftJoin("depot as from",
            "depot_product_movement.depot_from_id","from.depot_id")
        ->leftJoin("depot as to","depot_product_movement.depot_to_id","to.depot_id")->
        selectRaw("depot_product_movement.*,from.name as from_name,to.name as to_name")->get();

        return view('admin.mains-admin.reseller-archive.archive-list',['archives'=>$archives]);
    }

    public function ShowAddDepot(){
        $vendors = DB::table("oc_vendor")->get();

        return view('admin.mains-admin.reseller-archive.depot-add',['vendors'=>$vendors]);
    }

    public function DepotAdd(Request  $request){
        if($request->vendor_id!=0){
            $vendor=DB::table("oc_vendor")->where("vendor_id",$request->vendor_id)->first();
            $fullname=$vendor->firstname." ".$vendor->lastname;
            $vendor_id=$vendor->vendor_id;
        }

        DB::table('depot')->insert([
            'name'=>$request->name ?? '',
            'vendor_id' => $vendor_id ?? NULL,
            'vendor_name' => $fullname ?? NULL,
            'address' => $request->address ?? '',
            'volume' => $request->volume ?? 0,
        ]);

        return Redirect::to("admin/depot")->with('success','The record has been added successfully');
    }

    public function ShowAddArchive(){
        $depots=DB::table("depot")->get();
        $products=Product::with(['names' => function ($query) {
            $query->where("oc_product_description.language_id","=",'1')->orderBy("name","desc");
        }])->get();

        return view('admin.mains-admin.reseller-archive.archive-add',['depots'=>$depots, 'products'=>$products]);
    }

    public function ArchiveAdd(Request  $request){
        $product=Product::with("names")->where('product_id',$request->product_id)->first();

        if($request->is_carton==1) $request->quantity=0;
        $id = DB::table('depot_product_movement')->insertGetId([
            'depot_from_id'=>$request->depot_from_id,
            'depot_to_id'=>$request->depot_to_id,
            'product_id' => $request->product_id ,
            'product_name' => $product->names['0']->name,
            'is_carton' => $request->is_carton ?? '',
            'quantity' => $request->quantity,
        ]);

        if($request->is_carton==0){
            DB::table('depot_product_option')->insert([
                ['depot_product_movement_id' => $id, 'option_value' => 35, 'quantity' => $request->quantity_35 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 36, 'quantity' => $request->quantity_36 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 37, 'quantity' => $request->quantity_37 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 38, 'quantity' => $request->quantity_38 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 39, 'quantity' => $request->quantity_39 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 40, 'quantity' => $request->quantity_40 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 41, 'quantity' => $request->quantity_41 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 42, 'quantity' => $request->quantity_42 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 43, 'quantity' => $request->quantity_43 ?? 0],
                ['depot_product_movement_id' => $id, 'option_value' => 44, 'quantity' => $request->quantity_44 ?? 0],
            ]);
        }
        return Redirect::to("admin/reseller-archive")->with('success','The record has been added successfully');
    }

    public function DepotShow($id){
        $depot=DB::table("depot")->where("depot_id",$id)->first();
        if(!$depot) return abort(404);
        $vendors = DB::table("oc_vendor")->get();

        return view('admin.mains-admin.reseller-archive.depot-show',['vendors'=>$vendors,'depot'=>$depot]);
    }

    public function DepotUpdate (Request $request,$id){
        $depot=DB::table("depot")->where("depot_id",$id)->first();
        if(!$depot) return abort(404);

        if($request->vendor_id!=0){
            $vendor=DB::table("oc_vendor")->where("vendor_id",$request->vendor_id)->first();
            $fullname=$vendor->firstname." ".$vendor->lastname;
            $vendor_id=$vendor->vendor_id;
        }

        DB::table('depot')->where("depot_id",$id)->update([
            'name'=>$request->name ?? '',
            'vendor_id' => $vendor_id ?? NULL,
            'vendor_name' => $fullname ?? NULL,
            'address' => $request->address ?? '',
            'volume' => $request->volume ?? 0,
        ]);

        return Redirect::to("admin/depot")->with('success','The record has been updated successfully');
    }

    public function ArchiveShow($id){
        $archive=DB::table("depot_product_movement")->where("depot_product_movement_id",$id)->first();
        if(!$archive) return abort(404);

        $depots=DB::table("depot")->get();
        $products=Product::with(['names' => function ($query) {
            $query->where("oc_product_description.language_id","=",'1')->orderBy("name","desc");
        }])->get();

        $options=DB::table("depot_product_option")->where("depot_product_movement_id",$id)->get();

        return view('admin.mains-admin.reseller-archive.archive-show',['depots'=>$depots, 'products'=>$products,
            'options'=>$options,'archive'=>$archive]);
    }

    public function ArchiveUpdate(Request  $request,$id){
        $product=Product::with("names")->where('product_id',$request->product_id)->first();

        DB::table('depot_product_movement')->where("depot_product_movement_id",$id)->update([
            'depot_from_id'=>$request->depot_from_id,
            'depot_to_id'=>$request->depot_to_id,
            'product_id' => $request->product_id ,
            'product_name' => $product->names['0']->name,
            'is_carton' => $request->is_carton ?? '',
            'quantity' => $request->quantity ?? null,
        ]);

        DB::table('depot_product_option')->where('depot_product_movement_id', '=', $id)->delete();
        DB::table('depot_product_option')->insert([
            ['depot_product_movement_id' => $id, 'option_value' => 35, 'quantity' => $request->quantity_35 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 36, 'quantity' => $request->quantity_36 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 37, 'quantity' => $request->quantity_37 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 38, 'quantity' => $request->quantity_38 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 39, 'quantity' => $request->quantity_39 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 40, 'quantity' => $request->quantity_40 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 41, 'quantity' => $request->quantity_41 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 42, 'quantity' => $request->quantity_42 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 43, 'quantity' => $request->quantity_43 ?? 0],
            ['depot_product_movement_id' => $id, 'option_value' => 44, 'quantity' => $request->quantity_44 ?? 0],
        ]);

        return Redirect::to("admin/reseller-archive")->with('success','The record has been updated successfully');
    }


}
