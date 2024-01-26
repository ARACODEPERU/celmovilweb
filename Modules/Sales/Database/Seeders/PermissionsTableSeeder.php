<?php

namespace Modules\Sales\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        $role = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'sale_categorias']));
        array_push($permissions, Permission::create(['name' => 'sale_categorias_nuevo']));
        array_push($permissions, Permission::create(['name' => 'sale_categorias_editar']));
        array_push($permissions, Permission::create(['name' => 'sale_categorias_eliminar']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas_nuevo']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas_editar']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas_eliminar']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas_visualizar']));
        array_push($permissions, Permission::create(['name' => 'sale_marcas_agregar']));
        array_push($permissions, Permission::create(['name' => 'sale_categorias_visualizar']));
        array_push($permissions, Permission::create(['name' => 'sale_categorias_agregar']));
        array_push($permissions, Permission::create(['name' => 'sale_documento_fisico']));
        array_push($permissions, Permission::create(['name' => 'sale_documento_fisico_nuevo']));
        array_push($permissions, Permission::create(['name' => 'sale_documento_fisico_editar']));
        array_push($permissions, Permission::create(['name' => 'sale_documento_fisico_eliminar']));
        array_push($permissions, Permission::create(['name' => 'sale_servicios']));
        array_push($permissions, Permission::create(['name' => 'sale_servicios_nuevo']));
        array_push($permissions, Permission::create(['name' => 'sale_servicios_editar']));
        array_push($permissions, Permission::create(['name' => 'sale_servicios_eliminar']));
        array_push($permissions, Permission::create(['name' => 'sale_productos_importar']));

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
    }
}
