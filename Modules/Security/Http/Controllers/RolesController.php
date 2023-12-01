<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RolesController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $roles = (new Role())->newQuery();

        if (request()->has('search')) {
            $roles->where('name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $roles->orderBy($attribute, $sort_order);
        } else {
            $roles->latest();
        }

        $roles = $roles->paginate(5)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Security::Roles/List', [
            'roles' => $roles,
            'filters' => request()->all('search')
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render(
            'Security::Roles/Create',
            [
                'permissions' => $permissions,
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $role = Role::create([
            'name'       => $request->get('name'),
            'guard_name' => 'web'
        ]);

        if (!empty($request->get('permissions'))) {
            $role->givePermissionTo($request->get('permissions'));
        }

        return redirect()->route('roles.index')
            ->with('message', 'Rol creado con éxito.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $roleHasPermissions = array_column(json_decode($role->permissions, true), 'name');

        return Inertia::render('Security::Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'roleHasPermissions' => $roleHasPermissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $role->update([
            'name' => $request->get('name'),
        ]);
        $permissions = $request->get('permissions') ?? [];
        $role->syncPermissions($permissions);

        return redirect()->route('roles.edit', $role->id)
            ->with('message', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('message', __('Role deleted successfully'));
    }
}
