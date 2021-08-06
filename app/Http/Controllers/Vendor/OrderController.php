<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    protected $vendor = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->vendor=auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function OrderToVerify()
    {
        self::GenerateOrderNo();
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            LEFT JOIN oc_customer c on c.customer_id=o.customer_id
            where vendor_id=$this->vendor and c.trust=1 and  os.language_id=1 and os.order_status_id=1 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-verify', [
            'orders' => $orders,
        ]);
    }

    public function GenerateOrderNo()
    {
        $orders = DB::table('oc_order')->where('order_status_id', '=' , 1 )->orderBy('order_id')->get();
        $order_status = DB::table('order_status')->get();
        $order_date_old = 0;

        foreach ($orders as $order) {
            if (!$order->invoice_id) {
                $old_order_id = DB::table('oc_order')->where([
                    ['order_status_id', '<>' , 0],
                    ['order_id', '<' , $order->order_id]
                ])->max('order_id');

                $old_order = DB::table('oc_order')->where('order_id', '=', $old_order_id)->first();

                $order_date = date('Y-m-d', strtotime($order->date_added));

                if($old_order != null)
                    $order_date_old = date('Y-m-d', strtotime($old_order->date_added));
                else
                    $order_date_old == 0;

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
    }

    public function OrderShow($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function OrderShowClarify($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show-clarify', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }
    public function OrderShowApproved($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

                       $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
                        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show-approved', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }
    public function OrderShowFinished($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show-finished', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function OrderShowCanceled($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.order_id', '=', $order_id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show-canceled', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function addOrderStatus($id,Request $request){
        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>$request->status]);
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")->first();


        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => $request->status, "vendor_id" => $this->vendor, "order_product_id" =>$product->order_product_id,"comment" => $request->comment,"updateby" => $vendor->name]
            ]);
        }
        if($request->status==17 && isset($vendor->supplier_email) && $vendor->is_pre_order ){
            $details = [
                'title' => 'I have a new order',
                'body1' => 'Hello, you can view our order by pressing the confirm button.',
                'link' => $id,
            ];

            Mail::to($vendor->supplier_email)->send(new SendMail( $details ));
        }
    }

    public function OrderApproved()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id=2 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-approved', [
            'orders' => $orders,
        ]);
    }

    public function WaitingApproval()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id=3 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-waiting-approval', [
            'orders' => $orders,
        ]);
    }

    public function WaitingShipping()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id=4 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-waiting-for-shipping', [
            'orders' => $orders,
        ]);
    }

    public function OrderClarified()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id=6 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-clarified', [
            'orders' => $orders,
        ]);
    }

    public function OrderCanceled()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id in (7, 8, 9, 10, 12, 13, 14, 16, 11) and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

        return view('vendor.order.order-canceled', [
            'orders' => $orders,
        ]);
    }

    public function OrderCompleted()
    {
        $orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            where vendor_id=$this->vendor and os.language_id=1 and os.order_status_id=5 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");


        return view('vendor.order.order-completed', [
            'orders' => $orders,
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
        DB::table('oc_order')->where('order_id', '=', $order_id)->update(['order_status_id' => 5]);

        return redirect()->route('vendor-orderscompleted');
    }

    public function Approve(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>2]);
    
        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 2, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }

        return redirect()->route('vendor-order-to-verify')->with('success', 'The order has been confirmed successfully!');
    }

    public function shippe(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>4]);
    
        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 4, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }

        return redirect()->route('vendor-order-waiting-shipping')->with('success', 'The order has been confirmed successfully!');
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

        return redirect()->route('vendor-order-finished')->with('success', 'The order has been confirmed successfully!');
    }

    public function clarify(Request $request, $id)
    {
        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>6,"state"=>0]);
        
        foreach($request->product_id as $product_id)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 6, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }

        return redirect()->route('vendor-order-clarified')->with('success', 'The order has been clarified successfully!');
    }

    public function Deny(Request $request, $id)
    {
        DB::table("oc_vendor_order_product")->where("order_id",$id)->update(["order_status_id"=>7]);

        $vendor=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description","v.vendor_id","oc_vendor_description.vendor_id")
        ->where('v.vendor_id',$this->vendor)->first();

        $order_products = DB::table('oc_vendor_order_product')->where('order_id', '=', $id)
            ->where('vendor_id', '=', $this->vendor)->get();

        foreach ($order_products as $product)
        {
            DB::table("oc_order_vendorhistory")->insert([
                ["order_id" => $id, "order_status_id" => 7, "vendor_id" => $this->vendor, 
                "order_product_id" =>$product->order_product_id,"comment" => $request->status,"updateby" => $vendor->name]
            ]);
        }
        
        return redirect()->route('vendor-order-to-verify')->with('success', 'The order has been denied successfully!');
    }

    public function Reset(Request $request, $id)
    {
        DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment) values (?, ?, ?, ?)',
            [$id, 1, 1, 'Order Reseted!']);

        DB::table('oc_order')->where('order_id', '=', $id)->update(['order_status_id' => 1]);
        return redirect()->route('vendor-order-to-verify')->with('message', 'Order Reseted!');
    }

    public function OrderShowShipped($order_id)
    {
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
        ->where('oc_vendor_order_product.vendor_id',$this->vendor)
        ->where('oc_order.order_id', '=', $order_id)
        ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
        ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
        ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
        ->first();

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order_id)
            ->where('vendor_id', '=', $this->vendor)->get();

                       $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
                        ->where('oc_vendor_order_product.order_id', '=', $order_id)->where('oc_order_option.order_id',$order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        return view('vendor.order.order-show-shipped', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
        ]);
    }

    public function Details($order_id)
    {
        $order = DB::table('oc_order')->where('order_id', '=', $order_id)->first();
        $order_products = DB::table('oc_order_product')->where('order_id', '=', $order_id)->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=', $order_id)->get();
        $order_history = DB::table('oc_order_history')->where('order_id', '=', $order_id)->get();
        $order_product_status = DB::table('order_product_status')->where('order_id', '=', $order_id)->get();
        $oc_order_total = DB::table('oc_order_total')->where('order_id', '=', $order_id)->get();

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
        $order = DB::table('oc_order')->where('order_id', '=', $order_id)->first();
        $order_products = DB::table('oc_order_product')->where('order_id', '=', $order_id)->get();
        $products = DB::table('oc_product')->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=', $order_id)->get();

        if (DB::table('order_status')->where('order_id', '=', $order_id)->first()) {
            $order_status = DB::table('order_status')->where('order_id', '=', $order_id)->first();
            $order_product_status = DB::table('order_product_status')->where('order_id', '=', $order_id)->get();
            $o_status = 1;

        } else {
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
        $order_products = DB::table('oc_order_product')->where('order_id', '=', $order_id)->get();
        $order_options = DB::table('oc_order_option')->where('order_id', '=', $order_id)->get();

        foreach ($order_products as $order_product) {
            foreach ($order_options as $key => $order_option) {
                if ($order_product->order_product_id == $order_option->order_product_id) {
                    if ($request->input('yes' . $key) == 1) {
                        DB::table('order_product_status')
                            ->where([
                                'order_id' => $order_id,
                                'product_id' => $order_product->product_id
                            ])
                            ->update(['status' => 'accepted']);
                        $i++;
                    } else {
                        DB::table('order_product_status')
                            ->where([
                                'order_id' => $order_id,
                                'product_id' => $order_product->product_id
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

        if ($j == 0) {
            //Update status to Production in progress
            DB::insert('insert ignore into oc_order_history (order_id, order_status_id, notify, comment, date_added) values (?, ?, ?, ?, ?)',
                [$order_id, 18, 1, 'Production in progress', $date_add]);
            DB::table('oc_order')->where('order_id', '=', $order_id)->update(['order_status_id' => 18]);
        }

        return view('orders.customer.thankyou');
    }
}
