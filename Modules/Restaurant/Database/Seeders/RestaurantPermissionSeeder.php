<?php

namespace Modules\Restaurant\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RestaurantPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'res_dashboard']));
        array_push($permissions, Permission::create(['name' => 'res_categorias']));
        array_push($permissions, Permission::create(['name' => 'res_comandas']));
        array_push($permissions, Permission::create(['name' => 'res_comandas_agregar_categoria']));
        array_push($permissions, Permission::create(['name' => 'res_comandas_nuevo']));
        array_push($permissions, Permission::create(['name' => 'res_comandas_editar']));
        array_push($permissions, Permission::create(['name' => 'res_comandas_eliminar']));
        array_push($permissions, Permission::create(['name' => 'res_menu']));
        array_push($permissions, Permission::create(['name' => 'res_menu_verimprimir']));
        array_push($permissions, Permission::create(['name' => 'res_menu_agregar_comandas']));
        array_push($permissions, Permission::create(['name' => 'res_menu_nuevo']));
        array_push($permissions, Permission::create(['name' => 'res_menu_editar']));
        array_push($permissions, Permission::create(['name' => 'res_menu_eliminar']));
        array_push($permissions, Permission::create(['name' => 'res_venta']));
        array_push($permissions, Permission::create(['name' => 'res_venta_nuevo']));
        array_push($permissions, Permission::create(['name' => 'res_venta_editar']));
        array_push($permissions, Permission::create(['name' => 'res_venta_eliminar']));
        array_push($permissions, Permission::create(['name' => 'res_reporte_venta']));

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
    }
}
