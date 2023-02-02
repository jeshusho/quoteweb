<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
                    'parameter' => 'default_payday',
                    'value' => '15'
                ]);
        Setting::create([
                    'parameter' => 'quote_important_note_1',
                    'value' => 'Los trabajos que no se retiren después del 1 MES, se les cobrará por almacenamiento diario.'
                ]);
        Setting::create([
                    'parameter' => 'quote_important_note_2',
                    'value' => 'Por política de la empresa, no se entregan culatas armadas.'
                ]);
        Setting::create([
                    'parameter' => 'quote_important_note_3',
                    'value' => 'En caso no se ejecute el presupuesto, se cobrará un costo por evaluación/inspección.'
                ]);
        Setting::create([
                    'parameter' => 'quote_contact_consultants',
                    'value' => 'Celular: 920011728 / 955852948'
                ]);
    }
}
