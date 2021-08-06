<?php


namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;

class SupplierController extends Controller
{
    protected $vendor = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendor')->user()->vendor_id;

            return $next($request);
        });
    }

    public function supplier()
    {
        $suppliers = DB::table('supplier')
            ->where("supplier.vendor_id", $this->vendor)
            ->get();

        return view('vendor.supplier.supplier-list', [
            'suppliers' => $suppliers,
        ]);
    }

    public function showAddSupplier()
    {
        return view('vendor.supplier.supplier-add');
    }

    public function addSupplier(Request $request)
    {
        $email=$request->email;
        $vendor_id=$this->vendor;

        $validator =Validator::make($request->all(), [
            'email' => [
                'required','email','max:40',
                Rule::unique('supplier')->where(function ($query) use($email,$vendor_id) {
                    return $query->where('email', $email)
                        ->where('vendor_id',$vendor_id);
                }),
            ],
            'firstname'=>['required','max:25'],
            'lastname'=>['required','max:25'],
            ]
        );

        if($request->ajax()){
           
            if ($validator->fails())
            {
                return response()->json([
                    'errors' => $validator->getMessageBag()->toArray(),
                    ],400
                ); 
            }
            $id = DB::table('supplier')->insertGetId([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'vendor_id' => $this->vendor,
            ]);

            $result= DB::table('supplier')->where("supplier.vendor_id", $this->vendor)
            ->get();

            return response()->json(array("result"=>$result),200);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = DB::table('supplier')->insertGetId([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'vendor_id' => $this->vendor,
        ]);

        return Redirect::to(route('vendor-supplier-list'))->with('success', 'The record has been added successfully');
    }

    public function showUpdateSupplier($id)
    {
        $supplier=DB::table("supplier")->where("supplier_id",'=',$id)->first();

        return view('vendor.supplier.supplier-show',['supplier'=>$supplier]);
    }

    public function updateSupplier(Request $request,$id)
    {
        $email=$request->email;
        $vendor_id=$this->vendor;
        $validator =Validator::make($request->all(), [
            'email' => [
                'required','email','max:40',
                Rule::unique('supplier')->where(function ($query) use($email,$vendor_id,$id) {
                    return $query->where('email', $email)
                        ->where('vendor_id',$vendor_id)->where('supplier_id','<>',$id);;
                }),
            ],
            'firstname'=>['required','max:25'],
            'lastname'=>['required','max:25'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('supplier')->where("supplier_id","$id")->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ]);

        return Redirect::to(route('vendor-supplier-list'))->with('success', 'The record has been updated successfully');
    }
}
