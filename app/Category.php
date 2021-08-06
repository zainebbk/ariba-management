<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='oc_category';
    public $primaryKey='category_id';

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';

    public $timestamps=true;

    protected $fillable = [
        'image','parent_id','top','column','sort_order','status'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id', 'parent_id'); 
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id', 'category_id');
    }

    public function names()
    {
        return $this->hasMany('App\CategoryDescription', 'category_id', 'category_id');
    }

    public static function tree() {

        return static::where('parent_id', '=', 0)->get(); // or based on you question 0?

    }
}
