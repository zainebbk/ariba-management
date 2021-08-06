<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Courier extends Authenticatable
{
    use HasApiTokens;

    protected $table='courier';
    public $primaryKey='courier_id';
    public $timestamps=true;

    protected $fillable = [
        'type',
        'transportation',
        'name',
        'address',
        'image',
        'phone',
        'whatsapp',
        'contractor',
        'status',
        'date_added',
        'date_modified'
    ];

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';

    public function orders()
    {
        return $this->hasMany('App\OrderShipment', 'courier_id')->with('order');
    }

    // public function orders_new()
    // {
    //     return $this->hasMany('App\OrderShipment', 'courier_id')->with('order');
    // }

    // public function orders_active()
    // {
    //     // 
    //     return $this->orders();
    // }

    // public function orders_completed()
    // {
    //     // only completed
    //     return $this->hasMany('App\OrderShipment', 'courier_id')->with('order');
    // }

    // public function orders_history()
    // {
    //     // where not active or new
    //     return $this->hasMany('App\OrderShipment', 'courier_id')->with('order');
    // }

    public function tours()
    {
        // where not active or new
        return $this->hasMany('App\OrderShipment', 'courier_id')->with('order');
    }
}
