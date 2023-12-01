<?php

namespace Modules\Purchases\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'purc_dashboard']));
        array_push($permissions, Permission::create(['name' => 'purc_documentos_listado']));
        array_push($permissions, Permission::create(['name' => 'purc_documentos_nuevo']));
        array_push($permissions, Permission::create(['name' => 'purc_documentos_editar']));
        array_push($permissions, Permission::create(['name' => 'purc_documentos_eliminar']));
        array_push($permissions, Permission::create(['name' => 'purc_reporte']));

        foreach ($permissions as $permission) {
            $admin->givePermissionTo($permission->name);
        }
    }
}
