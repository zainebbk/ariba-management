<?php

namespace App\Http\Controllers\Vendor;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $vendor = null;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->vendor=auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function Dashboard(){
       $total_employees=DB::table('vendor_employee')->where('vendor_id',$this->vendor)->get()->count();

       $new_orders=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
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

            $order_finish=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            LEFT JOIN oc_customer c on c.customer_id=o.customer_id
            where vendor_id=$this->vendor and c.trust=1 and  os.language_id=1 and os.order_status_id=5 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

            $order_total=DB::select("SELECT o.from_app as from_app,sum(vop.total) as total,count(vop.product_id) as county,o.invoice_id,
            CONCAT(o.firstname, ' ', o.lastname) AS cname,vop.order_id as order_id ,vop.date_added as date_added,os.name as
            status ,CONCAT(sa.firstname, ' ', sa.lastname) AS sname, o.payment_city
            FROM oc_vendor_order_product vop
            LEFT JOIN oc_order o ON (vop.order_id = o.order_id)
            LEFT JOIN oc_order_status os on (os.order_status_id=vop.order_status_id)
            LEFT JOIN oc_salesagent_order so on so.order_id = o.order_id
            LEFT JOIN oc_salesagent sa on so.salesagent_id = sa.salesagent_id
            LEFT JOIN oc_customer c on c.customer_id=o.customer_id
            where vendor_id=$this->vendor and c.trust=1 and  os.language_id=1 and o.order_status_id<>0 
            GROUP by o.order_id,cname,sname,order_id,from_app,date_added,os.name,o.payment_city,o.invoice_id");

            $total_products = DB::select("SELECT  p.ean,p.model,p.product_id,p.model,p.sku,p.upc,p.quantity,p.image,
            p.status,p.price,p.date_added,pd.name ,m.name as 'manufacturer',v.display_name FROM oc_product p
            LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)
            LEFT JOIN oc_vendor_to_product vp ON (p.product_id=vp.product_id)
            LEFT JOIN oc_vendor v ON (v.vendor_id=vp.vendor_id)
            LEFT JOIN oc_manufacturer m ON (m.manufacturer_id=p.manufacturer_id)
            where pd.language_id='4' And v.vendor_id=$this->vendor ORDER BY p.date_added DESC ");

            $dateS=Carbon::now();

            $dateE=Carbon::now()->subMonths(1);
            $best_sales=self::getSales($dateS,$dateE);

       return view('vendor.statistic.dashboard',[
            'total_employees'=>$total_employees,
            'new_orders'=>$new_orders,'best_sales'=>$best_sales,
            'order_finish'=>$order_finish, 'order_total'=>$order_total,
            'total_products'=>$total_products,
           ]);
    }

    public function getValueStatistics($code){

        return $result=DB::table("oc_statistics")->where('code',$code)->first()->value;

    }

    public function TopSales(Request $request){

        if($request->ajax()) {
            $dateS=Carbon::now();

        switch ($request->time) {
            case 'today':
                $dateE=Carbon::now()->subDays(1);
                $best_sales=self::getSales($dateS,$dateE);

                return view('vendor.statistic.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastweek':

               $dateE=Carbon::now()->subWeeks(1);
               $best_sales=self::getSales($dateS,$dateE);

               return view('vendor.statistic.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastmonth':

                $dateE=Carbon::now()->subMonths(1);
                $best_sales=self::getSales($dateS,$dateE);

                return view('vendor.statistic.top-sales',['best_sales'=>$best_sales]);
                break;

            case 'lastyear':

                $dateE=Carbon::now()->subYears(1);
                $best_sales=self::getSales($dateS,$dateE);

                return view('vendor.statistic.top-sales',['best_sales'=>$best_sales]);
                break;

        }
    }
}

    public function getSales($dateS,$dateE)
    {
        return $best_sales=DB::table('oc_product','p')->leftjoin('oc_product_description','p.product_id','oc_product_description.product_id')
        ->leftjoin('oc_vendor_to_product','oc_vendor_to_product.product_id','p.product_id')
        ->leftjoin('oc_vendor_order_product','p.product_id','oc_vendor_order_product.product_id')
        ->leftjoin('oc_order','oc_vendor_order_product.order_id','oc_order.order_id')
        ->where('oc_product_description.language_id',1)->where('oc_vendor_to_product.vendor_id',$this->vendor)
        ->whereBetween('oc_order.date_added',[$dateE,$dateS])
        ->select(DB::raw('SUM(oc_vendor_order_product.quantity) as sum_quantity'),'p.product_id','oc_product_description.name','p.quantity','p.image',
        DB::raw('SUM(oc_vendor_order_product.total) as sum_total'))
        ->groupby('p.product_id','oc_product_description.name','p.quantity','p.image')->orderby('sum_quantity','desc')
        ->orderby('sum_total','desc')->limit(7)->get();
    }

}
