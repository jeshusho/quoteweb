<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       

        // DB::table('personal_access_tokens')->insert([
        //     'tokenable_type' => 'App\Models\User',
        //     'tokenable_id' => 1,
        //     'name' => 'rest',
        //     'token' => 'd536611b9f2e5353de56b67e9541653faa0b4d81d11ef47b0fd90aaaf3018e49',
        //     'abilities' => '["read"]',
        // ]);
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            ExchangeSeeder::class,
            CompanySeeder::class,
            StoreSeeder::class,
            CustomerSeeder::class,
            GroupSeeder::class,
            ServiceSeeder::class,
            PartSeeder::class,
            ServicePartSeeder::class,
            ContactSeeder::class,
            CarSeeder::class,
            SettingSeeder::class,
            CountrySeeder::class,
            DepartmentSeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
        ]);
    }
}
