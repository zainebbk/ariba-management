<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='oc_product';
    public $primaryKey='product_id';

    public function category()
    {
        return $this->hasMany('App\Category', 'category_id', 'product_id');
    }
    
    public function names()
    {
        return $this->hasMany('App\ProductDescription', 'product_id', 'product_id');
    }
}
