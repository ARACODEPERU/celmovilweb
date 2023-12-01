<?php

namespace Modules\Onlineshop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OnliPermissionsTableSeeder extends Seeder
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

        array_push($permissions, Permission::create(['name' => 'onli_dashboard']));
        array_push($permissions, Permission::create(['name' => 'onli_items']));
        array_push($permissions, Permission::create(['name' => 'onli_items_nuevo']));
        array_push($permissions, Permission::create(['name' => 'onli_items_editar']));
        array_push($permissions, Permission::create(['name' => 'onli_items_eliminar']));
        array_push($permissions, Permission::create(['name' => 'onli_pedidos']));
        array_push($permissions, Permission::create(['name' => 'onli_pedidos_aprobar']));
        array_push($permissions, Permission::create(['name' => 'onli_pedidos_responder']));

        foreach ($permissions as $permission) {
            $admin->givePermissionTo($permission->name);
        }
    }
}
