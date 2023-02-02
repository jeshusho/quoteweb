<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create(['description' => 'BLOCK VW']);
        Group::create(['description' => 'BLOCK Fe']);
        Group::create(['description' => 'BIELAS']);
        Group::create(['description' => 'CIGUEÑAL']);
        Group::create(['description' => 'CULATAS']);
        Group::create(['description' => 'TORNO']);
        Group::create(['description' => 'LAVADO']);
        Group::create(['description' => 'SOLDADURA']);
    }
}
