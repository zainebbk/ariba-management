<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Firewall;

class FirewallController1 extends Controller
{
    public function blacklist()
    {
        $blacklists = Firewall::allBlackList();

        return view('admin.mains-admin.firewall.blacklist',['blacklists' => $blacklists]);
    }

    public function showAdddToBlacklist()
    {
        return view('admin.mains-admin.firewall.blacklist-add');
    }

    public function addToBlacklist(Request $request)
    {
        if(Firewall::isWhitelisted($request->ip_address) || Firewall::isWhitelisted('country:'.$request->country))
        {
            return Redirect::route("blacklist-list")->with('error', 'The record is already in the whitelist');
        }

        if($request->type=='country')
            $blacklist='country:'.$request->country;
        else
            $blacklist=$request->ip_address;

        Firewall::blacklist($blacklist);

        return Redirect::route("blacklist-list")->with('success', 'The record has been added successfully');
    }

    public function removeFromBlacklist($ip)
    {
        if (Firewall::isBlacklisted($ip)) 
        {
            Firewall::remove($ip);
        }

        return Redirect::route("blacklist-list")->with('success', 'The record has been removed successfully');
    }

    //Whitelist
    public function whitelist()
    {
        $blacklists = Firewall::allWhiteList();

        return view('admin.mains-admin.firewall.whitelist',['blacklists' => $blacklists]);
    }

    public function showAdddToWhitelist()
    {
        return view('admin.mains-admin.firewall.whitelist-add');
    }

    public function addToWhitelist(Request $request)
    {
        if(Firewall::isBlacklisted($request->ip_address) || Firewall::isBlacklisted('country:'.$request->country))
        {
            return Redirect::route("whitelist-list")->with('error', 'The record is already in the blacklist');
        }

        if($request->type=='country')
            $blacklist='country:'.$request->country;
        else
            $blacklist=$request->ip_address;

        Firewall::whitelist($blacklist);

        return Redirect::route("whitelist-list")->with('success', 'The record has been added successfully');
    }

    public function removeFromWhitelist($ip)
    {
        if (Firewall::isWhitelisted($ip)) 
        {
            Firewall::remove($ip);
        }

        return Redirect::route("whitelist-list")->with('success', 'The record has been removed successfully');
    }
}
