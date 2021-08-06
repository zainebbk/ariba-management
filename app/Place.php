<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table='place';
    public $primaryKey='place_id';

    public function depot()
    {
        return $this->hasMany('App\DepotPlace', 'depot_id', 'place_id');
    }

    
}

