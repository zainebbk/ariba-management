<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function Dashboard(){
       $online=DB::select("SELECT co.ip, co.customer_id, co.url, co.referer, co.date_added FROM oc_customer_online co LEFT JOIN oc_customer c ON (co.customer_id = c.customer_id)  ORDER BY co.date_added DESC");
       $new_sales_agent=DB::table('oc_salesagent')->where('status',0)->where("approved",'=',0)->get()->count();
       $new_vendors=DB::table('oc_vendor')->where('status',0)->where("approved",'=',0)->get()->count();

       $new_order=DB::table('oc_order')->where('order_status_id',1)->get()->count();
       $order_compeleted=DB::table('oc_order')->where("order_status_id",5)->get();
       $order_sale=self::getValueStatistics("order_sale");
       $order_complete=self::getValueStatistics('order_complete');
       $out_of_stock=self::getValueStatistics('product');

       $total_customer=DB::table('oc_customer')->get()->count();
       $total_employee=DB::table('employee')->get()->count();
       $total_company=DB::table('company')->get()->count();
       $total_product=DB::table('oc_product')->get()->count();
       $total_vendor=DB::table('oc_vendor')->get()->count();

       $best_sales=DB::select("SELECT p.product_id,pd.name,p.quantity,image, SUM(op.quantity) AS sum_quantity,
        SUM(op.total) AS sum_total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id),oc_order_product op,oc_order o
        WHERE p.product_id=op.product_id AND o.order_id=op.order_id  and o.date_added BETWEEN (NOW() - INTERVAL 1 Year) AND NOW() AND  pd.language_id='1'
        GROUP BY `product_id` ,pd.name,p.quantity,image
        ORDER BY sum_quantity DESC LIMIT 7");

       return view('admin.mains-admin.statistics.dashboard',[
           'online'=>$online,
           'order_sale'=>$order_sale,
           'order_complete'=>$order_complete,
           'out_of_stock'=>$out_of_stock,
           'new_sales_agent'=>$new_sales_agent,
           'new_vendors'=>$new_vendors,
           'new_order'=>$new_order,
           'order_compeleted'=>$order_compeleted,
           'total_customer'=>$total_customer,
           'total_employee'=>$total_employee,
           'total_company'=>$total_company,
           'total_product'=>$total_product,
           'total_vendor'=>$total_vendor,
           'best_sales'=>$best_sales,
           ]);
    }
    public function getValueStatistics($code){

        return $result=DB::table("oc_statistics")->where('code',$code)->first()->value;

    }

    public function getOnlineCustomers()
    {
        $onlines=DB::table('oc_customer_online','co')
        ->leftjoin("oc_customer",'co.customer_id','oc_customer.customer_id')
        ->select('co.*',DB::raw('CONCAT(oc_customer.firstname," ",oc_customer.lastname) as fullname'))
        ->orderby('co.date_added')->get();

        //dd($onlines);
        return view('admin.mains-admin.statistics.online-customer',[
            'onlines'=>$onlines,
        ]);
    }

    public function TopSales(Request $request){

        if($request->ajax()) {
        switch ($request->time) {

            case 'today':

                $best_sales=DB::select("SELECT p.product_id,pd.name,p.quantity,image, SUM(op.quantity) AS sum_quantity,
                SUM(op.total) AS sum_total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id),oc_order_product op,oc_order o
                WHERE p.product_id=op.product_id AND o.order_id=op.order_id  and o.date_added BETWEEN (NOW() - INTERVAL 1 DAY) AND NOW() AND  pd.language_id='1'
                GROUP BY `product_id` ,pd.name,p.quantity,image
                ORDER BY sum_quantity DESC LIMIT 7");

                return view('admin.mains-admin.statistics.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastweek':

                $best_sales=DB::select("SELECT p.product_id,pd.name,p.quantity,image, SUM(op.quantity) AS sum_quantity,
                SUM(op.total) AS sum_total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id),oc_order_product op,oc_order o
                WHERE p.product_id=op.product_id AND o.order_id=op.order_id  and o.date_added BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW() AND  pd.language_id='1'
                GROUP BY `product_id` ,pd.name,p.quantity,image
                ORDER BY sum_quantity DESC LIMIT 7");

               return view('admin.mains-admin.statistics.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastmonth':

                $best_sales=DB::select("SELECT p.product_id,pd.name,p.quantity,image, SUM(op.quantity) AS sum_quantity,
                SUM(op.total) AS sum_total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id),oc_order_product op,oc_order o
                WHERE p.product_id=op.product_id AND o.order_id=op.order_id  and o.date_added BETWEEN (NOW() - INTERVAL 1 MONTH) AND NOW() AND  pd.language_id='1'
                GROUP BY `product_id` ,pd.name,p.quantity,image
                ORDER BY sum_quantity DESC LIMIT 7");

                return view('admin.mains-admin.statistics.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastyear':

                $best_sales=DB::select("SELECT p.product_id,pd.name,p.quantity,image, SUM(op.quantity) AS sum_quantity,
                SUM(op.total) AS sum_total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id),oc_order_product op,oc_order o
                WHERE p.product_id=op.product_id AND o.order_id=op.order_id  and o.date_added BETWEEN (NOW() - INTERVAL 1 Year) AND NOW() AND  pd.language_id='1'
                GROUP BY `product_id` ,pd.name,p.quantity,image
                ORDER BY sum_quantity DESC LIMIT 7");

                return view('admin.mains-admin.statistics.top-sales',['best_sales'=>$best_sales]);
                break;

        }
    }
}

}
