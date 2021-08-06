<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='oc_order';
    public $primaryKey='order_id';
    public $timestamps=true;

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';

    // public function courier() {
    //     return $this->belongsTo('App\Courier', 'courier_id');
    // }

    // public function order() {
    //     return $this->belongsTo('App\Order', 'order_id');
    // } 
}
