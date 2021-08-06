<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;

class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list', ['only' => ['Product','ProductNotVerified','ProductVerified','ShowUpdateProduct']]);
         $this->middleware('permission:product-edit', ['only' => ['UpdateProduct']]);
         $this->middleware('permission:product-create', ['only' => ['ShowAddproduct','Addproduct']]);
         $this->middleware('permission:product-check', ['only' => ['ProductCheck']]);
    }

    public function Product()
    {
        $products = DB::select("SELECT  p.ean,p.model,p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,
        p.status,p.price,p.date_added,pd.name ,m.name as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4' ORDER BY p.date_added DESC ");

        return view('admin.mains-admin.product.product-list')->with("data", ['products' => $products]);
    }

    public function ProductNotVerified()
    {
        $products = DB::select("SELECT  p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,p.status,p.price,p.date_added,pd.name ,m.name
        as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4' AND p.status=0 ORDER BY p.date_added DESC ");

        return view('admin.mains-admin.product.product-list-pending')->with("data", ['products' => $products]);
    }

    public function ProductVerified()
    {
        $products = DB::select("SELECT  p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,p.status,p.price,p.date_added,pd.name ,m.name
        as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4' AND p.status=1");

        return view('admin.mains-admin.product.product-list-verified')->with("data", ['products' => $products]);
    }

    public function ProductCheck()
    {
        $products = DB::select("SELECT p.`product_id`, p.date_added,p.image, fr.`name` AS name_fr
        , ar.`name` AS name_ar, eng.`name` AS name_eng FROM oc_product AS p
        LEFT JOIN oc_product_description AS fr ON p.`product_id` = fr.`product_id`
            AND fr.`language_id` = '4'
        LEFT JOIN oc_product_description AS ar ON p.`product_id` = ar.`product_id`
            AND ar.`language_id` = '2'
        LEFT JOIN oc_product_description AS eng ON p.`product_id` = eng.`product_id`
            AND eng.`language_id` = '1'

        group by p.`product_id`,p.date_added,p.image,name_fr,name_eng,name_ar  order by date_added desc");

        return view('admin.mains-admin.product.product-list-check')->with("data", ['products' => $products]);
    }

    public function ShowAddproduct()
    {
        $manufacturers = DB::select("SELECT * FROM oc_manufacturer");
        $vendors = DB::select("SELECT * FROM oc_vendor");
        $categories = DB::select("SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ')
         AS name, c1.parent_id, c1.sort_order FROM oc_category_path cp LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id)
         LEFT JOIN oc_category c2 ON (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id)
         LEFT JOIN oc_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '1' AND cd2.language_id = '1'
        and c1.status=1 and c2.status=1 GROUP BY cp.category_id,c1.parent_id,c1.sort_order ORDER BY name ASC;");

        $filters = DB::select("SELECT f.filter_id, CONCAT(fgd.name, ' > ', fd.name) as name  FROM oc_filter_group_description fgd ,
         oc_filter f LEFT JOIN oc_filter_description fd ON (f.filter_id = fd.filter_id) WHERE
         f.filter_group_id = fgd.filter_group_id AND fgd.language_id =1 and fd.language_id =1 ORDER BY f.sort_order ASC;");

        $count = DB::table("oc_product_option_value")->max("ciopean");
        $ean = array();
        for ($i = 0; $i < 11; $i++) {
            $count++;
            $ean[$i] = '2' . str_pad(substr($count, 1), 7, '0', STR_PAD_LEFT);
        }

        return view('admin.mains-admin.product.product-add')->with("data", [
            'manufacturers' => $manufacturers,
            'categories' => $categories, 'vendors' => $vendors, 'filters' => $filters, 'ean' => $ean
        ]);
    }

    public function Addproduct(Request $request)
    {
        ini_set('max_execution_time', 300);

        //INPUT VALIDATION
        $validator = Validator::make($request->all(), self::RulesAdd());
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //STORE MAIN IMAGE
        if ($request->has('image')) {
            $imageName = '/catalog/Products/' . $request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
        }
        $images = array(
            'image1',
            'image2',
            'image3',
            'image4',
            'image5',
            'image6',
        );

        //Store in product
        $id = DB::table('oc_product')->insertGetId([
            'model' => $request->model ?? '',
            'sku' => $request->sku ?? "",
            'upc' => $request->gtn ?? '',
            'ean' => $request->gtn ?? '',
            'jan' => $request->gtn ?? '',
            'isbn' => $request->gtn ?? '',
            'mpn' => '',
            'location' => '',
            'quantity' => $request->quantity ?? 0,
            'set_number' => $request->set_number ?? 0,
            'stock_status_id' => 6,
            'image' => $imageName ?? "none",
            'date_available' => $request->date_available ?? now(),
            'manufacturer_id' => $request->manufacturer_id,
            'status' => $request->status,
            'price' => floatval($request->price)-floatval($request->price*0.2) ?? 0,
            'height' => $request->height ?? 0,
            'length' => $request->length ?? 0,
            'width' => $request->width ?? 0,
            'tax_class_id' => 9,
            'subtract' => 1,
            'sort_order' => $request->sort_order ?? 0,
            'date_added' => date('Y-m-d H:i:s'),
            'date_modified' => date('Y-m-d H:i:s')
        ]);

        //STORE IMAGE IN FTP AND DATABASE
        foreach ($images as $image) {
            if ($request->has($image)) {
                $imageName = '/catalog/Products/' . $request->file($image)->getClientOriginalName();
                Storage::disk('ftp')->put($imageName, fopen($request->file($image), 'r+'));
                DB::table('oc_product_image')->insert([
                    ['product_id' => $id, 'image' => $imageName]
                ]);
            }
        }
        //Store description
        DB::table('oc_product_description')->insert([
            ['name' => $request->name_1 ?? '', 'description' => $request->description_1 ?? '', 'meta_title' => $request->name_1 ?? '', 'language_id' => 1, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $request->name_2 ?? '', 'description' => $request->description_2 ?? '', 'meta_title' => $request->name_2 ?? '', 'language_id' => 4, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $request->name_3 ?? '', 'description' => $request->description_3 ?? '', 'meta_title' => $request->name_3 ?? '', 'language_id' => 2, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => '']
        ]);

        //Store categories
        foreach ($request->categories as $category) {
            DB::table('oc_product_to_category')->insert([
                ['product_id' => $id, 'category_id' => $category]
            ]);
        }
        //Store filters
        foreach ($request->filters as $filter) {
            DB::table('oc_product_filter')->insert([
                ['product_id' => $id, 'filter_id' => $filter]
            ]);
        }

        //Store product to vendor
        DB::table('oc_vendor_to_product')->insert([
            'vendor_id' => 1, 'product_id' => $id
        ]);

        //IF SELECT OPTION=SHOES SIZE
        if ($request->option == 13) {
            //Store product options
            $id_product_option = DB::table("oc_product_option")->insertGetId([
                'product_id' => $id,
                'option_id' => 13,
                'value' => '',
                'required' => 1,
            ]);

            //Store product option values
            self::SaveOptionValues($id_product_option, $id, 49, $request->quantity_35, $request->set_35, $request->price_35, $request->ean_35);
            self::SaveOptionValues($id_product_option, $id, 50, $request->quantity_36, $request->set_36, $request->price_36, $request->ean_36);
            self::SaveOptionValues($id_product_option, $id, 51, $request->quantity_37, $request->set_37, $request->price_37, $request->ean_37);
            self::SaveOptionValues($id_product_option, $id, 52, $request->quantity_38, $request->set_38, $request->price_38, $request->ean_38);
            self::SaveOptionValues($id_product_option, $id, 53, $request->quantity_39, $request->set_39, $request->price_39, $request->ean_39);
            self::SaveOptionValues($id_product_option, $id, 54, $request->quantity_40, $request->set_40, $request->price_40, $request->ean_40);
            self::SaveOptionValues($id_product_option, $id, 55, $request->quantity_41, $request->set_41, $request->price_41, $request->ean_41);
            self::SaveOptionValues($id_product_option, $id, 56, $request->quantity_42, $request->set_42, $request->price_42, $request->ean_42);
            self::SaveOptionValues($id_product_option, $id, 57, $request->quantity_43, $request->set_43, $request->price_43, $request->ean_43);
            self::SaveOptionValues($id_product_option, $id, 61, $request->quantity_44, $request->set_44, $request->price_44, $request->ean_44);
            self::SaveOptionValues($id_product_option, $id, 62, $request->quantity_45, $request->set_45, $request->price_45, $request->ean_45);
        }
        //IF SELECT OPTION=SIZE
        else {
            //Store product options
            $id_product_option = DB::table("oc_product_option")->insertGetId([
                'product_id' => $id,
                'option_id' => 11,
                'value' => '',
                'required' => 1,
            ]);

            //Store product option values
            self::SaveOptionValues($id_product_option, $id, 58, $request->quantity_xs, $request->set_xs, $request->price_xs, $request->ean_xs);
            self::SaveOptionValues($id_product_option, $id, 46, $request->quantity_x, $request->set_x, $request->price_x, $request->ean_x);
            self::SaveOptionValues($id_product_option, $id, 47, $request->quantity_m, $request->set_m, $request->price_m, $request->ean_m);
            self::SaveOptionValues($id_product_option, $id, 48, $request->quantity_l, $request->set_l, $request->price_l, $request->ean_l);
            self::SaveOptionValues($id_product_option, $id, 59, $request->quantity_xl, $request->set_xl, $request->price_xl, $request->ean_xl);
            self::SaveOptionValues($id_product_option, $id, 60, $request->quantity_xxl, $request->set_xxl, $request->price_xxl, $request->ean_xxl);

        }
        //Save to store
        DB::table('oc_product_to_store')->insert([
            ['product_id' => $id, 'store_id' => 0]
        ]);

        return back()->with("success", "The record has been added successfully");
    }

    public static function SaveOptionValues($id_product_option, $id, $value, $quantity, $set, $price, $ean)
    {
        DB::table("oc_product_option_value")->insert([
            'product_option_id' => $id_product_option,
            'product_id' => $id,
            'option_id' => 13,
            'option_value_id' => $value,
            'quantity' => $quantity ?? 0,
            'set_number' => $set ?? 0,
            'price' => $price ?? 0,
            'ciopean' => $ean ?? '',
        ]);
    }

    public function ShowUpdateProduct($id)
    {
        $product = DB::select("SELECT * FROM oc_product p
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where p.product_id=" . $id . " ORDER BY p.date_added DESC ");

        $description_ar = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=2");
        $description_fr = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=4");
        $description_eng = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=1");

        $manufacturers = DB::select("SELECT * FROM oc_manufacturer");
        $vendors = DB::select("SELECT * FROM oc_vendor"); 

        $categories = DB::select("SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name,
         c1.parent_id, c1.sort_order FROM oc_category_path cp LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN oc_category c2 ON
         (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN oc_category_description cd2 ON
         (cp.category_id = cd2.category_id) WHERE cd1.language_id = '4' AND cd2.language_id = '1' and c1.status=1 and c2.status=1 GROUP BY cp.category_id,c1.parent_id,c1.sort_order
         ORDER BY name ASC;");

        $status = DB::table("oc_product")->where("product_id", "=", "$id")->get("status")->first();

        $image = DB::table("oc_product")->where("product_id", "=", "$id")->get("image")->first();
        $images = DB::table("oc_product_image")->where("product_id", "=", "$id")->get();
        $new_cat= 0;
        $productCategories = DB::table("oc_product_to_category")->where("product_id", "=", "$id")->get("category_id");
       
        if($product[0]->new_category!=null){
            $new_cat= 1;
        }
            
        $filters = DB::select("SELECT f.filter_id, CONCAT(fgd.name, ' > ', fd.name) as name  FROM oc_filter_group_description fgd ,
        oc_filter f LEFT JOIN oc_filter_description fd ON (f.filter_id = fd.filter_id) WHERE
        f.filter_group_id = fgd.filter_group_id AND fgd.language_id =1 and fd.language_id =1 ORDER BY f.sort_order ASC;");

        $productFilters = DB::table("oc_product_filter")->where("product_id", "=", "$id")->get("filter_id");
        $option_id = DB::table('oc_product_option')->where('product_id', $id)->first()->option_id;
        $options = DB::table('oc_product_option_value')->where(["product_id" => $id, "option_id" => $option_id])
        ->orderby("option_value_id")->get();

        return view('admin.mains-admin.product.product-show')->with('data', [
            'product' => $product, 'status' => $status, 'image' => $image, 'manufacturers' => $manufacturers,
            'categories' => $categories, 'vendors' => $vendors, 'description_ar' => $description_ar,
            'description_fr' => $description_fr, 'description_eng' => $description_eng,
            'productCategories' => $productCategories, 'images' => $images, 'filters' => $filters,
            'productFilters' => $productFilters, 'options' => $options, 'option_id' => $option_id,
            'new_category' => $new_cat
        ]);
    }

    public function UpdateProduct(Request $request, $id)
    {
        ini_set('max_execution_time', 300);
        $product=DB::table('oc_product')->where('product_id','=',$id)->first();

        //INPUT VALIDATION
        $validator = Validator::make($request->all(), self::RulesUpdate($id));
        $validator->setAttributeNames(self::AttributeNames());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('image')) {
            $imageName = '/catalog/Products/' . $request->file('image')->getClientOriginalName();
            Storage::disk('ftp')->put($imageName, fopen($request->file('image'), 'r+'));
        }

        $images = DB::table("oc_product_image")->where("product_id", "=", "$id")->get();

        //Update IMAGE DATABASE
        foreach ($images as $image){
            if ($request->has($image->product_image_id)) {
                $imageName = '/catalog/ProductsTest/' . $request->file($image->product_image_id)->getClientOriginalName();
                Storage::disk('ftp')->put($imageName, fopen($request->file($image->product_image_id), 'r+'));
                DB::table('oc_product_image')->where('product_image_id',$image->product_image_id)->update(
                    ['image' => $imageName]
                );
            }
        }

        //STORE NEW IMAGE IN FTP AND DATABASE
        if($request->has('images')){
            foreach ($request->file('images') as $image)
            {
                $imageName = '/catalog/ProductsTest/'.$image->getClientOriginalName();
                Storage::disk('ftp')->put($imageName, fopen($image, 'r+'));
                DB::table('oc_product_image')->insert([
                    ['product_id' => $id, 'image'=>$imageName]
                ]);
            }
        }

        $updateDetails = [
            'model' => $request->model ?? '',
            'sku' => $request->sku ?? '',
            'upc' => $request->gtn ?? '',
            'ean' => $request->gtn ?? '',
            'jan' => $request->gtn ?? '',
            'isbn' => $request->gtn ?? '',
            'image' => $imageName ?? $product->image,
            'quantity' => $request->quantity ?? 0,
            'set_number' => $request->set_number ?? 0,
            'date_available' => $request->date_available ?? now(),
            'manufacturer_id' => $request->manufacturer_id,
            'status' => $request->status,
            'price' => floatval($request->price)-floatval($request->price*0.2) ?? 0,
            'height' => $request->height ?? 0,
            'width' => $request->width ?? 0,
            'length' => $request->length ?? 0,
            'sort_order' => $request->sort_order ?? 0,
            'date_modified' => date('Y-m-d H:i:s')
        ];

        DB::table('oc_product')->where('product_id', "=", "$id")->update($updateDetails);

        //Store description
        DB::table('oc_product_description')->where('product_id', '=', $id)->delete();
        DB::table('oc_product_description')->insert([
            ['name' => $request->name_1 ?? '', 'description' => $request->description_1 ?? '', 'meta_title' => $request->name_1 ?? '', 'language_id' => 1, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $request->name_2, 'description' => $request->description_2, 'meta_title' => $request->name_2, 'language_id' => 4, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $request->name_3, 'description' => $request->description_3, 'meta_title' => $request->name_3, 'language_id' => 2, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => '']
        ]);

        //Store categories
        DB::table('oc_product_to_category')->where('product_id', '=', $id)->delete();
        foreach ($request->categories as $category) {
            DB::table('oc_product_to_category')->insert([
                ['product_id' => $id, 'category_id' => $category]
            ]);
        }
        //Store filters
        DB::table('oc_product_filter')->where('product_id', '=', $id)->delete();
        foreach ($request->filters as $filter) {
            DB::table('oc_product_filter')->insert([
                ['product_id' => $id, 'filter_id' => $filter]
            ]);
        }

        //Store product to vendor
        DB::table('oc_vendor_to_product')->where('product_id', '=', $id)->delete();
        DB::table('oc_vendor_to_product')->insert([
            'vendor_id' => 1, 'product_id' => $id
        ]);

        //IF SELECT OPTION=SHOES SIZE
        if ($request->option == 13) {
            //Store product options
            DB::table('oc_product_option')->where('product_id', '=', $id)->delete();
            $id_product_option = DB::table("oc_product_option")->insertGetId([
                'product_id' => $id,
                'option_id' => 13,
                'value' => '',
                'required' => 1,
            ]);

            //Store product option values
            DB::table('oc_product_option_value')->where('product_id', '=', $id)->delete();
            self::SaveOptionValues($id_product_option, $id, 49, $request->quantity_35, $request->set_35, $request->price_35, $request->ean_35);
            self::SaveOptionValues($id_product_option, $id, 50, $request->quantity_36, $request->set_36, $request->price_36, $request->ean_36);
            self::SaveOptionValues($id_product_option, $id, 51, $request->quantity_37, $request->set_37, $request->price_37, $request->ean_37);
            self::SaveOptionValues($id_product_option, $id, 52, $request->quantity_38, $request->set_38, $request->price_38, $request->ean_38);
            self::SaveOptionValues($id_product_option, $id, 53, $request->quantity_39, $request->set_39, $request->price_39, $request->ean_39);
            self::SaveOptionValues($id_product_option, $id, 54, $request->quantity_40, $request->set_40, $request->price_40, $request->ean_40);
            self::SaveOptionValues($id_product_option, $id, 55, $request->quantity_41, $request->set_41, $request->price_41, $request->ean_41);
            self::SaveOptionValues($id_product_option, $id, 56, $request->quantity_42, $request->set_42, $request->price_42, $request->ean_42);
            self::SaveOptionValues($id_product_option, $id, 57, $request->quantity_43, $request->set_43, $request->price_43, $request->ean_43);
            self::SaveOptionValues($id_product_option, $id, 61, $request->quantity_44, $request->set_44, $request->price_44, $request->ean_44);
            self::SaveOptionValues($id_product_option, $id, 62, $request->quantity_45, $request->set_45, $request->price_45, $request->ean_45);
        }
        //IF SELECT OPTION=SIZE
        else {
            //Store product options
            DB::table('oc_product_option')->where('product_id', '=', $id)->delete();
            $id_product_option = DB::table("oc_product_option")->insertGetId([
                'product_id' => $id,
                'option_id' => 11,
                'value' => '',
                'required' => 1,
            ]);

            //Store product option values
            DB::table('oc_product_option_value')->where('product_id', '=', $id)->delete();
            self::SaveOptionValues($id_product_option, $id, 58, $request->quantity_xs, $request->set_xs, $request->price_xs, $request->ean_xs);
            self::SaveOptionValues($id_product_option, $id, 46, $request->quantity_x, $request->set_x, $request->price_x, $request->ean_x);
            self::SaveOptionValues($id_product_option, $id, 47, $request->quantity_m, $request->set_m, $request->price_m, $request->ean_m);
            self::SaveOptionValues($id_product_option, $id, 48, $request->quantity_l, $request->set_l, $request->price_l, $request->ean_l);
            self::SaveOptionValues($id_product_option, $id, 59, $request->quantity_xl, $request->set_xl, $request->price_xl, $request->ean_xl);
            self::SaveOptionValues($id_product_option, $id, 60, $request->quantity_xxl, $request->set_xxl, $request->price_xxl, $request->ean_xxl);
        }

        return back()->with("success", "The record has been updated successfully");
    }

    public function optimize(){
        $exitCode = Artisan::call('config:clear');
    }

    public function ShowVerifyProduct($id)
    {
        $product = DB::select("SELECT * FROM oc_product p
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where p.product_id=" . $id . " ORDER BY p.date_added DESC ");

        $description_ar = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=2");
        $description_fr = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=4");
        $description_eng = DB::select("SELECT * From oc_product_description pd where pd.product_id=" . $id . " AND pd.language_id=1");

        $manufacturers = DB::select("SELECT * FROM oc_manufacturer");
        $vendors = DB::select("SELECT * FROM oc_vendor");

        $categories = DB::select("SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name, c1.parent_id, c1.sort_order FROM oc_category_path cp LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN oc_category c2 ON (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN oc_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '4' AND cd2.language_id = '1' GROUP BY cp.category_id,c1.parent_id,c1.sort_order ORDER BY sort_order ASC;");
        $status = DB::table("oc_product")->where("product_id", "=", "$id")->get("status")->first();

        $image = DB::table("oc_product")->where("product_id", "=", "$id")->get("image")->first();
        $images = DB::table("oc_product_image")->where("product_id", "=", "$id")->get();
        $productCategories = DB::table("oc_product_to_category")->where("product_id", "=", "$id")->get("category_id");
        $filters = DB::select("SELECT f.filter_id, CONCAT(fgd.name, ' > ', fd.name) as name  FROM oc_filter_group_description fgd ,
        oc_filter f LEFT JOIN oc_filter_description fd ON (f.filter_id = fd.filter_id) WHERE
        f.filter_group_id = fgd.filter_group_id AND fgd.language_id =1 and fd.language_id =1 ORDER BY f.sort_order ASC;");

        $productFilters = DB::table("oc_product_filter")->where("product_id", "=", "$id")->get("filter_id");
        $option_id = DB::table('oc_product_option')->where('product_id', $id)->first()->option_id;
        $options = DB::table('oc_product_option_value')->where(["product_id" => $id, "option_id" => $option_id])->get();

        return view('admin.mains-admin.product.product-verify')->with('data', [
            'product' => $product, 'status' => $status, 'image' => $image, 'manufacturers' => $manufacturers,
            'categories' => $categories, 'vendors' => $vendors, 'description_ar' => $description_ar,
            'description_fr' => $description_fr, 'description_eng' => $description_eng,
            'productCategories' => $productCategories, 'images' => $images, 'filters' => $filters,
            'productFilters' => $productFilters, 'options' => $options, 'option_id' => $option_id
        ]);
    }

    public function VerifyProduct($id,Request $request)
    {
        $id_master=$request->id_master;
        $master_product=DB::connection("mysql2")->table("master_product")->where("product_id",$id_master)->get();

        $updateDetails = [
            'model' => $master_product[0]->model ?? '',
            'sku' => $master_product[0]->sku ?? '',
            'upc' => $master_product[0]->gtn ?? '',
            'ean' => $master_product[0]->gtn ?? '',
            'jan' => $master_product[0]->gtn ?? '',
            'isbn' => $master_product[0]->gtn ?? '',
            'image' => $master_product[0]->image,
            'height' => $master_product[0]->height ?? 0,
            'width' => $master_product[0]->width ?? 0,
            'length' => $master_product[0]->length ?? 0,
        ];

        DB::table('oc_product')->where('product_id', "=", "$id")->update($updateDetails);
        //images
        DB::table('oc_product_image')->where("product_id",$id)->delete();

        $master_images=DB::connection("mysql2")->table("master_product_image")->where("product_id",$id_master)->get();
        foreach($master_images as $image){
            DB::table('oc_product_image')->insert([
                ['product_id' => $id, 'image'=> $image->image]
            ]);
        }

        //Description
        $description_ar = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $id_master . " AND pd.language_id=2");

        $description_fr = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $id_master . " AND pd.language_id=4");

        $description_eng = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $id_master . " AND pd.language_id=1");


        DB::table('oc_product_description')->where('product_id', '=', $id)->delete();
        DB::table('oc_product_description')->insert([
            ['name' => $description_ar[0]->name ?? '', 'description' => $description_ar[0]->description ?? '', 'meta_title' => $description_ar[0]->name ?? '', 'language_id' => 2, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $description_fr[0]->name ?? '', 'description' => $description_fr[0]->description, 'meta_title' => $description_fr[0]->name, 'language_id' => 4, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => ''],
            ['name' => $description_eng[0]->name ?? '', 'description' => $description_eng[0]->description, 'meta_title' => $description_eng[0]->name, 'language_id' => 1, 'product_id' => $id, 'tag' => '', 'meta_description' => '', "meta_keyword" => '']
        ]);

        //Link
        DB::connection("mysql2")->table('master_product_to_store')->insert(
            ['master_product_id' => $id_master ?? '', 'product_id' => $id ?? '', 'store_id' => 1, 'vendor_id' => 1],
        );

        //Category

        //Filters


    }

    public function GetProduct(Request $request)
    {
        $search = $request->search;
        $products = DB::select("SELECT DISTINCT pd.name as 'name',pd.product_id as 'id' FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) where pd.language_id='4' and pd.name Like '%' .$search . '%'  Order by pd.name");
        $response = array();
        foreach ($products as $product) {
            $response[] = array("value" => $product->id_product, "label" => $product->title_p);
        }

        return response()->json($response);
    }

    public function Search(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::connection("mysql2")->select("SELECT DISTINCT  p.product_id, image,name,description From master_product p, master_product_description pd where p.product_id=pd.product_id and (pd.name like '%" . $request->search . "%' OR pd.description like '%" . $request->search . "%') AND language_id=1");
            $output = '';

            if (count($data) > 0) {

                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';

                foreach ($data as $row) {

                    $output .= '

                            <li class="search-select list-group-item list-group-item-action flex-column align-items-start" data-id="' . $row->product_id . '">
                                <img class="w-7 h-7 rounded shadow mr-3" src="https://ariba.ma/image/' . $row->image . '">' . $row->name . '
                            </li>
                   ';
                }

                $output .= '</ul>';
            } else {

                $output .= '<li class="list-group-item">' . 'No results' . '</li>';
            }

            return $output;
        }
    }

    public function SearchDetails(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::connection("mysql2")->table("master_product")->where("product_id", "=", "$request->id")->first();

            $description_ar = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $request->id . " AND pd.language_id=2");
            $description_fr = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $request->id . " AND pd.language_id=4");
            $description_eng = DB::connection("mysql2")->select("SELECT * From master_product_description pd where pd.product_id=" . $request->id . " AND pd.language_id=1");

            $images = DB::connection("mysql2")->table("master_product_image")->where("product_id", "=", "$request->id")->get();

            return response()->json(['success' => true, 'product' => $data, 'description_ar' => $description_ar, 'description_fr' => $description_fr, 'description_eng' => $description_eng, 'images' => $images]);
        }
    }

    public function Test()
    {
        return view('admin.mains-admin.product.test');
    }

    public function RulesAdd()
    {
        $rules = array(
            'name_2' => '',
            'description_2' => '',
            'name_3' => '',
            "description_3" => '',
            'model' => '',
            'sku' => '',
            'upc' => '',
            'gtn' => '',
            'jan' => '',
            'ean' => '',
            'date_available' => '',
            'sort_order' => '',
            'status' => 'required',
            'quantity' => 'required|min:0',
            'price' => 'required|min:0',
            'manufacturer_id' => 'required',
            'width' => '',
            'height' => '',
            'length' => '',
            'categories' => 'required',
            'set_number' => '',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image1' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image2' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image3' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image4' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image5' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image6' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'ean_35' => 'unique:oc_product_option_value,ciopean',
            'ean_36' => 'unique:oc_product_option_value,ciopean',
            'ean_37' => 'unique:oc_product_option_value,ciopean',
            'ean_38' => 'unique:oc_product_option_value,ciopean',
            'ean_39' => 'unique:oc_product_option_value,ciopean',
            'ean_40' => 'unique:oc_product_option_value,ciopean',
            'ean_41' => 'unique:oc_product_option_value,ciopean',
            'ean_xs' => 'unique:oc_product_option_value,ciopean',
            'ean_s' =>  'unique:oc_product_option_value,ciopean',
            'ean_m' =>  'unique:oc_product_option_value,ciopean',
            'ean_l' =>  'unique:oc_product_option_value,ciopean',
            'ean_xl' => 'unique:oc_product_option_value,ciopean',
            'ean_xxl' => 'unique:oc_product_option_value,ciopean',
        );

        return $rules;
    }
    public function RulesUpdate($id)
    {
        $rules = array(
            'name_2' => 'required',
            'description_2' => 'required|min:2',
            'name_3' => 'required|min:2',
            "description_3" => 'required',
            'model' => '',
            'sku' => '',
            'upc' => '',
            'gtn' => '',
            'jan' => '',
            'ean' => '',
            'date_available' => '',
            'sort_order' => '',
            'status' => 'required',
            'quantity' => 'required|min:0',
            'price' => 'required|min:0',
            'manufacturer_id' => 'required',
            'width' => '',
            'height' => '',
            'length' => '',
            'categories' => 'required',
            'set_number' => '',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image1' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image2' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image3' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image4' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image5' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image6' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'ean_35' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_36' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_37' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_38' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_39' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_40' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_41' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_xs' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_s' =>  "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_m' =>  "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_l' =>  "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_xl' => "unique:oc_product_option_value,ciopean,$id,product_id",
            'ean_xxl' => "unique:oc_product_option_value,ciopean,$id,product_id"
        );

        return $rules;
    }
    public function AttributeNames()
    {
        $attributeNames = array(
            'name_2' => 'product Name (French)',
            'description_2' => 'description (French)',
            'name_3' => 'Product Name (Arabic)',
            "description_3" => 'description (Arabic)',
            'model' => 'model',
            'sku' => 'sku',
            'upc' => 'upc',
            'gtn' => 'gtn',
            'jan' => 'jan',
            'date_available' => 'date available',
            'sort_order' => 'sort order',
            'status' => 'status',
            'quantity' => 'quantity',
            'price' => 'price',
            'manufacturer_id' => 'manufacturer',
            'width' => 'width',
            'height' => 'height',
            'length' => 'length',
            'categories[]' => 'category',
            'set_number' => 'set number',
            'image' => 'main image',
            'image1' => 'image 1',
            'image2' => 'image 2',
            'image3' => 'image 3',
            'image4' => 'image 4',
            'image5' => 'image 5',
            'image6' => 'image 6',
            'ean_35' => 'EAN 35',
            'ean_36' => 'EAN 36',
            'ean_37' => 'EAN 37',
            'ean_38' => 'EAN 38',
            'ean_39' => 'EAN 39',
            'ean_40' => 'EAN 40',
            'ean_41' => 'EAN 41',
            'ean_xs' => 'EAN xs',
            'ean_s' => 'EAN s',
            'ean_m' => 'EAN m',
            'ean_l' => 'EAN l',
            'ean_xl' => 'EAN xl',
            'ean_xxl' => 'EAN xxl',
        );

        return $attributeNames;
    }
}
