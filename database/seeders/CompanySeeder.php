<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'ruc'               => '20000000001',
            'name'              => 'ARACODE',
            'business_name'     => 'ARACODE',
            'tradename'         => 'ARACODE',
            'fiscal_address'    => 'Av. Villa Nueva 221',
            'phone'             => '123456789',
            'representative'    => 'ARACODE',
            'email'             => 'factura@aracode.pe',
            'logo'              => '/img/logo176x32.png',
            'logo_document'     => '/img/logo176x32.png',
            'key_sunat'         => null,
            'user_sunat'        => null,
            'certificate_sunat' => null,
            'mode'              => 'demo',
            'ubigeo'            => '021801',
            'logo_negative'     => '/img/logo176x32_negativo.png',
            'logo_dark'         => '/img/logo176x32_negativo.png',
            'isotipo'           => '/img/isotipo.png',
            'isotipo_negative'  => '/img/isotipo_negativo.png',
            'isotipo_dark'      => '/img/isotipo_dark.png'
        ]);
    }
}
