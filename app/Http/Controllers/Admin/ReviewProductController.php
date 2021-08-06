<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class ReviewProductController extends Controller
{
    public function review()
    {
        $reviews = DB::table('oc_review','r')
            ->leftjoin('oc_vendor_to_product','r.product_id','oc_vendor_to_product.product_id')
            ->leftjoin('oc_vendor','oc_vendor_to_product.vendor_id','oc_vendor.vendor_id')
            ->leftjoin('oc_customer','r.customer_id','oc_customer.customer_id')
            ->leftjoin('oc_product_description','r.product_id','oc_product_description.product_id')
            ->where('oc_product_description.language_id',1)
            ->select('r.*', DB::raw('CONCAT(oc_customer.firstname," ",oc_customer.lastname) as customer_name'),
            'oc_product_description.name as product_name','oc_vendor.display_name as vendor_name','oc_vendor.vendor_id as vendor_id')
            ->get();

        return view('admin.mains-admin.product-review.review-list', [
            'reviews' => $reviews,
        ]);
    }

    public function reviewApprove($id)
    {
        DB::table('oc_review')->where('review_id',$id)->update(['status'=>1]);
        
        return redirect()->route('product-review')->with("success", "The review has been approved successfully");
    }

    public function reviewDisapprove($id)
    {
        DB::table('oc_review')->where('review_id',$id)->update(['status'=>0]);

        return redirect()->route('product-review')->with("success", "The review has been disapproved successfully");
    }

}
