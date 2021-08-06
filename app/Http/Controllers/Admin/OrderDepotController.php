<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courier;
use App\OrderShipment;

class OrderDepotController extends Controller
{
    protected $vendor = null;
    function __construct()
    {
        $this->middleware('permission:order-approved', ['only' => ['OrderShow','OrderShowApproved','OrderApproved','shippe']]);
        $this->middleware('permission:order-shipped', ['only' => ['OrderShowShipped','WaitingShipping','finish']]);
        $this->middleware('permission:order-complete', ['only' => ['OrderShowFinished','OrderCompleted']]);
        $this->vendor=1;
    }

    public function OrderApproved()
    {
        $orders=self::orderList(2);
            
        return view('admin.mains-admin.order-depot.order-approved', [
            'orders' => $orders,
        ]);
    }
    public function WaitingShipping()
    {
        $orders=self::orderList(4);

        return view('admin.mains-admin.order-depot.order-waiting-for-shipping', [
            'orders' => $orders,
        ]);
    }

    public function OrderCompleted()
    {
        $orders=self::orderList(5);
     
        return view('admin.mains-admin.order-depot.order-completed', [
            'orders' => $orders,
        ]);
    }

    public function GetCourier(Request $request)
    {
        if($request->ajax()){
            $courier=Courier::findOrFail($request->courier_id);

            return response()->json(array("courier"=>$courier),200);
        }
    }

    // public function SetDeliveyMethod($order_id, $method)
    // {
    //     $order = self::getOrder($order_id,2);
    //     if(!$order) abort(404);

    //     DB::table("order_shipment")->insert([
    //         ["method_shipment" => $method, "order_id" => $order_id,
    //         "vendor_id" => auth()->id()]
    //     ]);

    //     return redirect()->back();
    // }

    public function RemoveDeliveyMethod($order_id)
    {
        $order = self::getOrder($order_id,2);
        if(!$order) abort(404);

        DB::table('order_shipment')->where('order_id', '=', $order_id)->delete();

        return redirect()->back();
    }

    public function SetDeliveyManAriba($order_id, Request $request)
    {
        $order = self::getOrder($order_id,2);
        if(!$order) abort(404);

        DB::table("order_shipment")->where("order_id",$order_id)->update(["courier_id"=>$request->courierID]);

        return redirect()->back();
    }

    public function RemoveDeliveryManAriba($order_id, Request $request)
    {
        $order = self::getOrder($order_id,2);
        if(!$order) abort(404);

        DB::table("order_shipment")->where("order_id",$order_id)->update(["courier_id"=>null]);

        return redirect()->back();
    }

    public function OrderShowApproved($order_id)
    {
        $order = self::getOrder($order_id,2);
        if(!$order) abort(404);

        $order_products = self::getOrderProduct($order_id);
        $order_options =self::getOrderOption($order_id);
        $order_history =self::getOrderHistory($order_id);

        $invoice= DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->where('order_id',$order->order_id)->first();
        $couriers= DB::table('courier')->get();
        $shipment= DB::table('order_shipment')->where('order_id',$order_id)->first();
        // $shipment->courier->name
        if($shipment) {
            $shiporder = OrderShipment::find($shipment->shipment_id)->first();
        } else {
            $shiporder = null;
        }

        // dd($shiporder->courier->name);

        return view('admin.mains-admin.order-depot.order-show-approved', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
            'invoice' => $invoice,
            'couriers' => $couriers,
            'shipment' => $shipment,
            'shiporder' => $shiporder
        ]);
    }

    public function OrderShowShipped($order_id)
    {
        $order = self::getOrder($order_id,4);
        if(!$order) abort(404);

        $order_products = self::getOrderProduct($order_id);
        $order_options =self::getOrderOption($order_id);
        $order_history =self::getOrderHistory($order_id);

        return view('admin.mains-admin.order-depot.order-show-shipped', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function OrderShowFinished($order_id)
    {
        $order = self::getOrder($order_id,5);
        if(!$order) abort(404);

        $order_products = self::getOrderProduct($order_id);
        $order_options =self::getOrderOption($order_id);
        $order_history =self::getOrderHistory($order_id);

        return view('admin.mains-admin.order-depot.order-show-finished', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function shippe(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>4]);

        if($request->shipping_method=='Ariba Express')
            DB::table("oc_order")->where("order_id",$id)->update(["shipping_method"=>$request->shipping_method,'shipping_code'=>'xshippingpro.xshippingpro3']);
        else
            DB::table("oc_order")->where("order_id",$id)->update(["shipping_method"=>$request->shipping_method,'shipping_code'=>'xshippingpro.xshippingpro1']);

        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 4, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }
        return redirect()->route('order-depot-approved')->with('success', 'The order has been shipped successfully!');
    }


    public function finish(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>5]);
    
        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 5, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }
        return redirect()->route('order-depot-shipped')->with('success', 'The order has been completed successfully!');
    }

    public function cancel(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>7]);
    
        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 7, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }
        return redirect()->route('order-depot-approved')->with('success', 'The order has been canceled successfully!');
    }

    public function getOrder($order_id,$status)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->where('oc_vendor_order_product.order_status_id', '=', $status)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        return $order;
    }

    public function getOrderProduct($order_id)
    {
        $order_products = DB::table('oc_vendor_order_product',"vop")
        ->select('vop.*','oc_product_description.*','oc_product.sku')
        ->leftJoin("oc_product","vop.product_id","oc_product.product_id")
        ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
        ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
        ->where('vendor_id', '=', $this->vendor)->get();

        return $order_products;
    }

    public function getOrderHistory($order_id)
    {
        $order_history = DB::table('oc_order_vendorhistory')
        ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
        ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
        ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
        ->where('oc_product_description.language_id',1)
        ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
        ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
        ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
        ->orderBy("date_added",'desc')->get();

        return $order_history;
    }

    public function getOrderOption($order_id)
    {
        $order_options = DB::table('oc_order_option')
        ->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)
        ->where('vendor_id', '=', $this->vendor)->get();

        return $order_options;
    }

    public function orderList($status_id)
    {
        $orders=DB::table("oc_vendor_order_product","vop")
        ->leftJoin("oc_order", function($join){
            $join->on("vop.order_id","=","oc_order.order_id");
        })
        ->leftJoin("oc_order_status", function($join){
            $join->on("oc_order_status.order_status_id","=","vop.order_status_id");
        })
        ->leftJoin("oc_salesagent_order", function($join){
            $join->on("oc_salesagent_order.order_id", "=", "oc_order.order_id");
        })
        ->leftJoin("oc_salesagent", function($join){
            $join->on("oc_salesagent_order.salesagent_id", "=", "oc_salesagent.salesagent_id");
        })
        ->select("oc_order.from_app as from_app", DB::raw('sum(vop.total) as total'), DB::raw('count(vop.product_id) as county'),
         "oc_order.invoice_id", DB::raw('CONCAT(oc_order.firstname," ",oc_order.lastname) as cname'), "vop.order_id as order_id", 
         "vop.date_added as date_added", "oc_order_status.name as status", DB::raw('CONCAT(oc_salesagent.firstname," ", oc_salesagent.lastname) 
         as sname'), 
         "oc_order.payment_city", "oc_order.shipping_method", DB::raw('sum(vop.tax*vop.quantity) as tax'))
        ->where("vendor_id", "=", $this->vendor)
        ->where("oc_order_status.language_id", "=", 1)
        ->where("oc_order_status.order_status_id", "=", $status_id)
        ->where("oc_order.order_status_id", "<>", 0)
        ->groupBy("oc_order.order_id")
        ->get();

        return $orders;
    }

}
