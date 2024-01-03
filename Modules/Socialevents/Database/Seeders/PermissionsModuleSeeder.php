<?php

namespace Modules\Socialevents\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'even_dashboard']));
        array_push($permissions, Permission::create(['name' => 'even_categoria_listado']));
        array_push($permissions, Permission::create(['name' => 'even_categoria_nuevo']));
        array_push($permissions, Permission::create(['name' => 'even_categoria_editar']));
        array_push($permissions, Permission::create(['name' => 'even_categoria_eliminar']));
        array_push($permissions, Permission::create(['name' => 'even_local_listado']));
        array_push($permissions, Permission::create(['name' => 'even_local_nuevo']));
        array_push($permissions, Permission::create(['name' => 'even_local_editar']));
        array_push($permissions, Permission::create(['name' => 'even_local_eliminar']));
        array_push($permissions, Permission::create(['name' => 'even_evento_listado']));
        array_push($permissions, Permission::create(['name' => 'even_evento_nuevo']));
        array_push($permissions, Permission::create(['name' => 'even_evento_editar']));
        array_push($permissions, Permission::create(['name' => 'even_evento_eliminar']));
        array_push($permissions, Permission::create(['name' => 'even_evento_precios']));
        array_push($permissions, Permission::create(['name' => 'even_ventas_listado']));
        array_push($permissions, Permission::create(['name' => 'even_ventas_editar']));
        array_push($permissions, Permission::create(['name' => 'even_ventas_nuevo']));
        array_push($permissions, Permission::create(['name' => 'even_ventas_eliminar']));

        foreach ($permissions as $permission) {
            $admin->givePermissionTo($permission->name);
        }
    }
}
