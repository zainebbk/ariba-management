<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    protected $vendor = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->vendor=auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function category()
    {
        $categories = DB::table('vendor_category_suggest', "v")
        ->where("v.vendor_id", $this->vendor)
        ->get();

        return view('vendor.category.category-list',['categories' => $categories]);
    }

    public function showAddCategory()
    {
        return view('vendor.category.category-add');
    }

    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(),['name'=>'required','description'=>'required']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('vendor_category_suggest')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'vendor_id' => $this->vendor,
        ]);

        return Redirect::to(route('vendor-category-list'))->with('success', 'The record has been added successfully');
    }

    public function showUpdateCategory($id)
    {
        $category=DB::table("vendor_category_suggest")->where("category_suggest_id",'=',$id)->first();

        return view('vendor.category.category-show',['category'=>$category]);
    }

    public function updateCategory(Request $request,$id)
    {
        $validator = Validator::make($request->all(),['name'=>'required','description'=>'required']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('vendor_category_suggest')->where("category_suggest_id","$id")->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return Redirect::to(route('vendor-category-list'))->with('success', 'The record has been updated successfully');
    }
}
