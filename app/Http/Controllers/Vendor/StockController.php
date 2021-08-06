<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    protected $vendor = null;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }


    public function showSearch()
    {
        return view('vendor.stock.product-search');

    }

    public function productList(Request $request)
    {

        $products = DB::table('oc_product', 'p')
            ->leftJoin('oc_vendor_to_product', 'p.product_id', 'oc_vendor_to_product.product_id')
            ->leftjoin('oc_product_description', 'p.product_id', 'oc_product_description.product_id')
            ->leftjoin('product_to_depot', 'p.product_id', 'product_to_depot.product_id')
            ->where('product_to_depot.depot_id', 1)
            ->where('oc_product_description.name', 'like', '%' . $request->search . '%')
            ->orwhere('p.ean', 'like', '%' . $request->search . '%')
            ->orwhere('p.sku', 'like', '%' . $request->search . '%')
            ->orwhere('p.ean', 'like', '%' . $request->search . '%')
            ->orwhere('p.product_id', 'like', '%' . $request->search . '%')
            ->where('oc_product_description.language_id', 1)
            ->where('oc_vendor_to_product.vendor_id', $this->vendor)
            ->groupby('p.product_id')->get();

            return view('vendor.stock.product-list', ['products' => $products]);

    }

    public function searchforplace(Request $request,$id)
    {

        //GET PRODUCT DETAILS


        $product = DB::select("SELECT p.product_id, p.place, p.model,p.sku,p.ean,p.quantity,p.image,pd.name, ap.Sku, ap.Sett, ap.s35, ap.s36, ap.s37, ap.s38, ap.s39, ap.s40, ap.s41
            FROM oc_product p
            LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
            LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
            LEFT JOIN ariba_products ap ON (p.product_id = ap.Id)
            where vp.vendor_id=$this->vendor and pd.language_id = 1 and p.status = 1
            and p.product_id=$id limit 1");

         if (!$product) return abort(404);


        // GET PRODUCT OPTIONS

        $option_id = DB::table('oc_product_option')->where('product_id', $id)->first()->option_id;


        $options = DB::table('oc_product_option_value')
            ->leftJoin(
                'oc_option_value_description',
                'oc_option_value_description.option_value_id',
                'oc_product_option_value.option_value_id'
            )
            ->where(["product_id" => $id , "oc_product_option_value.option_id" => $option_id, 'language_id' => 1])
            ->orderBy('oc_option_value_description.option_value_id', 'asc')->get();


        // GET PLACES FOR NEW STOCK

        $placee = DB::select("SELECT pl.place_id,pl.name FROM place pl
         LEFT JOIN depot_place dp ON (pl.place_id = dp.place_id)");

        // GET OPTIONS FOR NEW STOCK

        $optionn = DB::select("SELECT o.option_value_id, o.name, o.option_id
        FROM oc_product_option_value op
        LEFT JOIN oc_option_value_description o ON (o.option_value_id = op.option_value_id)
        LEFT JOIN oc_product pr ON (op.product_id = pr.product_id)
        where op.option_id = 13 and op.product_id=$id  and language_id=1");

        //GET DEPOSITORIES

        $depot = DB::select("SELECT d.name, d.vendor_id, d.depot_id
        FROM depot d
        left join oc_vendor ov ON (d.vendor_id = ov.vendor_id)
        where d.vendor_id=$this->vendor");
       
        // GET New Stock Added From DataBase

        $places = DB::table('product_place')->where('product_id', $request->product_id )->get();


        return view('vendor.stock.product-show')->with([

            'product_id' => $request->product_id ,
            'options' => $options,
            'placee' => $placee,
            'optionn' => $optionn,
            'places' => $places,
            'product' => $product,
            'depot' => $depot
        ]);
    }


    // --------------------- Update New Stock -------------------

    public function update_stocks(Request $request, $id)
    {
        DB::table('product_place')->where('product_id', '=', $id)->delete();
        foreach ($request->product_stock as $stock) {
            if ($stock['type'] == 'Set')
                DB::insert(
                    'insert into product_place (product_id,place,type, depot_id,quantity,option_value) values (?, ?, ?, ?, ?,?)',
                    [$id, $stock['place'], $stock['type'], $stock['depot'], $stock['quantity'],null]
                );
            else {
                DB::insert(
                    'insert into product_place (product_id,place,type, depot_id,quantity,option_value) values (?, ?, ?, ?, ?,?)',
                    [$id, $stock['place'], $stock['type'], $stock['depot'], $stock['quantity'], $stock['option_value']]
                );
            }
        }
        return back()->with('success', 'The stock is updated successfully');
    }

    // --------------------- Update Products Details -------------------

    public function stock_save(Request $request)
    {

        foreach ($request->product_details as $details) {
            // dd($details);
            DB::table('oc_product_option_value')->where('product_option_value_id', $details['product_option_value_id'])->update(
                ['quantity' => $details['quantity']]
            );
        }

        return back()->with('success', 'The stock is updated successfully');
    }


    // --------------------- Add A New Stock -------------------

    public function place_save(Request $request)
    {
        $attributeNames = array(
            'place' => 'place',
            'qte_place' => 'quantity',
            'option_value' => 'option'
        );

        $set = array(
            'place' => 'required',
            'qte_place' => 'required|min:1'
        );

        $piece = array(
            'place' => 'required',
            'qte_place' => 'required|min:1'

        );

        if ($request->type == 0)
                 $rules= $set ;
        else
                  $rules= $piece ;



        $validator = Validator::make($request->all(), $rules,$attributeNames);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product_id = $request->input('product_id');
        $product = DB::table('oc_product')->where('product_id', $product_id)->first();
        $product_places = $request->input('place');
        $qte_place = $request->input('qte_place');
        $date_add = Carbon::now();

        DB::insert(
            'insert into product_place (product_id,place,type,depot_id, quantity,option_value) values (?, ?,?, ?, ?,?)',
            [$product_id, $request->place, $request->type,1, $qte_place, $request->option]
        );

        $q = $request->input('q');
        return redirect()->back()->with('success', 'The stock has been added successfully')->withInput();
    }


}
