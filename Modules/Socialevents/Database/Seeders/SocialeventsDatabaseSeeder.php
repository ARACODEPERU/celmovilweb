<?php

namespace Modules\Socialevents\Database\Seeders;

use Illuminate\Database\Seeder;

class SocialeventsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PermissionsModuleSeeder::class
        ]);
    }
}
