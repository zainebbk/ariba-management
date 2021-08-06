<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BilanPassifController extends Controller
{
    public function bilanPassif()
    {
        $cpcs=DB::table('bilan_passif')->get();

        return view('admin.mains-admin.muhasebe.bilan-passif.bilan-list',['cpcs'=>$cpcs]);
    }
    
    public function showAddCpc()
    {
        $cpcs=DB::table('bilan_passif')->get();
        $bilans=DB::table('bilan')->get();

        return view('admin.mains-admin.muhasebe.bilan-passif.bilan-add',['cpcs' => $cpcs,'bilans'=>$bilans]);
    }
    
    public function showUpdateBilanPassif($id)
    {
        $cpc=DB::table('bilan_passif')->where('id',$id)->first();
     
        $cpc_bilans=DB::table('bilan_passif_to_bilan')->where('bilan_passif_id',$id)->get();
        
        $bilans=DB::table('bilan')->get();
    
        return view('admin.mains-admin.muhasebe.bilan-passif.bilan-show',
            ['cpc'=>$cpc,'cpc_bilans'=>$cpc_bilans,'bilans'=>$bilans]
        );
    }

    public function updateBilanPassif(Request $request,$id)
    {
        DB::table('bilan_passif_to_bilan')->where('bilan_passif_id', '=', $id)->delete();
        foreach ($request->bilans as $bilan) {
            DB::table('bilan_passif_to_bilan')->insert([
                ['bilan_passif_id' => $id, 'bilan_num' => $bilan]
            ]);
        }

        return Redirect::to("admin/muhasebe/bilan-passif")->with('success', 'The record has been updated successfully');
    }
}
