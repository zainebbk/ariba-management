<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CategoryDescription extends Model
{
    protected $table='oc_category_description';
    public $timestamps=false;
    //public $primaryKey='category_id';

    protected $fillable = [
        'category_id','language_id','name','description','meta_title','meta_description','meta_keyword'
    ];

    public function category()
    {
        return $this->hasOne('App\category','id_category','category_id');
    }
}
