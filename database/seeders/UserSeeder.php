<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([ 
            'name' => 'admin',
            'email' => 'admin@domain.com',
            'email_verified_at' => now(),
            'password' => Hash::make("Passw0rd"),
            'remember_token' => Str::random(50),
        ]);

        User::create([ 
            'name' => 'user',
            'email' => 'user@domain.com',
            'email_verified_at' => now(),
            'password' => Hash::make("Passw0rd"),
            'remember_token' => Str::random(50),
        ]);
    }
}
