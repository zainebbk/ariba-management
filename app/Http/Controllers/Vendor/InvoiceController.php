<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use PDF;

class InvoiceController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function invoice()
    {
        $invoices = DB::table('oc_vendor_order_product','vop')
        ->select('oc_order.invoice_id','vendor_invoice.invoice_no')
        ->leftJoin('oc_order','vop.order_id','oc_order.order_id')
        ->leftJoin('vendor_invoice','vop.order_id','vendor_invoice.order_id')
        ->where('vendor_invoice.vendor_id',$this->vendor)
        ->where('vop.vendor_id',$this->vendor)->where('vop.order_status_id',5)
        ->groupBy('oc_order.invoice_id','vendor_invoice.invoice_no')->get();

        return view('vendor.invoice.invoice-list',['invoices'=>$invoices]);
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $search=$request->search;
            $invoices=DB::table('oc_vendor_order_product','vop')
            ->select('oc_order.invoice_id','vendor_invoice.invoice_no')
            ->leftJoin('oc_order','vop.order_id','oc_order.order_id')
            ->leftJoin('vendor_invoice','vop.order_id','vendor_invoice.order_id')
            ->where('vendor_invoice.vendor_id',$this->vendor)
            ->where('vop.vendor_id',$this->vendor)->where('vop.order_status_id',5)
            ->where(function($q)use ($search) {
                $q ->where('oc_order.invoice_id','LIKE','%'.$search."%")
                ->orWhere('vendor_invoice.invoice_no','LIKE','%'.$search."%");
            })
            ->groupBy('oc_order.invoice_id','vendor_invoice.invoice_no')->get();

            if($request->search==null)
            {
                $invoices=DB::table('oc_vendor_order_product','vop')
                ->select('oc_order.invoice_id','vendor_invoice.invoice_no')
                ->leftJoin('oc_order','vop.order_id','oc_order.order_id')
                ->leftJoin('vendor_invoice','vop.order_id','vendor_invoice.order_id')
                ->where('vop.order_status_id',5)
                ->where('vop.vendor_id',$this->vendor)
                ->where('vendor_invoice.vendor_id',$this->vendor)
                ->groupBy('oc_order.invoice_id','vendor_invoice.invoice_no')->get();
            }
            if(count($invoices)>0)
            {
                foreach ($invoices as $invoice) 
                {
                    $output.=
                    '<li class="active">'.
                        ' <a class="d-flex" target="_blank" href="'.route("vendor-invoice-show",[$invoice->invoice_id]).'">'.
                            '<img src="'.URL::asset('assets/images/files/file.png').'" alt="img" class="w-7 h-7 mr-4">'.
                            '<div class="mt-1">'.
                                '<h5 class="mb-1 font-weight-bold mt-0">Invoice  #'.str_pad($invoice->invoice_no, 4, '0', STR_PAD_LEFT).'</h5>'.
                                '<p class="mb-0 text-muted">Order Id : '.$invoice->invoice_id.'</p>'.
                            '</div>'.
                        '</a>'.
                    '</li>';
                }
            }else
            {
                $output.=
                    '<li class="active">'.
                        ' <a class="d-flex" data-toggle="tab" href="#" aria-expanded="true">'.
                            '<img src="'.URL::asset('assets/images/files/file.png').'" alt="img" class="w-7 h-7 mr-4">'.
                            '<div class="mt-1">'.
                                '<h5 class="mb-1 font-weight-bold mt-0">No results found !</h5>'.
                                '<p class="mb-0 text-muted">No order or invoice with this number</p>'.
                            '</div>'.
                        '</a>'.
                    '</li>';
            }
        }
        return Response($output);
    }
    
 
    public function showInvoice($id)
    {
        $vendor= auth()->guard('vendor')->user();

        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.invoice_id', '=', $id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        if(!$order) abort(404);

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)->where('order_id', '=', $order->order_id)
            ->where('vendor_id', '=', $this->vendor)->get();


        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
        ->where('oc_vendor_order_product.order_id', '=', $order->order_id)->where('oc_order_option.order_id',$order->order_id)->where('vendor_id', '=', $this->vendor)->get();


        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',1)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order->order_id)->where('oc_order_status.language_id', 1)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        $invoice= DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->where('order_id',$order->order_id)->first();

        return view('vendor.invoice.invoice-show', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'order_history' => $order_history,
            'vendor'=>$vendor,  'invoice'=>$invoice
        ]);
    }

    public function printInvoicePDF($id)
    {
        $vendor= auth()->guard('vendor')->user();
        $order = DB::table('oc_vendor_order_product')->leftJoin('oc_order', 'oc_vendor_order_product.order_id', 'oc_order.order_id')
            ->where('oc_vendor_order_product.vendor_id',$this->vendor)
            ->where('oc_order.invoice_id', '=', $id)
            ->leftJoin('oc_salesagent_order', 'oc_salesagent_order.order_id', 'oc_order.order_id')
            ->leftJoin('oc_salesagent', 'oc_salesagent_order.salesagent_id', 'oc_salesagent.salesagent_id')
            ->selectRaw("oc_order.*,oc_salesagent.salesagent_id  as s_id,oc_salesagent.firstname as s_firstname,oc_salesagent.lastname as s_lastname")
            ->first();

        if(!$order) abort(404);

        $order_products = DB::table('oc_vendor_order_product',"vop")
            ->leftJoin("oc_product_description","vop.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',4)->where('order_id', '=', $order->order_id)
        ->where('vendor_id', '=', $this->vendor)->get();

        $order_options = DB::table('oc_order_option')->leftJoin("oc_vendor_order_product","oc_vendor_order_product.order_product_id","oc_order_option.order_product_id")
            ->where('oc_vendor_order_product.order_id', '=', $order->order_id)->where('oc_order_option.order_id',$order->order_id)->where('vendor_id', '=', $this->vendor)->get();

        $order_history = DB::table('oc_order_vendorhistory')
            ->LeftJoin('oc_order_status', 'oc_order_status.order_status_id', "oc_order_vendorhistory.order_status_id")
            ->LeftJoin("oc_vendor_order_product", "oc_order_vendorhistory.order_product_id", "oc_vendor_order_product.order_product_id")
            ->leftJoin("oc_product_description","oc_vendor_order_product.product_id","oc_product_description.product_id")
            ->where('oc_product_description.language_id',4)
            ->where("oc_order_vendorhistory.vendor_id",$this->vendor)->where("oc_vendor_order_product.vendor_id",$this->vendor)
            ->where('oc_order_vendorhistory.order_id', '=', $order->order_id)->where('oc_order_status.language_id', 4)
            ->selectRaw("oc_order_vendorhistory.*,oc_order_status.name as status,oc_product_description.name as name")->limit(6)
            ->orderBy("date_added",'desc')->get();

        $invoice= DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->where('order_id',$order->order_id)->first();

            return view('vendor.invoice.invoice-print', [
            'order' => $order,'order_products' => $order_products,
            'order_options' => $order_options,'vendor'=>$vendor,'invoice'=>$invoice
        ]);
        ;
    }

    public function createInvoice($id){
        $invoice= DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->where('order_id',$id)->first();
        if($invoice)
            abort(404);
        else{
            $vendor=auth()->guard('vendor')->user();
            if($vendor->invoice_no!=null){
                $invoices=DB::table('vendor_invoice')->where('vendor_id',$this->vendor);
                if(count($invoices->get())>0){
                    $myInvoice=DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->orderby("invoice_no",'desc')->first();
                    $invoice_no=$myInvoice->invoice_no;
                    $invoice_no++;
                    $invoice_no=str_pad($invoice_no, 4, '0', STR_PAD_LEFT); 
                    DB::table('vendor_invoice')->insert(['order_id'=>$id,'vendor_id'=>$this->vendor,'invoice_no'=>$invoice_no]);
                }
                else{
                    $invoice_no=$vendor->invoice_no;
                    $invoice_no++;
                    $invoice_no=str_pad($invoice_no, 4, '0', STR_PAD_LEFT); 
                    DB::table('vendor_invoice')->insert(['order_id'=>$id,'vendor_id'=>$this->vendor,'invoice_no'=>$invoice_no]);
                }
            }
            else{
                $invoices=DB::table('vendor_invoice')->where('vendor_id',$this->vendor);
                if(count($invoices->get())>0){
                    $myInvoice=DB::table('vendor_invoice')->where('vendor_id',$this->vendor)->orderby("invoice_no",'desc')->first();
                    $invoice_no=$myInvoice->invoice_no;
                    $invoice_no++;
                    $invoice_no=str_pad($invoice_no, 4, '0', STR_PAD_LEFT); 
                    DB::table('vendor_invoice')->insert(['order_id'=>$id,'vendor_id'=>$this->vendor,'invoice_no'=>$invoice_no]);
                }
                else{
                    $invoice_no=str_pad(1, 4, '0', STR_PAD_LEFT); 
                    DB::table('vendor_invoice')->insert(['order_id'=>$id,'vendor_id'=>$this->vendor,'invoice_no'=>1]);
                }
            }
        }
        return redirect()->back()->withInput();
    }

}
