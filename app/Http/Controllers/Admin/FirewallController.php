<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Firewall;

class FireWallController extends Controller
{
    function __construct()
    {
        
    }

    public function blacklist()
    {
        Firewall::remove('country:ma');
        $blacklists = Firewall::allBlackList();
        return view('admin.mains-admin.firewall.blacklist',['blacklists' => $blacklists]);
    }

    public function showAdddToBlacklist()
    {
        return view('admin.mains-admin.firewall.blacklist-add');
    }

    public function addToBlacklist(Request $request)
    {
        if($request->type=='country')
            $blacklist='country:'.$request->country;
        else
            $blacklist=$request->ip_address;

        Firewall::blacklist($blacklist);

        return Redirect::route("blacklist-list")->with('success', 'The record has been added successfully');
    }

    public function removeFromBlacklist($ip)
    {
        Firewall::remove($ip);

        return Redirect::route("blacklist-list")->with('success', 'The record has been removed successfully');
    }

}
