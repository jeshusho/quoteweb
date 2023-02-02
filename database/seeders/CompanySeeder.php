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
            'slogan' => 'Experiencia y Calidad Profesional',
            'address' => 'Jr. Aguarico 1153',
            'phone' => '331-2857',
            'departament' => 'LIMA',
            'province' => 'LIMA',
            'district' => 'Breña',
            'estatus' => 'ACTIVO',
            'condition' => 'HABIDO',
            'location' => '150105',
            'zip_code' => '15083',
        ]);
    }
}
