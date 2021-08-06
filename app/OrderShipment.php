<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
    protected $table='order_shipment';
    public $primaryKey='shipment_id';
    public $timestamps=true;

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';

    protected $fillable = [
        'shipment_id',
        'method_shipment',
        'order_id',
        'courier_id',
        'vendor_id',
        'date_added',
        'date_modified',
        'tracking_number',
        'status'
    ];

    public function courier() {
        return $this->belongsTo('App\Courier', 'courier_id');
    }

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    } 
}
