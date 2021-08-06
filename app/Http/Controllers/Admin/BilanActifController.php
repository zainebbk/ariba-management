<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BilanActifController extends Controller
{
    public function bilanActif()
    {
        $cpcs=DB::table('bilan_actif')->get();
        //dd($cpcs);
        return view('admin.mains-admin.muhasebe.bilan-actif.bilan-list',['cpcs'=>$cpcs]);
    }
    
    public function showAddCpc()
    {
        $cpcs=DB::table('bilan_actif')->get();
        $bilans=DB::table('bilan')->get();

        return view('admin.mains-admin.muhasebe.bilan-actif.bilan-add',['cpcs' => $cpcs,'bilans'=>$bilans]);
    }
    
    public function showUpdateBilanActif($id)
    {
        $cpc=DB::table('bilan_actif')->where('id',$id)->first();
     
        $cpc_bilans=DB::table('bilan_actif_to_bilan')->where('bilan_actif_id',$id)->get();
        
        $bilans=DB::table('bilan')->get();
    
        return view('admin.mains-admin.muhasebe.bilan-actif.bilan-show',
            ['cpc'=>$cpc,'cpc_bilans'=>$cpc_bilans,'bilans'=>$bilans]
        );
    }

    public function updateBilanActif(Request $request,$id)
    {
        DB::table('bilan_actif_to_bilan')->where('bilan_actif_id', '=', $id)->delete();
        foreach ($request->bilans as $bilan) {
            DB::table('bilan_actif_to_bilan')->insert([
                ['bilan_actif_id' => $id, 'bilan_num' => $bilan]
            ]);
        }

        return Redirect::to("admin/muhasebe/bilan-actif")->with('success', 'The record has been updated successfully');
    }
}
