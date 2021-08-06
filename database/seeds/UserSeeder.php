<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'user-list']);
        $permission = Permission::create(['name' => 'user-edit']);
        $permission = Permission::create(['name' => 'user-create']);

        $permission = Permission::create(['name' => 'role-list']);
        $permission = Permission::create(['name' => 'role-edit']);
        $permission = Permission::create(['name' => 'role-create']);

        $permission = Permission::create(['name' => 'permission-list']);
        $permission = Permission::create(['name' => 'permission-edit']);
        $permission = Permission::create(['name' => 'permission-create']);

    }
}
