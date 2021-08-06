<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.layouts.master'], function ($view) {
            $user=Auth::user();
            $view->with('data',['user'=>$user]);
        });
        view()->composer(['admin.layouts.master-vendor'], function ($view) {
            $store_name='';
            $vendor=Auth::guard("vendor")->user();
            $store=DB::table("oc_vendor","v")->leftJoin("oc_vendor_description as vd","v.vendor_id","vd.vendor_id")->where("v.vendor_id",$vendor->vendor_id)->where("vd.language_id",1)->first();

            $view->with(['user'=>$vendor,'store_name'=>$store]);
        });
    }
}
