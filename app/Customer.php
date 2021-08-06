<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='oc_customer';
    public $primaryKey='costumer_id';
    public $timestamps=true;

    protected $fillable = [

    ];
}
