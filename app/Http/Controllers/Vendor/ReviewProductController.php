<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class ReviewProductController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function review()
    {
        $reviews = DB::table('oc_review','r')
            ->leftjoin('oc_vendor_to_review','r.review_id','oc_vendor_to_review.review_id')
            ->leftjoin('oc_customer','r.customer_id','oc_customer.customer_id')
            ->leftjoin('oc_product_description','r.product_id','oc_product_description.product_id')
            ->where("oc_vendor_to_review.vendor_id", $this->vendor)->where('oc_product_description.language_id',1)
            ->select('r.*', DB::raw('CONCAT(oc_customer.firstname," ",oc_customer.lastname) as customer_name'),
            'oc_product_description.name as product_name')
            ->get();

        return view('vendor.product-review.review-list', [
            'reviews' => $reviews,
        ]);
    }

}
