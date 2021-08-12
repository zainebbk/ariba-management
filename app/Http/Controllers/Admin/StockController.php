<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Place;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class StockController extends Controller
{
    public function showSearch()
    {
        return view('admin.mains-admin.stock.product-search');
    }

    public function productList(Request $request)
    {
        $products = DB::table('oc_product', 'p')->leftjoin('oc_product_description', 'p.product_id', 'oc_product_description.product_id')
            ->leftjoin('product_to_depot', 'p.product_id', 'product_to_depot.product_id')->where('product_to_depot.depot_id', 1)
            ->where('oc_product_description.name', 'like', '%' . $request->search . '%')->orwhere('p.ean', 'like', '%' . $request->search . '%')
            ->orwhere('p.sku', 'like', '%' . $request->search . '%')->orwhere('p.ean', 'like', '%' . $request->search . '%')
            ->orwhere('p.product_id', 'like', '%' . $request->search . '%')->where('oc_product_description.language_id', 1)
            ->groupby('p.product_id')->get();

        return view('admin.mains-admin.stock.product-list', ['products' => $products]);
    }

    public function searchforplace( $id)
    {
        // GET PRODUCT DETAILS

        $product = DB::select("SELECT opd.name, opd.product_id, p.model,p.sku,p.ean,p.image, p.set_number
         FROM oc_product_description opd
         LEFT JOIN oc_product p ON (p.product_id = opd.product_id )
         where opd.language_id = 1 AND opd.product_id=$id limit 1 ");

        if (!$product) return abort(404);

        // GET PRODUCT OPTIONS

        $option_id = DB::table('oc_product_option')->where('product_id', $id)->first()->option_id;

        $options = DB::table('oc_product_option_value')
            ->leftJoin(
                'oc_option_value_description',
                'oc_option_value_description.option_value_id',
                'oc_product_option_value.option_value_id'
            )
            ->where(["product_id" => $id, "oc_product_option_value.option_id" => $option_id, 'language_id' => 1])
            ->orderBy('oc_option_value_description.option_value_id', 'asc')->get();


        // GET PLACES FOR NEW STOCK

        $placee = DB::select("SELECT pl.place_id,pl.name FROM place pl
         LEFT JOIN depot_place dp ON (pl.place_id = dp.place_id)
         where dp.depot_id = 1");

        // GET PLACES FOR NEW STOCK

        $optionn = DB::select("SELECT o.option_value_id, o.name, o.option_id FROM oc_product_option_value op
        LEFT JOIN oc_option_value_description o ON (o.option_value_id = op.option_value_id)
         LEFT JOIN oc_product pr ON (op.product_id = pr.product_id)
        where op.option_id = 13 and op.product_id=$id and language_id=1");
<<<<<<< HEAD

        // GET New Stock Added From DataBase
        
        $places = DB::table('product_place')->where('product_id', $id)->get();
        
=======

        // GET New Stock Added From DataBase

        $places = DB::table('product_place')->where('product_id', $id)->get();
>>>>>>> 621e5726ebe2ff721881139194139c46b6dd63fd

        return view('admin.mains-admin.stock.product-show')->with([

            'product_id' => $id,
            'placee' => $placee,
            'places' => $places,
            'optionn' => $optionn,
            'product' => $product,
            'options' => $options

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
                    [$id, $stock['place'], $stock['type'], 1, $stock['quantity'],null]
                );
            else {
                DB::insert(
                    'insert into product_place (product_id,place,type, depot_id,quantity,option_value) values (?, ?, ?, ?, ?,?)',
                    [$id, $stock['place'], $stock['type'], 1, $stock['quantity'], $stock['option_value']]
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
        // dd($request->type);
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
        $places = $request->input('place');
        $qte_place = $request->input('qte_place');
        $date_add = Carbon::now();

        DB::insert(
<<<<<<< HEAD
            'insert into product_place (product_id,place,type, depot_name,quantity,option_value) values (?, ?, ?, ?, ?,?)',
            [$product_id, $request->place, $request->type,"MyPapuci", $qte_place, $request->option]
=======
            'insert into product_place (product_id,place,type, depot_id,quantity,option_value) values (?, ?, ?, ?, ?,?)',
            [$product_id, $request->place, $request->type, 1, $qte_place, $request->option]
>>>>>>> 621e5726ebe2ff721881139194139c46b6dd63fd
        );

        $q = $request->input('q');
        return redirect()->back()->with('success', 'The stock has been added successfully')->withInput();
    }
}
