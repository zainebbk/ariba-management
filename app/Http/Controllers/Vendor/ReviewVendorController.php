<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class ReviewVendorController extends Controller
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
        $reviews = DB::table('oc_vendor_review','r')
            ->leftjoin('oc_customer','r.customer_id','oc_customer.customer_id')
            ->where("r.vendor_id", $this->vendor)
            ->select('r.*', DB::raw('CONCAT(oc_customer.firstname," ",oc_customer.lastname) as name'))
            ->get();

        return view('vendor.vendor-review.review-list', [
            'reviews' => $reviews,
        ]);
    }

}
