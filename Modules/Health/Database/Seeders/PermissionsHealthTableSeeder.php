<?php

namespace Modules\Health\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsHealthTableSeeder extends Seeder
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

        array_push($permissions, Permission::create(['name' => 'heal_dashboard']));
        array_push($permissions, Permission::create(['name' => 'heal_pacientes_listado']));
        array_push($permissions, Permission::create(['name' => 'heal_pacientes_nuevo']));
        array_push($permissions, Permission::create(['name' => 'heal_pacientes_editar']));
        array_push($permissions, Permission::create(['name' => 'heal_pacientes_eliminar']));
        array_push($permissions, Permission::create(['name' => 'heal_codigo_cie10_listado']));
        array_push($permissions, Permission::create(['name' => 'heal_codigo_cie10_nuevo']));
        array_push($permissions, Permission::create(['name' => 'heal_codigo_cie10_editar']));
        array_push($permissions, Permission::create(['name' => 'heal_codigo_cie10_eliminar']));

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }

        // $user = User::find(1);

        // $user->assignRole('webAdmin');
    }
}
