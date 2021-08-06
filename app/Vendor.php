<?php

namespace App;

use App\Notifications\VendorResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Vendor extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,HasRoles;

    protected $table = 'oc_vendor';
    public $primaryKey = 'vendor_id';

    protected $guard = 'vendor';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_modified';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','telephone','display_name', 'email', 'password','birthday','identity_picture1','identity_picture2','image','fax','type','about','company', 'salt',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden  = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //public function getAuthPassword()
   // {
     //   return $this->password1;
   // }}

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendorResetPasswordNotification($token));
    }

    public function  sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function getAuthPasswordSalt()
    {
        return $this->salt;
    }

}
