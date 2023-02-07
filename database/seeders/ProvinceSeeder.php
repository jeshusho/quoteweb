<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
            ['id' => '0101', 'description' => 'Chachapoyas', 'department_id' => '01'],
            ['id' => '0102', 'description' => 'Bagua', 'department_id' => '01'],
            ['id' => '0103', 'description' => 'Bongará', 'department_id' => '01'],
            ['id' => '0104', 'description' => 'Condorcanqui', 'department_id' => '01'],
            ['id' => '0105', 'description' => 'Luya', 'department_id' => '01'],
            ['id' => '0106', 'description' => 'Rodríguez de Mendoza', 'department_id' => '01'],
            ['id' => '0107', 'description' => 'Utcubamba', 'department_id' => '01'],
            ['id' => '0201', 'description' => 'Huaraz', 'department_id' => '02'],
            ['id' => '0202', 'description' => 'Aija', 'department_id' => '02'],
            ['id' => '0203', 'description' => 'Antonio Raymondi', 'department_id' => '02'],
            ['id' => '0204', 'description' => 'Asunción', 'department_id' => '02'],
            ['id' => '0205', 'description' => 'Bolognesi', 'department_id' => '02'],
            ['id' => '0206', 'description' => 'Carhuaz', 'department_id' => '02'],
            ['id' => '0207', 'description' => 'Carlos Fermín Fitzcarrald', 'department_id' => '02'],
            ['id' => '0208', 'description' => 'Casma', 'department_id' => '02'],
            ['id' => '0209', 'description' => 'Corongo', 'department_id' => '02'],
            ['id' => '0210', 'description' => 'Huari', 'department_id' => '02'],
            ['id' => '0211', 'description' => 'Huarmey', 'department_id' => '02'],
            ['id' => '0212', 'description' => 'Huaylas', 'department_id' => '02'],
            ['id' => '0213', 'description' => 'Mariscal Luzuriaga', 'department_id' => '02'],
            ['id' => '0214', 'description' => 'Ocros', 'department_id' => '02'],
            ['id' => '0215', 'description' => 'Pallasca', 'department_id' => '02'],
            ['id' => '0216', 'description' => 'Pomabamba', 'department_id' => '02'],
            ['id' => '0217', 'description' => 'Recuay', 'department_id' => '02'],
            ['id' => '0218', 'description' => 'Santa', 'department_id' => '02'],
            ['id' => '0219', 'description' => 'Sihuas', 'department_id' => '02'],
            ['id' => '0220', 'description' => 'Yungay', 'department_id' => '02'],
            ['id' => '0301', 'description' => 'Abancay', 'department_id' => '03'],
            ['id' => '0302', 'description' => 'Andahuaylas', 'department_id' => '03'],
            ['id' => '0303', 'description' => 'Antabamba', 'department_id' => '03'],
            ['id' => '0304', 'description' => 'Aymaraes', 'department_id' => '03'],
            ['id' => '0305', 'description' => 'Cotabambas', 'department_id' => '03'],
            ['id' => '0306', 'description' => 'Chincheros', 'department_id' => '03'],
            ['id' => '0307', 'description' => 'Grau', 'department_id' => '03'],
            ['id' => '0401', 'description' => 'Arequipa', 'department_id' => '04'],
            ['id' => '0402', 'description' => 'Camaná', 'department_id' => '04'],
            ['id' => '0403', 'description' => 'Caravelí', 'department_id' => '04'],
            ['id' => '0404', 'description' => 'Castilla', 'department_id' => '04'],
            ['id' => '0405', 'description' => 'Caylloma', 'department_id' => '04'],
            ['id' => '0406', 'description' => 'Condesuyos', 'department_id' => '04'],
            ['id' => '0407', 'description' => 'Islay', 'department_id' => '04'],
            ['id' => '0408', 'description' => 'La Uniòn', 'department_id' => '04'],
            ['id' => '0501', 'description' => 'Huamanga', 'department_id' => '05'],
            ['id' => '0502', 'description' => 'Cangallo', 'department_id' => '05'],
            ['id' => '0503', 'description' => 'Huanca Sancos', 'department_id' => '05'],
            ['id' => '0504', 'description' => 'Huanta', 'department_id' => '05'],
            ['id' => '0505', 'description' => 'La Mar', 'department_id' => '05'],
            ['id' => '0506', 'description' => 'Lucanas', 'department_id' => '05'],
            ['id' => '0507', 'description' => 'Parinacochas', 'department_id' => '05'],
            ['id' => '0508', 'description' => 'Pàucar del Sara Sara', 'department_id' => '05'],
            ['id' => '0509', 'description' => 'Sucre', 'department_id' => '05'],
            ['id' => '0510', 'description' => 'Víctor Fajardo', 'department_id' => '05'],
            ['id' => '0511', 'description' => 'Vilcas Huamán', 'department_id' => '05'],
            ['id' => '0601', 'description' => 'Cajamarca', 'department_id' => '06'],
            ['id' => '0602', 'description' => 'Cajabamba', 'department_id' => '06'],
            ['id' => '0603', 'description' => 'Celendín', 'department_id' => '06'],
            ['id' => '0604', 'description' => 'Chota', 'department_id' => '06'],
            ['id' => '0605', 'description' => 'Contumazá', 'department_id' => '06'],
            ['id' => '0606', 'description' => 'Cutervo', 'department_id' => '06'],
            ['id' => '0607', 'description' => 'Hualgayoc', 'department_id' => '06'],
            ['id' => '0608', 'description' => 'Jaén', 'department_id' => '06'],
            ['id' => '0609', 'description' => 'San Ignacio', 'department_id' => '06'],
            ['id' => '0610', 'description' => 'San Marcos', 'department_id' => '06'],
            ['id' => '0611', 'description' => 'San Miguel', 'department_id' => '06'],
            ['id' => '0612', 'description' => 'San Pablo', 'department_id' => '06'],
            ['id' => '0613', 'description' => 'Santa Cruz', 'department_id' => '06'],
            ['id' => '0701', 'description' => 'Prov. Const. del Callao', 'department_id' => '07'],
            ['id' => '0801', 'description' => 'Cusco', 'department_id' => '08'],
            ['id' => '0802', 'description' => 'Acomayo', 'department_id' => '08'],
            ['id' => '0803', 'description' => 'Anta', 'department_id' => '08'],
            ['id' => '0804', 'description' => 'Calca', 'department_id' => '08'],
            ['id' => '0805', 'description' => 'Canas', 'department_id' => '08'],
            ['id' => '0806', 'description' => 'Canchis', 'department_id' => '08'],
            ['id' => '0807', 'description' => 'Chumbivilcas', 'department_id' => '08'],
            ['id' => '0808', 'description' => 'Espinar', 'department_id' => '08'],
            ['id' => '0809', 'description' => 'La Convención', 'department_id' => '08'],
            ['id' => '0810', 'description' => 'Paruro', 'department_id' => '08'],
            ['id' => '0811', 'description' => 'Paucartambo', 'department_id' => '08'],
            ['id' => '0812', 'description' => 'Quispicanchi', 'department_id' => '08'],
            ['id' => '0813', 'description' => 'Urubamba', 'department_id' => '08'],
            ['id' => '0901', 'description' => 'Huancavelica', 'department_id' => '09'],
            ['id' => '0902', 'description' => 'Acobamba', 'department_id' => '09'],
            ['id' => '0903', 'description' => 'Angaraes', 'department_id' => '09'],
            ['id' => '0904', 'description' => 'Castrovirreyna', 'department_id' => '09'],
            ['id' => '0905', 'description' => 'Churcampa', 'department_id' => '09'],
            ['id' => '0906', 'description' => 'Huaytará', 'department_id' => '09'],
            ['id' => '0907', 'description' => 'Tayacaja', 'department_id' => '09'],
            ['id' => '1001', 'description' => 'Huánuco', 'department_id' => '10'],
            ['id' => '1002', 'description' => 'Ambo', 'department_id' => '10'],
            ['id' => '1003', 'description' => 'Dos de Mayo', 'department_id' => '10'],
            ['id' => '1004', 'description' => 'Huacaybamba', 'department_id' => '10'],
            ['id' => '1005', 'description' => 'Huamalíes', 'department_id' => '10'],
            ['id' => '1006', 'description' => 'Leoncio Prado', 'department_id' => '10'],
            ['id' => '1007', 'description' => 'Marañón', 'department_id' => '10'],
            ['id' => '1008', 'description' => 'Pachitea', 'department_id' => '10'],
            ['id' => '1009', 'description' => 'Puerto Inca', 'department_id' => '10'],
            ['id' => '1010', 'description' => 'Lauricocha', 'department_id' => '10'],
            ['id' => '1011', 'description' => 'Yarowilca', 'department_id' => '10'],
            ['id' => '1101', 'description' => 'Ica', 'department_id' => '11'],
            ['id' => '1102', 'description' => 'Chincha', 'department_id' => '11'],
            ['id' => '1103', 'description' => 'Nasca', 'department_id' => '11'],
            ['id' => '1104', 'description' => 'Palpa', 'department_id' => '11'],
            ['id' => '1105', 'description' => 'Pisco', 'department_id' => '11'],
            ['id' => '1201', 'description' => 'Huancayo', 'department_id' => '12'],
            ['id' => '1202', 'description' => 'Concepción', 'department_id' => '12'],
            ['id' => '1203', 'description' => 'Chanchamayo', 'department_id' => '12'],
            ['id' => '1204', 'description' => 'Jauja', 'department_id' => '12'],
            ['id' => '1205', 'description' => 'Junín', 'department_id' => '12'],
            ['id' => '1206', 'description' => 'Satipo', 'department_id' => '12'],
            ['id' => '1207', 'description' => 'Tarma', 'department_id' => '12'],
            ['id' => '1208', 'description' => 'Yauli', 'department_id' => '12'],
            ['id' => '1209', 'description' => 'Chupaca', 'department_id' => '12'],
            ['id' => '1301', 'description' => 'Trujillo', 'department_id' => '13'],
            ['id' => '1302', 'description' => 'Ascope', 'department_id' => '13'],
            ['id' => '1303', 'description' => 'Bolívar', 'department_id' => '13'],
            ['id' => '1304', 'description' => 'Chepén', 'department_id' => '13'],
            ['id' => '1305', 'description' => 'Julcán', 'department_id' => '13'],
            ['id' => '1306', 'description' => 'Otuzco', 'department_id' => '13'],
            ['id' => '1307', 'description' => 'Pacasmayo', 'department_id' => '13'],
            ['id' => '1308', 'description' => 'Pataz', 'department_id' => '13'],
            ['id' => '1309', 'description' => 'Sánchez Carrión', 'department_id' => '13'],
            ['id' => '1310', 'description' => 'Santiago de Chuco', 'department_id' => '13'],
            ['id' => '1311', 'description' => 'Gran Chimú', 'department_id' => '13'],
            ['id' => '1312', 'description' => 'Virú', 'department_id' => '13'],
            ['id' => '1401', 'description' => 'Chiclayo', 'department_id' => '14'],
            ['id' => '1402', 'description' => 'Ferreñafe', 'department_id' => '14'],
            ['id' => '1403', 'description' => 'Lambayeque', 'department_id' => '14'],
            ['id' => '1501', 'description' => 'Lima', 'department_id' => '15'],
            ['id' => '1502', 'description' => 'Barranca', 'department_id' => '15'],
            ['id' => '1503', 'description' => 'Cajatambo', 'department_id' => '15'],
            ['id' => '1504', 'description' => 'Canta', 'department_id' => '15'],
            ['id' => '1505', 'description' => 'Cañete', 'department_id' => '15'],
            ['id' => '1506', 'description' => 'Huaral', 'department_id' => '15'],
            ['id' => '1507', 'description' => 'Huarochirí', 'department_id' => '15'],
            ['id' => '1508', 'description' => 'Huaura', 'department_id' => '15'],
            ['id' => '1509', 'description' => 'Oyón', 'department_id' => '15'],
            ['id' => '1510', 'description' => 'Yauyos', 'department_id' => '15'],
            ['id' => '1601', 'description' => 'Maynas', 'department_id' => '16'],
            ['id' => '1602', 'description' => 'Alto Amazonas', 'department_id' => '16'],
            ['id' => '1603', 'description' => 'Loreto', 'department_id' => '16'],
            ['id' => '1604', 'description' => 'Mariscal Ramón Castilla', 'department_id' => '16'],
            ['id' => '1605', 'description' => 'Requena', 'department_id' => '16'],
            ['id' => '1606', 'description' => 'Ucayali', 'department_id' => '16'],
            ['id' => '1607', 'description' => 'Datem del Marañón', 'department_id' => '16'],
            ['id' => '1608', 'description' => 'Putumayo', 'department_id' => '16'],
            ['id' => '1701', 'description' => 'Tambopata', 'department_id' => '17'],
            ['id' => '1702', 'description' => 'Manu', 'department_id' => '17'],
            ['id' => '1703', 'description' => 'Tahuamanu', 'department_id' => '17'],
            ['id' => '1801', 'description' => 'Mariscal Nieto', 'department_id' => '18'],
            ['id' => '1802', 'description' => 'General Sánchez Cerro', 'department_id' => '18'],
            ['id' => '1803', 'description' => 'Ilo', 'department_id' => '18'],
            ['id' => '1901', 'description' => 'Pasco', 'department_id' => '19'],
            ['id' => '1902', 'description' => 'Daniel Alcides Carrión', 'department_id' => '19'],
            ['id' => '1903', 'description' => 'Oxapampa', 'department_id' => '19'],
            ['id' => '2001', 'description' => 'Piura', 'department_id' => '20'],
            ['id' => '2002', 'description' => 'Ayabaca', 'department_id' => '20'],
            ['id' => '2003', 'description' => 'Huancabamba', 'department_id' => '20'],
            ['id' => '2004', 'description' => 'Morropón', 'department_id' => '20'],
            ['id' => '2005', 'description' => 'Paita', 'department_id' => '20'],
            ['id' => '2006', 'description' => 'Sullana', 'department_id' => '20'],
            ['id' => '2007', 'description' => 'Talara', 'department_id' => '20'],
            ['id' => '2008', 'description' => 'Sechura', 'department_id' => '20'],
            ['id' => '2101', 'description' => 'Puno', 'department_id' => '21'],
            ['id' => '2102', 'description' => 'Azángaro', 'department_id' => '21'],
            ['id' => '2103', 'description' => 'Carabaya', 'department_id' => '21'],
            ['id' => '2104', 'description' => 'Chucuito', 'department_id' => '21'],
            ['id' => '2105', 'description' => 'El Collao', 'department_id' => '21'],
            ['id' => '2106', 'description' => 'Huancané', 'department_id' => '21'],
            ['id' => '2107', 'description' => 'Lampa', 'department_id' => '21'],
            ['id' => '2108', 'description' => 'Melgar', 'department_id' => '21'],
            ['id' => '2109', 'description' => 'Moho', 'department_id' => '21'],
            ['id' => '2110', 'description' => 'San Antonio de Putina', 'department_id' => '21'],
            ['id' => '2111', 'description' => 'San Román', 'department_id' => '21'],
            ['id' => '2112', 'description' => 'Sandia', 'department_id' => '21'],
            ['id' => '2113', 'description' => 'Yunguyo', 'department_id' => '21'],
            ['id' => '2201', 'description' => 'Moyobamba', 'department_id' => '22'],
            ['id' => '2202', 'description' => 'Bellavista', 'department_id' => '22'],
            ['id' => '2203', 'description' => 'El Dorado', 'department_id' => '22'],
            ['id' => '2204', 'description' => 'Huallaga', 'department_id' => '22'],
            ['id' => '2205', 'description' => 'Lamas', 'department_id' => '22'],
            ['id' => '2206', 'description' => 'Mariscal Cáceres', 'department_id' => '22'],
            ['id' => '2207', 'description' => 'Picota', 'department_id' => '22'],
            ['id' => '2208', 'description' => 'Rioja', 'department_id' => '22'],
            ['id' => '2209', 'description' => 'San Martín', 'department_id' => '22'],
            ['id' => '2210', 'description' => 'Tocache', 'department_id' => '22'],
            ['id' => '2301', 'description' => 'Tacna', 'department_id' => '23'],
            ['id' => '2302', 'description' => 'Candarave', 'department_id' => '23'],
            ['id' => '2303', 'description' => 'Jorge Basadre', 'department_id' => '23'],
            ['id' => '2304', 'description' => 'Tarata', 'department_id' => '23'],
            ['id' => '2401', 'description' => 'Tumbes', 'department_id' => '24'],
            ['id' => '2402', 'description' => 'Contralmirante Villar', 'department_id' => '24'],
            ['id' => '2403', 'description' => 'Zarumilla', 'department_id' => '24'],
            ['id' => '2501', 'description' => 'Coronel Portillo', 'department_id' => '25'],
            ['id' => '2502', 'description' => 'Atalaya', 'department_id' => '25'],
            ['id' => '2503', 'description' => 'Padre Abad', 'department_id' => '25'],
            ['id' => '2504', 'description' => 'Purús', 'department_id' => '25'],
        ]);
    }
}
