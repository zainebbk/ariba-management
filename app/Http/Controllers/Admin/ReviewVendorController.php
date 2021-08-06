<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class ReviewVendorController extends Controller
{
    public function review()
    {
        $reviews = DB::table('oc_vendor_review','r')
            ->leftjoin('oc_vendor','r.vendor_id','oc_vendor.vendor_id')
            ->leftjoin('oc_customer','r.customer_id','oc_customer.customer_id')
            ->select('r.*', DB::raw('CONCAT(oc_customer.firstname," ",oc_customer.lastname) as name',
            'oc_customer.customer_id as id'),'oc_vendor.display_name as vendor_name')
            ->get();

        return view('admin.mains-admin.vendor-review.review-list', [
            'reviews' => $reviews,
        ]);
    }

    public function reviewApprove($id)
    {
        DB::table('oc_vendor_review')->where('review_id',$id)->update(['status'=>1]);
        
        return redirect()->route('review')->with("success", "The review has been approved successfully");;
    }

    public function reviewDisapprove($id)
    {
        DB::table('oc_vendor_review')->where('review_id',$id)->update(['status'=>0]);

        return redirect()->route('review')->with("success", "The review has been disapproved successfully");;
    }

}
