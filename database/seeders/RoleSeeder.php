<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $roles = [
        //     [
        //         'id'    => 1,
        //         'title' => 'Admin',
        //     ],
        //     [
        //         'id'    => 2,
        //         'title' => 'User',
        //     ],
        // ];

        // Role::insert($roles);
        Role::create(['title' => 'Administrador']);
        Role::create(['title' => 'Usuario']);
    }
}
