<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PermissionController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $permissions = (new Permission())->newQuery();

        if (request()->has('search')) {
            $permissions->where('name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $permissions->orderBy($attribute, $sort_order);
        } else {
            $permissions->latest();
        }

        $permissions = $permissions->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Security::Permissions/List', [
            'permissions' => $permissions,
            'filters' => request()->all('search')
        ]);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::all();
        return Inertia::render(
            'Security::Permissions/Create',
            ['roles' => $roles]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions,name'
        ]);

        $permission = Permission::create([
            'name'       => $request->get('name'),
            'guard_name' => 'web'
        ]);

        if (!empty($request->get('roles'))) {
            $permission->assignRole($request->get('roles'));
        }

        return redirect()->route('permissions.index')
            ->with('message', 'Permiso creado con éxito.');
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        $roleHasPermissions = array_column(json_decode($permission->roles, true), 'name');
        return Inertia::render(
            'Security::Permissions/Edit',
            [
                'roles' => $roles,
                'permission' => $permission,
                'roleHasPermissions' => $roleHasPermissions,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $permission->update([
            'name' => $request->get('name'),
        ]);
        $roles = $request->get('permissions') ?? [];
        $permission->assignRole($request->get('roles'));

        return redirect()->route('permissions.edit', $permission->id)
            ->with('message', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('message', __('Permission deleted successfully'));
    }
}
