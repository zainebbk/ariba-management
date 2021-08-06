<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\CategoryDescription;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:category-list', ['only' => ['Category','ShowUpdateCategory']]);
         $this->middleware('permission:category-edit', ['only' => ['UpdateCategory']]);
         $this->middleware('permission:category-create', ['only' => ['ShowAddCategory','CategoryAdd']]);

    }
    public static function getParentsTree($category, $name)
    {
        if ($category->parent_id == 0)
        {
            return $name;
        }

        $parent = Category::find($category->parent_id);
        $name= $parent->names[0]->name . ' > ' . $name;

        return self::getParentsTree($parent, $name);
    }   

    public function Category()
    {
        $categories=Category::with(['names' => function ($query) {
            $query->where("oc_category_description.language_id","=",1)->orderBy("name");
        
        }])->get();

        return view('admin.mains-admin.category.category-list',['categories'=>$categories]);
    }
    
    public function ShowAddCategory()
    {
        $categories = DB::select("SELECT cp.category_id AS category_id,
        GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '   >  ') AS
        name, c1.parent_id, c1.sort_order FROM oc_category_path cp
        LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN oc_category c2 ON 
        (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id)
        LEFT JOIN oc_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '1'
        AND cd2.language_id = '1' GROUP BY cp.category_id,c1.parent_id,c1.sort_order ORDER BY name ASC;");

        return view('admin.mains-admin.category.category-add',['categories' => $categories]);
    }
    

    public function CategoryAdd(Request $request)
    {
         if ($request->has('image')) {
            $imageName = '/catalog/Category/' . $request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
        }

        $category = Category::create([
            'image' => $imageName ?? "",
            'parent_id' => $request->category,
            'status' =>  $request->status,
        ]);

        $category->names()->createMany([
            ['language_id' => '1','name'=> $request->name_eng,'meta_title'=>$request->name_eng],
            ['language_id' => '2','name'=> $request->name_ar,'meta_title'=>$request->name_ar],
            ['language_id' => '4','name'=> $request->name_fr,'meta_title'=>$request->name_fr]
        ]);

         DB::table('oc_category_to_store')->insert([
            ['category_id' => $category->category_id, 'store_id' => 0]
        ]);

        return Redirect::to("admin/category")->with('success', 'The record has been added successfully');
    }

    public function CategoryShow($id)
    {
        $category=Category::find($id);
        
        $categories = DB::select("SELECT cp.category_id AS category_id,
        GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '   >  ') AS
        name, c1.parent_id, c1.sort_order FROM oc_category_path cp
        LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN oc_category c2 ON 
        (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id)
        LEFT JOIN oc_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '1'
        AND cd2.language_id = '1' GROUP BY cp.category_id,c1.parent_id,c1.sort_order ORDER BY name ASC;");

        return view('admin.mains-admin.category.category-show',['category'=>$category,'categories'=>$categories]);
    }

    public function CategoryUpdate(Request $request,$id)
    {
        $category=Category::find($id);

        $updateDetails = [
            'parent_id' => $request->category,
            'status' => $request->status,
        ];

        if ($request->has('image')) {
            $imageName = '/catalog/Category/' . $request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
            Arr::add($updateDetails, 'image', $imageName);
        }

        $category->update($updateDetails);

        CategoryDescription::where('category_id', '=', $id)->delete();

        $category->names()->createMany([
            ['language_id' => '1','name'=> $request->name_eng,'meta_title'=>$request->name_eng],
            ['language_id' => '2','name'=> $request->name_ar,'meta_title'=>$request->name_ar],
            ['language_id' => '4','name'=> $request->name_fr,'meta_title'=>$request->name_fr]
        ]);

        return Redirect::to("admin/category")->with('success', 'The record has been added successfully');
    }
}
