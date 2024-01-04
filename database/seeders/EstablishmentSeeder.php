<?php

namespace Database\Seeders;

use App\Models\LocalSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocalSale::create([
            'description'   => 'Local Principal',
            'address'       => 'Chimbote',
            'phone'         => '99999999',
            'ubigeo'        => '021801',
            'sunat_code'    => '0000'
        ]);
    }
}
