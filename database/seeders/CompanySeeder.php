<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::Create([
            'ruc' => '20557905589',
            'name' => 'WS RECTIFICACIONES S.A.C.',
            'comercial_name' => 'WS RECTIFICACIONES S.A.C.',
            'slogan' => '',
            'address' => 'JR. AGUARICO 1153',
            'departament' => 'LIMA',
            'province' => 'LIMA',
            'district' => 'BREÑA',
            'estatus' => 'ACTIVO',
            'condition' => 'HABIDO',
            'location' => '150105',
            'zip_code' => '15083',
        ]);
    }
}
