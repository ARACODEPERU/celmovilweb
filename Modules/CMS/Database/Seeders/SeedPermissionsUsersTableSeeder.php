<?php

namespace Modules\CMS\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedPermissionsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'webAdmin']);
        $admin = Role::find(1);

        $permissions = [];

        array_push($permissions, Permission::create(['name' => 'cms_dashboard']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_nuevo']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_editar']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_eliminar']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_seccion']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_seccion_items']));
        array_push($permissions, Permission::create(['name' => 'cms_pagina_seccion_items_delete']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion_editar']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion_items']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion_grupos']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion_nuevo']));
        array_push($permissions, Permission::create(['name' => 'cms_seccion_eliminar']));
        array_push($permissions, Permission::create(['name' => 'cms_editor']));
        array_push($permissions, Permission::create(['name' => 'cms_items']));
        array_push($permissions, Permission::create(['name' => 'cms_testimonios']));
        array_push($permissions, Permission::create(['name' => 'cms_testimonios_nuevo']));
        array_push($permissions, Permission::create(['name' => 'cms_testimonios_editar']));
        array_push($permissions, Permission::create(['name' => 'cms_testimonios_eliminar']));

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
            $admin->givePermissionTo($permission->name);
        }

        $user = User::create([
            'name' => 'webAdmin',
            'email' => 'webAdmin@gmail.com',
            'password' => Hash::make('12345678'),
            'local_id' => 1,
            'company_id' => 1
        ]);

        $user->assignRole('webAdmin');
    }
}
