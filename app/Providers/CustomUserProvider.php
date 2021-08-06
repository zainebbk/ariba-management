<?php


namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;



class CustomUserProvider extends UserProvider {

    /**
     * Validate a user against the given credentials.
     *
     * @param  UserContract   $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract  $user, array $credentials)
    {
        $salt=$user->getAuthPasswordSalt();
        $plain=sha1($salt.sha1($salt.sha1($credentials["password"])));

        return $plain==$user->getAuthPassword();
    }
}
