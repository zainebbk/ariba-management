<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRoleEmployee extends Model
{
    protected $table = 'employee_to_role';
    public $primaryKey = 'id';

    public function name()
    {
        return $this->hasOne('App\VendorRole', 'role_id', 'role_id');
    }
}
