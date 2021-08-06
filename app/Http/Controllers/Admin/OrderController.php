<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:order-to-verify', ['only' => ['OrderToVerify','OrderShow']]);
        $this->middleware('permission:order-approve', ['only' => ['Approve']]);
        $this->middleware('permission:order-deny', ['only' => ['Deny']]);
        $this->middleware('permission:order-list', ['only' => ['WaitingApproval','OrderApproved','OrderDenied','OrderCanceled','OrderCompleted','OrderShowWaiting']]);

    }

    public function OrderToVerify()
    {
        $orders = DB::table('oc_order')->where('order_status_id', '=' , 1 )->orderBy('order_id')->get();
        $order_status = DB::table('order_status')->get();
        $order_date_old = 0;

        //TO PROVIDE NEW INVOICE_ID
        foreach ($orders as $order) {
            if (!$order->invoice_id) {
                //$date = DB::table('oc_order')->whereDate('date_added', '=' , $order_date)->where('order_status_id', '=' , 1 )->where('order_id', '!=' , $order->order_id )->orderBy('order_id', 'desc')->count();
                // I SELECTED THE BIGGEST ORDER ID WHO IS LESS THAN THE ORDER ID I HAVE, AND THEN IF THIS ORDER HAS A INVOICE ID, WE PASS IT OLD_ID+1
                $old_order_id = DB::table('oc_order')->where([
                    ['order_status_id', '<>' , 0],
                    ['order_id', '<' , $order->order_id]
                ])->max('order_id');

                $old_order = DB::table('oc_order')->where('order_id', '=', $old_order_id)->first();

                $order_date = date('Y-m-d', strtotime($order->date_added));

                if($old_order != null){
                    $order_date_old = date('Y-m-d', strtotime($old_order->date_added));
                }else{
                    $order_date_old == 0;
                }

                if ($order_date == $order_date_old) {
                    if ($old_order->invoice_id) {
                        $generated_id = $old_order->invoice_id + 1;
                    }else{
                        $date_count = sprintf('%06d', 1);
                        $generated_id = date('Ymd', strtotime($order->date_added)) . $date_count;
                    }
                } else {
                    $date_count = sprintf('%06d', 1);
                    $generated_id = date('Ymd', strtotime($order->date_added)) . $date_count;
                }
                DB::table('oc_order')->where('order_id', '=', $order->order_id)->update(['invoice_id' => $generated_id]);
            }
        }

        $new_orders = DB::table('oc_order')->leftJoin('oc_order_status', "oc_order_status.order_status_id",
            "oc_order.order_status_id")->where('oc_order.order_status_id', '=', 1)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_customer', 'oc_customer.customer_id', 'oc_order.customer_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->where('oc_customer.trust', 0)->where('oc_order_status.language_id', 1)->orderBy('oc_order.order_id', 'desc')->get();

        return view('admin.mains-admin.order.order-verify', [
            'orders' => $new_orders,
            'order_status' => $order_status
        ]);
    }

    public function OrderApproved()
    {
        $orders_approved = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->where('oc_order_status.language_id',1)->where('oc_order.order_status_id', '=' , 3 )
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_customer', 'oc_customer.customer_id', 'oc_order.customer_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->orderBy('date_added', 'desc')->get();
        $order_product_status = DB::table('order_product_status')->get();

        return view('admin.mains-admin.order.order-approved', [
            'orders' => $orders_approved,
            'order_product_status' => $order_product_status
        ]);
    }

    public function WaitingApproval()
    {
        $orders = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->where('oc_order_status.language_id',1)->where('oc_order.order_status_id', '=' , 1 )
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_customer', 'oc_customer.customer_id', 'oc_order.customer_id')
            ->leftjoin('oc_vendor_order_product','oc_order.order_id','oc_vendor_order_product.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->where('oc_vendor_order_product.order_status_id',1)->where('oc_customer.trust', 1)->orderBy('date_added', 'desc')->groupby('oc_order.order_id')->get();
        $order_product_status = DB::table('order_product_status')->get();

        $oc_order_history = DB::table('oc_order_history')->orderBy('date_added', 'desc')->get();

        return view('admin.mains-admin.order.order-waiting-approval', [
            'orders' => $orders,
            'order_product_status' => $order_product_status,
            'oc_order_history' => $oc_order_history
        ]);
    }

    public function WaitingShipping()
    {
        $orders = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->where('oc_order_status.language_id',1)->where('oc_order.order_status_id', '=' , 4 )
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->orderBy('date_added', 'desc')->get();
        $order_product_status = DB::table('order_product_status')->get();

        $oc_order_history = DB::table('oc_order_history')->orderBy('date_added', 'desc')->get();

        return view('admin.mains-admin.order.order-waiting-for-shipping', [
            'orders' => $orders,
            'order_product_status' => $order_product_status,
            'oc_order_history' => $oc_order_history
        ]);
    }

    public function OrderDenied()
    {
        $orders_denied = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->where('oc_order_status.language_id',1)->where('oc_order.order_status_id', '=' , 17 )
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->orderBy('date_added', 'desc')->get();

        $order_product_status = DB::table('order_product_status')->get();

        return view('admin.mains-admin.order.order-denied', [
            'orders' => $orders_denied,
            'order_product_status' => $order_product_status
        ]);
    }

    public function OrderCanceled()
    {
        $orders_cancel = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->where('oc_order_status.language_id',1)->whereIn('oc_order.order_status_id', [7, 8, 9, 10, 12, 13, 14, 16])
            ->get();

        $order_product_status = DB::table('order_product_status')->get();

        return view('admin.mains-admin.order.order-canceled', [
            'orders' => $orders_cancel,
            'order_product_status' => $order_product_status
        ]);
    }

    public function OrderCompleted()
    {
        $orders = DB::table('oc_order')->leftJoin('oc_order_status',"oc_order_status.order_status_id","oc_order.order_status_id")
            ->where('oc_order_status.language_id',1)->where('oc_order.order_status_id', '=' , 5)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order_status.name as status_name,oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->orderBy('date_added', 'desc')->get();

        $products = DB::table('oc_product')->get();
        $order_status = DB::table('order_status')->get();
        $order_product_status = DB::table('order_product_status')->get();

        return view('admin.mains-admin.order.order-completed', [
            'orders' => $orders,
            'products' => $products,
            'order_status' => $order_status,
            'order_product_status' => $order_product_status
        ]);
    }

    //CUSTOMER STORE data
    public function StoreComplete(Request $request)
    {
        $order_id = $request->input('order_id');
        $date_add = Carbon::now()->toDateTimeString();

        //Update status to Completed
        DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment, date_added) values (?, ?, ?, ?, ?)',
            [$order_id, 5, 0, 'Production Completed', $date_add]);
        DB::table('oc_order')->where('order_id', '=' , $order_id)->update(['order_status_id'=>5]);

        return redirect()->route('orderscompleted');
    }

    public function Approve(Request $request,$id)
    {
        $invoice_id = $request->input('invoice_id');
        $order=DB::table('oc_order')->where('order_id',$id)->first();
        //17 means Waiting Approval
        DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment) values (?, ?, ?, ?)',
            [$id, 2, 1, 'Status Updated']);
        DB::table('oc_order')->where('order_id', '=' , $id)->update(['order_status_id'=>2]);

        //Add trustful client
        DB::table('oc_customer')->where('customer_id', '=' , $order->customer_id)->update(['trust'=>1]);

        $order_products = DB::table('oc_order_product')->where('order_id', '=' , $id)->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $id)->get();


        return redirect()->route('order-to-verify')->with('success', 'The order has been confirmed successfully!');
    }


    public function Deny(Request $request,$id)
    {
        DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment) values (?, ?, ?, ?)',
            [$id, 7, 1, $request->status]);

        DB::table('oc_order')->where('order_id', '=' , $id)->update(['order_status_id'=>7,'reason'=>$request->status]);
        return redirect()->route('order-to-verify')->with('success', 'The order has been denied successfully!');
    }

    public function Reset(Request $request,$id)
    {
        DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment) values (?, ?, ?, ?)',
            [$id, 1, 1, 'Order Reseted!']);

        DB::table('oc_order')->where('order_id', '=' , $id)->update(['order_status_id'=>1]);
        return redirect()->route('order-to-verify')->with('message', 'Order Reseted!');
    }

    public function OrderShow($order_id)
    {
        $order = DB::table('oc_order')->where('oc_order.order_id', '=' , $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();


        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->leftJoin('oc_vendor', "vop.vendor_id","oc_vendor.vendor_id")->get();


        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $order_id)->get();
        $order_history = DB::table('oc_order_history')->where('order_id', '=' , $order_id)->get();
        $order_product_status = DB::table('order_product_status')->where('order_id', '=' , $order_id)->get();
        $oc_order_total = DB::table('oc_order_total')->where('order_id', '=' , $order_id)->get();
        $status=DB::table('oc_order_status')->where('language_id',1)->get();

        return view('admin.mains-admin.order.order-show', [
            'order' => $order,
            'order_products' => $order_products,
            'order_options' => $order_options,
            'order_history' => $order_history,
            'order_product_status' => $order_product_status,
            'oc_order_total' => $oc_order_total,
            'status_order'=>$status,
        ]);
    }

    public function OrderShowWaiting($order_id)
    {
        $order = DB::table('oc_order')->where('oc_order.order_id', '=' , $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->leftJoin('oc_vendor', "vop.vendor_id","oc_vendor.vendor_id")->get();

        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $order_id)->get();
        $order_history = DB::table('oc_order_history')->where('order_id', '=' , $order_id)->get();
        $order_product_status = DB::table('order_product_status')->where('order_id', '=' , $order_id)->get();
        $oc_order_total = DB::table('oc_order_total')->where('order_id', '=' , $order_id)->get();
        $status=DB::table('oc_order_status')->where('language_id',1)->get();

        return view('admin.mains-admin.order.order-show-waiting', [
            'order' => $order,
            'order_products' => $order_products,
            'order_options' => $order_options,
            'order_history' => $order_history,
            'order_product_status' => $order_product_status,
            'oc_order_total' => $oc_order_total,
            'status_order'=>$status,
        ]);
    }

    public function Details($order_id)
    {
        $order = DB::table('oc_order')->where('order_id', '=' , $order_id)->first();
        $order_products = DB::table('oc_order_product')->where('order_id', '=' , $order_id)->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $order_id)->get();
        $order_history = DB::table('oc_order_history')->where('order_id', '=' , $order_id)->get();
        $order_product_status = DB::table('order_product_status')->where('order_id', '=' , $order_id)->get();
        $oc_order_total = DB::table('oc_order_total')->where('order_id', '=' , $order_id)->get();

        return view('orders.details', [
            'order' => $order,
            'order_products' => $order_products,
            'order_options' => $order_options,
            'order_history' => $order_history,
            'order_product_status' => $order_product_status,
            'oc_order_total' => $oc_order_total
        ]);
    }

    public function Request($order_id)
    {
        $order = DB::table('oc_order')->where('order_id', '=' , $order_id)->first();
        $order_products = DB::table('oc_order_product')->where('order_id', '=' , $order_id)->get();
        $products = DB::table('oc_product')->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $order_id)->get();

        if(DB::table('order_status')->where('order_id', '=' , $order_id)->first()){
            $order_status = DB::table('order_status')->where('order_id', '=' , $order_id)->first();
            $order_product_status = DB::table('order_product_status')->where('order_id', '=' , $order_id)->get();
            $o_status = 1;

        }else{
            $order_status = 0;
            $order_product_status = 0;
            $o_status = 0;
        }

        return view('orders.request', [
            'order' => $order,
            'products' => $products,
            'order_products' => $order_products,
            'order_options' => $order_options,
            'order_status' => $order_status,
            'order_product_status' => $order_product_status,
            'o_status' => $o_status
        ]);
    }

    public function StoreCustomer(Request $request)
    {
        $i = 0;
        $j = 0;
        $date_add = Carbon::now()->toDateTimeString();
        $order_id = $request->input('order_id');
        $order_products = DB::table('oc_order_product')->where('order_id', '=' , $order_id)->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=' , $order_id)->get();

        foreach ($order_products as $order_product){
            foreach ($order_options as $key => $order_option){
                if ($order_product->order_product_id == $order_option->order_product_id){
                    if($request->input('yes'.$key) == 1){
                        DB::table('order_product_status')
                            ->where([
                                'order_id'=> $order_id,
                                'product_id'=> $order_product->product_id
                            ])
                            ->update(['status' => 'accepted']);
                        $i++;
                    }else{
                        DB::table('order_product_status')
                            ->where([
                                'order_id'=> $order_id,
                                'product_id'=> $order_product->product_id
                            ])
                            ->update(['status' => 'refused']);
                        $i++;
                        $j++;
                    }
                }
            }
        }

        if ($i > 0) {
            DB::table('order_status')
                ->where('order_id', $order_id)
                ->update([
                    'status' => 1,
                    'date_add' => $date_add
                ]);
        }

        if($j == 0){
            //Update status to Production in progress
            DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment, date_added) values (?, ?, ?, ?, ?)',
                [$order_id, 18, 1, 'Production in progress', $date_add]);
            DB::table('oc_order')->where('order_id', '=' , $order_id)->update(['order_status_id'=>18]);
        }

        return view('orders.customer.thankyou');
    }
}
