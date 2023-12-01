<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);

        $permissions = [];
        array_push($permissions, Permission::create(['name' => 'dashboard']));
        array_push($permissions, Permission::create(['name' => 'configuracion']));
        array_push($permissions, Permission::create(['name' => 'empresa']));
        array_push($permissions, Permission::create(['name' => 'usuarios']));
        array_push($permissions, Permission::create(['name' => 'usuarios_nuevo']));
        array_push($permissions, Permission::create(['name' => 'usuarios_editar']));
        array_push($permissions, Permission::create(['name' => 'usuarios_eliminar']));
        array_push($permissions, Permission::create(['name' => 'usuarios_ver']));
        array_push($permissions, Permission::create(['name' => 'roles']));
        array_push($permissions, Permission::create(['name' => 'permisos']));
        array_push($permissions, Permission::create(['name' => 'parametros']));
        array_push($permissions, Permission::create(['name' => 'parametros_nuevo']));
        array_push($permissions, Permission::create(['name' => 'parametros_editar']));
        array_push($permissions, Permission::create(['name' => 'parametros_eliminar']));

        array_push($permissions, Permission::create(['name' => 'sale_dashboard']));
        array_push($permissions, Permission::create(['name' => 'productos']));
        array_push($permissions, Permission::create(['name' => 'productos_nuevo']));
        array_push($permissions, Permission::create(['name' => 'productos_editar']));
        array_push($permissions, Permission::create(['name' => 'productos_eliminar']));
        array_push($permissions, Permission::create(['name' => 'productos_codigoqr']));
        array_push($permissions, Permission::create(['name' => 'productos_salida']));
        array_push($permissions, Permission::create(['name' => 'productos_entrada']));
        array_push($permissions, Permission::create(['name' => 'caja_chica']));
        array_push($permissions, Permission::create(['name' => 'clientes']));
        array_push($permissions, Permission::create(['name' => 'clientes_nuevo']));
        array_push($permissions, Permission::create(['name' => 'clientes_editar']));
        array_push($permissions, Permission::create(['name' => 'clientes_eliminar']));
        array_push($permissions, Permission::create(['name' => 'proveedores']));
        array_push($permissions, Permission::create(['name' => 'proveedores_nuevo']));
        array_push($permissions, Permission::create(['name' => 'proveedores_editar']));
        array_push($permissions, Permission::create(['name' => 'proveedores_eliminar']));
        array_push($permissions, Permission::create(['name' => 'punto_ventas']));
        array_push($permissions, Permission::create(['name' => 'sale_reportes']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda_nuevo']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda_editar']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda_eliminar']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda_series']));
        array_push($permissions, Permission::create(['name' => 'sale_tienda_agregar_vendedor']));
        array_push($permissions, Permission::create(['name' => 'invo_dashboard']));
        array_push($permissions, Permission::create(['name' => 'invo_documento']));
        array_push($permissions, Permission::create(['name' => 'invo_documento_lista']));
        array_push($permissions, Permission::create(['name' => 'invo_documento_envio_sunat']));
        array_push($permissions, Permission::create(['name' => 'invo_resumenes_lista']));
        array_push($permissions, Permission::create(['name' => 'invo_comunicacion_baja']));

        array_push($permissions, Permission::create(['name' => 'blog_dashboard']));
        array_push($permissions, Permission::create(['name' => 'blog_categorias']));
        array_push($permissions, Permission::create(['name' => 'blog_categorias_nuevo']));
        array_push($permissions, Permission::create(['name' => 'blog_categorias_editar']));
        array_push($permissions, Permission::create(['name' => 'blog_categorias_eliminar']));
        array_push($permissions, Permission::create(['name' => 'blog_articulos']));
        array_push($permissions, Permission::create(['name' => 'blog_articulos_nuevo']));
        array_push($permissions, Permission::create(['name' => 'blog_articulos_editar']));
        array_push($permissions, Permission::create(['name' => 'blog_articulos_eliminar']));


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

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'local_id' => 1,
            'company_id' => 1
        ]);

        $user->assignRole('admin');
    }
}
