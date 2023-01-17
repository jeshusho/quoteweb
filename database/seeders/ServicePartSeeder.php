<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_part')->insert(['service_id' => 53, 'part_id' => 1, 'part_qty' => 1, 'measure' => '225']);
        DB::table('service_part')->insert(['service_id' => 150, 'part_id' => 2, 'part_qty' => null, 'measure' => '541']);
        DB::table('service_part')->insert(['service_id' => 152, 'part_id' => 3, 'part_qty' => null, 'measure' => '543']);
        DB::table('service_part')->insert(['service_id' => 158, 'part_id' => 4, 'part_qty' => null, 'measure' => '549']);
        DB::table('service_part')->insert(['service_id' => 73, 'part_id' => 5, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 77, 'part_id' => 5, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 72, 'part_id' => 6, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 47, 'part_id' => 7, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 50, 'part_id' => 7, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 54, 'part_id' => 7, 'part_qty' => null, 'measure' => '226']);
        DB::table('service_part')->insert(['service_id' => 153, 'part_id' => 8, 'part_qty' => null, 'measure' => '544']);
        DB::table('service_part')->insert(['service_id' => 38, 'part_id' => 9, 'part_qty' => 1, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 37, 'part_id' => 10, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 6, 'part_id' => 11, 'part_qty' => 5, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 149, 'part_id' => 12, 'part_qty' => null, 'measure' => '540']);
        DB::table('service_part')->insert(['service_id' => 157, 'part_id' => 13, 'part_qty' => null, 'measure' => '548']);
        DB::table('service_part')->insert(['service_id' => 118, 'part_id' => 14, 'part_qty' => null, 'measure' => '503']);
        DB::table('service_part')->insert(['service_id' => 119, 'part_id' => 15, 'part_qty' => null, 'measure' => '504']);
        DB::table('service_part')->insert(['service_id' => 58, 'part_id' => 16, 'part_qty' => 1, 'measure' => '230']);
        DB::table('service_part')->insert(['service_id' => 30, 'part_id' => 17, 'part_qty' => null, 'measure' => '201']);
        DB::table('service_part')->insert(['service_id' => 31, 'part_id' => 17, 'part_qty' => null, 'measure' => '202']);
        DB::table('service_part')->insert(['service_id' => 32, 'part_id' => 17, 'part_qty' => null, 'measure' => '203']);
        DB::table('service_part')->insert(['service_id' => 169, 'part_id' => 18, 'part_qty' => null, 'measure' => null]);
        DB::table('service_part')->insert(['service_id' => 35, 'part_id' => 19, 'part_qty' => 1, 'measure' => '401']);
        DB::table('service_part')->insert(['service_id' => 49, 'part_id' => 19, 'part_qty' => 1, 'measure' => '411']);
        DB::table('service_part')->insert(['service_id' => 37, 'part_id' => 20, 'part_qty' => 1, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 51, 'part_id' => 20, 'part_qty' => 1, 'measure' => null]);
        DB::table('service_part')->insert(['service_id' => 162, 'part_id' => 21, 'part_qty' => 1, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 38, 'part_id' => 22, 'part_qty' => 1, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 6, 'part_id' => 23, 'part_qty' => 1, 'measure' => '402']);
        DB::table('service_part')->insert(['service_id' => 34, 'part_id' => 23, 'part_qty' => 1, 'measure' => '402']);
        DB::table('service_part')->insert(['service_id' => 48, 'part_id' => 23, 'part_qty' => 1, 'measure' => '412']);
        DB::table('service_part')->insert(['service_id' => 7, 'part_id' => 24, 'part_qty' => 1, 'measure' => '401']);
        DB::table('service_part')->insert(['service_id' => 165, 'part_id' => 25, 'part_qty' => 1, 'measure' => null]);
        DB::table('service_part')->insert(['service_id' => 34, 'part_id' => 26, 'part_qty' => 1, 'measure' => '205']);
        DB::table('service_part')->insert(['service_id' => 48, 'part_id' => 26, 'part_qty' => 1, 'measure' => '220']);
        DB::table('service_part')->insert(['service_id' => 36, 'part_id' => 27, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 72, 'part_id' => 28, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 30, 'part_id' => 29, 'part_qty' => null, 'measure' => '201']);
        DB::table('service_part')->insert(['service_id' => 31, 'part_id' => 29, 'part_qty' => null, 'measure' => '202']);
        DB::table('service_part')->insert(['service_id' => 32, 'part_id' => 29, 'part_qty' => null, 'measure' => '203']);
        DB::table('service_part')->insert(['service_id' => 53, 'part_id' => 29, 'part_qty' => 1, 'measure' => '225']);
        DB::table('service_part')->insert(['service_id' => 167, 'part_id' => 30, 'part_qty' => 1, 'measure' => null]);
        DB::table('service_part')->insert(['service_id' => 167, 'part_id' => 31, 'part_qty' => 1, 'measure' => null]);
        DB::table('service_part')->insert(['service_id' => 148, 'part_id' => 32, 'part_qty' => null, 'measure' => 'STD']);
        DB::table('service_part')->insert(['service_id' => 156, 'part_id' => 33, 'part_qty' => null, 'measure' => '547']);
        DB::table('service_part')->insert(['service_id' => 116, 'part_id' => 34, 'part_qty' => null, 'measure' => '501']);
        DB::table('service_part')->insert(['service_id' => 117, 'part_id' => 35, 'part_qty' => null, 'measure' => '502']);
    }
}
