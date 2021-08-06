<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class CpcController extends Controller
{
    public function cpc()
    {
        $cpcs=DB::table('cpc')->get();

        return view('admin.mains-admin.muhasebe.cpc.cpc-list',['cpcs'=>$cpcs]);
    }
    
    public function showAddCpc()
    {
        $cpcs=DB::table('cpc')->get();
        $bilans=DB::table('bilan')->get();

        return view('admin.mains-admin.muhasebe.cpc.cpc-add',['cpcs' => $cpcs,'bilans'=>$bilans]);
    }
    
    public function addCpc(Request $request)
    {
         DB::table('oc_category_to_store')->insert([
            ['category_id' => $category->category_id, 'store_id' => 0]
        ]);

        return Redirect::to("admin/muhasebe")->with('success', 'The record has been added successfully');
    }

    public function showUpdateCpc($id)
    {
        $cpc=DB::table('cpc')->where('id',$id)->first();
     
        $cpc_bilans=DB::table('cpc_to_bilan')->where('cpc_id',$id)->get();
        
        $bilans=DB::table('bilan')->get();
    
        return view('admin.mains-admin.muhasebe.cpc.cpc-show',
            ['cpc'=>$cpc,'cpc_bilans'=>$cpc_bilans,'bilans'=>$bilans]
        );
    }

    public function updateCpc(Request $request,$id)
    {
        DB::table('cpc_to_bilan')->where('cpc_id', '=', $id)->delete();
        foreach ($request->bilans as $bilan) {
            DB::table('cpc_to_bilan')->insert([
                ['cpc_id' => $id, 'bilan_num' => $bilan]
            ]);
        }

        return Redirect::to("admin/muhasebe/cpc")->with('success', 'The record has been updated successfully');
    }
}
