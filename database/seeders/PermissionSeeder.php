<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $permissions = [
        //     [
        //         'id'    => 1,
        //         'title' => 'user_access',
        //     ],
        //     [
        //         'id'    => 2,
        //         'title' => 'task_access',
        //     ],
        // ];

        // Permission::insert($permissions);
        Permission::create(['title' => 'user_access']);
        Permission::create(['title' => 'service_access']);
        Permission::create(['title' => 'part_access']);
        Permission::create(['title' => 'group_access']);
        Permission::create(['title' => 'quote_access']);
        Permission::create(['title' => 'exchange_access']);
        Permission::create(['title' => 'customer_d_access']);
        Permission::create(['title' => 'customer_cu_access']);
    }
}
