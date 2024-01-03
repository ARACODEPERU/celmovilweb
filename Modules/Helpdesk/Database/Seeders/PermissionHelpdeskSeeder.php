<?php

namespace Modules\Helpdesk\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionHelpdeskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'help_dashboard']));
        array_push($permissions, Permission::create(['name' => 'help_tableros']));
        array_push($permissions, Permission::create(['name' => 'help_tableros_nuevo']));
        array_push($permissions, Permission::create(['name' => 'help_tableros_editar']));
        array_push($permissions, Permission::create(['name' => 'help_tableros_eliminar']));
        array_push($permissions, Permission::create(['name' => 'help_tableros_ticket']));
        array_push($permissions, Permission::create(['name' => 'help_nivel']));
        array_push($permissions, Permission::create(['name' => 'help_nivel_nuevo']));
        array_push($permissions, Permission::create(['name' => 'help_nivel_editar']));
        array_push($permissions, Permission::create(['name' => 'help_nivel_eliminar']));
        array_push($permissions, Permission::create(['name' => 'help_nivel_miembros']));
        array_push($permissions, Permission::create(['name' => 'help_incidentes']));
        array_push($permissions, Permission::create(['name' => 'help_incidentes_nuevo']));
        array_push($permissions, Permission::create(['name' => 'help_incidentes_editar']));
        array_push($permissions, Permission::create(['name' => 'help_incidentes_eliminar']));


        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
    }
}
