<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'company_id' => 1,
            'name' => 'Principal',
            'address' => 'JR. AGUARICO 1153',
            'departament' => 'LIMA',
            'province' => 'LIMA',
            'district' => 'BREÑA',
            'zip_code' => '15083',
            'estatus' => true,
        ]);
    }
}
