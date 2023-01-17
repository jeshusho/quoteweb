<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Part::create(['description' => 'ANILLOS']);
        Part::create(['description' => 'ASIENTOS']);
        Part::create(['description' => 'ASIENTOS POSTIZOS']);
        Part::create(['description' => 'ASIENTOS POSTIZOS ADM/ESC']);
        Part::create(['description' => 'BIELAS (segun informe)']);
        Part::create(['description' => 'BOCINAS DE BIELAS']);
        Part::create(['description' => 'CAMISETAS']);
        Part::create(['description' => 'CARTUCHO INYECTOR C/RETEN']);
        Part::create(['description' => 'EJE COMPENSADOR']);
        Part::create(['description' => 'EJE LEVAS (segun informe)']);
        Part::create(['description' => 'ESPIGAS DE BANCADA']);
        Part::create(['description' => 'GUIAS']);
        Part::create(['description' => 'GUIAS VALVULA ADM. Y ESC.']);
        Part::create(['description' => 'GUIAS VALVULAS ADMISION']);
        Part::create(['description' => 'GUIAS VALVULAS ESCAPE']);
        Part::create(['description' => 'JGO.METALES BOMBA INYECC.']);
        Part::create(['description' => 'JUEGO DE ANILLOS']);
        Part::create(['description' => 'JUEGO DE METALES']);
        Part::create(['description' => 'JUEGO DE METALES DE BIELA']);
        Part::create(['description' => 'JUEGO DE METALES DE LEVAS']);
        Part::create(['description' => 'JUEGO DE PRECAMARAS']);
        Part::create(['description' => 'JUEGO METALES COMPENSADOR']);
        Part::create(['description' => 'JUEGO METALES DE BANCADA']);
        Part::create(['description' => 'JUEGO METALES DE BIELA']);
        Part::create(['description' => 'JUEGO PASTILLAS']);
        Part::create(['description' => 'METALES ESPACIADOR/EMPUJE']);
        Part::create(['description' => 'PINES DE PISTON']);
        Part::create(['description' => 'PINES DE PISTON (BULON)']);
        Part::create(['description' => 'PISTONES']);
        Part::create(['description' => 'RESORTES']);
        Part::create(['description' => 'SEGUROS Y RETENES VALVULA']);
        Part::create(['description' => 'VALVULAS']);
        Part::create(['description' => 'VALVULAS ADM. Y ESC.']);
        Part::create(['description' => 'VALVULAS DE ADMISION']);
        Part::create(['description' => 'VALVULAS DE ESCAPE']);     


    }
}
