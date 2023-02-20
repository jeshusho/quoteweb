<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return ( substr($permission->title, 0, 5) != 'user_'
                    && substr($permission->title, 0, 8) != 'service_'
                    && substr($permission->title, 0, 5) != 'part_'
                    && substr($permission->title, 0, 6) != 'group_'
                    && substr($permission->title, 0, 9) != 'exchange_'
                    && substr($permission->title, 0, 11) != 'customer_d_'
                    );
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
