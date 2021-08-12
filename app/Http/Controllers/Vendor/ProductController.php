<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $vendor = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->vendor=auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function Product()
    {
        $products = DB::select("SELECT  p.ean,p.model,p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,
        p.status,p.price,p.date_added,pd.name ,m.name as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4' And v.vendor_id=$this->vendor ORDER BY p.date_added DESC ");

        return view('vendor.product.product-list')->with("data", ['products' => $products]);
    }

    public function ProductNotVerified()
    {
        $products = DB::select("SELECT  p.ean,p.model,p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,
        p.status,p.price,p.date_added,pd.name ,m.name as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4' AND p.status=0  And v.vendor_id=$this->vendor ORDER BY p.date_added DESC ");

        return view('vendor.product.product-list-pending')->with("data", ['products' => $products]);
    }

    public function ProductVerified()
    {
        $products = DB::select("SELECT  p.ean,p.model,p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,
        p.status,p.price,p.date_added,pd.name ,m.name as 'manufacturer',v.display_name FROM oc_product p
        LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
        LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
        LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
        LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
        where pd.language_id='4'  AND p.status=1  And v.vendor_id=$this->vendor ORDER BY p.date_added DESC ");

        return view('vendor.product.product-list-verified')->with("data", ['products' => $products]);
    }

    public function ShowAddproduct()
    {

       //GET MANUFACTURERS

        $manufacturers = DB::table('oc_manufacturer', "m")
        ->leftJoin("oc_vendor_to_manufacturer", "m.manufacturer_id", 'oc_vendor_to_manufacturer.manufacturer_id')
        ->where("oc_vendor_to_manufacturer.vendor_id", $this->vendor)
        ->get();

        //GET SUPPLIERS

        $suppliers = DB::table('supplier')
        ->where("supplier.vendor_id", $this->vendor)
        ->get();

        //GET DEPOSITORIES

        $depot = DB::select("SELECT d.name, d.vendor_id, d.depot_id
        FROM depot d
        left join oc_vendor ov ON (d.vendor_id = ov.vendor_id)
         where d.vendor_id=$this->vendor");

        $vendors = DB::select("SELECT * FROM oc_vendor");

        //GET CATEGORIES

        $categories = DB::select("SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ')
         AS name, c1.parent_id, c1.sort_order FROM oc_category_path cp LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id)
         LEFT JOIN oc_category c2 ON (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id)
         LEFT JOIN oc_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '1' AND cd2.language_id = '1'
        and c1.status=1 and c2.status=1 GROUP BY cp.category_id,c1.parent_id,c1.sort_order ORDER BY name ASC;");


        //GET FILTERS

        $filters = DB::select("SELECT f.filter_id, CONCAT(fgd.name, ' > ', fd.name) as name  FROM oc_filter_group_description fgd ,
         oc_filter f LEFT JOIN oc_filter_description fd ON (f.filter_id = fd.filter_id) WHERE
         f.filter_group_id = fgd.filter_group_id AND fgd.language_id =1 and fd.language_id =1 ORDER BY f.sort_order ASC;");

        $count = DB::table("oc_product_option_value")->max("ciopean");
        $ean = array();
        for ($i = 0; $i < 11; $i++) {
            $count++;
            $ean[$i] = '2' . str_pad(substr($count, 1), 7, '0', STR_PAD_LEFT);
        }

        return view('vendor.product.product-add')->with("data", [
            'manufacturers' => $manufacturers,
            'categories' => $categories,
            'vendors' => $vendors,
            'filters' => $filters,
            'ean' => $ean,
            'suppliers'=>$suppliers,
            'depot' => $depot
        ]);
    }

    public function Addproduct(Request $request)
    {
        ini_set('max_execution_time', 300);
        //INPUT VALIDATION
         // dd($request->categories);
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

        if($request->has('stock_status_id')){
            $stock_status_id=8;
        }
        else{
            $stock_status_id=6;
        }

        $new_category=null;
        foreach ($request->categories as $category) {
            if($category=='not_found'){
                $new_category=$request->new_category;
            }
        }
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
            'stock_status_id' => $stock_status_id,
            'estimated_day' => $request->estimated_day,
            'image' => $imageName ?? "none",
            'date_available' => now(),
            'depot_id' => $request->depot_id,
            'manufacturer_id' => $request->manufacturer_id,
            'supplier_id' => $request->supplier_id,
            'status' => 0,
            'price' => floatval($request->price)-floatval($request->price*0.2) ?? 0,
            'height' => $request->height ?? 0,
            'length' => $request->length ?? 0,
            'width' => $request->width ?? 0,
            'tax_class_id' => 9,
            'subtract' => 1,
            'sort_order' => $request->sort_order ?? 0,
            'min_order'=>$request->min_order ?? 0,
            'date_added' => date('Y-m-d H:i:s'),
            'date_modified' => date('Y-m-d H:i:s'),
            'new_category'=>$new_category,
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
        if($new_category==null){
            foreach ($request->categories as $category) {
                DB::table('oc_product_to_category')->insert([
                    ['product_id' => $id, 'category_id' => $category]
                ]);
            }
        }
        //Store filters
        foreach ($request->filters as $filter) {
            DB::table('oc_product_filter')->insert([
                ['product_id' => $id, 'filter_id' => $filter]
            ]);
        }
        if (isset($request->product_discount)) {
			foreach ($request->product_discount as $product_discount) {
                if(isset($product_discount['quantity'])){
                    DB::table('oc_product_discount')->insert([
                        ['product_id' => $id, 'customer_group_id' => 1,
                        'quantity' => $product_discount['quantity'], 'priority' => $product_discount['priority'] ?? 1 ,
                        'price' => $product_discount['price'] ?? 0, 'date_start' => $product_discount['date_start'],
                        'date_end' => $product_discount['date_end'],]
                    ]);
                }
			}
		}

        //Store product to vendor
        DB::table('oc_vendor_to_product')->insert([
            'vendor_id' => $this->vendor, 'product_id' => $id
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

        $manufacturers = DB::table('oc_manufacturer', "m")
            ->leftJoin("oc_vendor_to_manufacturer", "m.manufacturer_id", 'oc_vendor_to_manufacturer.manufacturer_id')
            ->where("oc_vendor_to_manufacturer.vendor_id", $this->vendor)
            ->get();

        $suppliers = DB::table('supplier')
        ->where("supplier.vendor_id", $this->vendor)
        ->get();

        $depot = DB::select("SELECT d.name, d.vendor_id, d.depot_id
        FROM depot d
        left join oc_vendor ov ON (d.vendor_id = ov.vendor_id)
         where d.vendor_id=$this->vendor");

        $vendors = DB::select("SELECT * FROM oc_vendor");

        $categories = DB::select("SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name,
         c1.parent_id, c1.sort_order FROM oc_category_path cp LEFT JOIN oc_category c1 ON (cp.category_id = c1.category_id) LEFT JOIN oc_category c2 ON
         (cp.path_id = c2.category_id) LEFT JOIN oc_category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN oc_category_description cd2 ON
         (cp.category_id = cd2.category_id) WHERE cd1.language_id = '4' AND cd2.language_id = '1' and c1.status=1 and c2.status=1 GROUP BY cp.category_id,c1.parent_id,c1.sort_order
         ORDER BY name ASC;");

        $status = DB::table("oc_product")->where("product_id", "=", "$id")->get("status")->first();

        $image = DB::table("oc_product")->where("product_id", "=", "$id")->get("image")->first();
        $images = DB::table("oc_product_image")->where("product_id", "=", "$id")->get();
        $productCategories = DB::table("oc_product_to_category")->where("product_id", "=", "$id")->get("category_id");
        $filters = DB::select("SELECT f.filter_id, CONCAT(fgd.name, ' > ', fd.name) as name  FROM oc_filter_group_description fgd ,
        oc_filter f LEFT JOIN oc_filter_description fd ON (f.filter_id = fd.filter_id) WHERE
        f.filter_group_id = fgd.filter_group_id AND fgd.language_id =1 and fd.language_id =1 ORDER BY f.sort_order ASC;");

        $productFilters = DB::table("oc_product_filter")->where("product_id", "=", "$id")->get("filter_id");
        $option_id = DB::table('oc_product_option')->where('product_id', $id)->first()->option_id;
        $options = DB::table('oc_product_option_value')->where(["product_id" => $id, "option_id" => $option_id])->orderby("option_value_id")->get();

        $discounts=DB::table('oc_product_discount')->where('product_id',$id)->orderby('priority')->get();

        return view('vendor.product.product-show')->with('data', [
            'product' => $product, 'status' => $status, 'image' => $image, 'manufacturers' => $manufacturers,
            'categories' => $categories, 'vendors' => $vendors, 'description_ar' => $description_ar,
            'description_fr' => $description_fr, 'description_eng' => $description_eng,
            'productCategories' => $productCategories, 'images' => $images, 'filters' => $filters,
            'productFilters' => $productFilters, 'options' => $options, 'option_id' => $option_id,
             'discounts' => $discounts,'suppliers'=>$suppliers,
             'depot' =>$depot
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
        if($request->has('stock_status_id')){
            $stock_status_id=8;
        }
        else{
            $stock_status_id=6;
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
            'status' => 0,
            'price' => floatval($request->price)-floatval($request->price*0.2) ?? 0,
            'height' => $request->height ?? 0,
            'length' => $request->length ?? 0,
            'width' => $request->width ?? 0,
            'supplier_id' => $request->supplier_id,
            'depot_id' =>$request->depot_id,
            'sort_order' => $request->sort_order ?? 0,
            'min_order'=>$request->min_order ?? 0,
            'stock_status_id' => $stock_status_id,
            'estimated_day' =>  $request->estimated_day,
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

        DB::table('oc_product_discount')->where('product_id', '=', $id)->delete();
        if (isset($request->product_discount)) {
			foreach ($request->product_discount as $product_discount) {
                DB::table('oc_product_discount')->insert([
                    ['product_id' => $id, 'customer_group_id' => 1,
                    'quantity' => $product_discount['quantity'], 'priority' => $product_discount['priority'] ?? 1,
                    'price' => $product_discount['price'] ?? 0, 'date_start' => $product_discount['date_start'],
                    'date_end' => $product_discount['date_end'],]
                ]);
			}
		}
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
            'quantity' => 'required|min:0',
            'price' => 'required|min:0',
            'manufacturer_id' => 'required',
            'width' => '',
            'height' => '',
            'length' => '',
            'categories' => 'required',
            'filters' => 'required',
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
            'quantity' => 'required|min:0',
            'price' => 'required|min:0',
            'manufacturer_id' => 'required',
            'width' => '',
            'height' => '',
            'length' => '',
            'estimated_day' => 'min:1',
            'min_order'=>'min:1',
            'categories' => 'required',
            'filters' => 'required',
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


    public function Dashboard(){

        return view('vendor.statistic.dashboard',[

        ]);
    }
}
