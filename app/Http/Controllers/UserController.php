<?php

namespace App\Http\Controllers;

use App\Models\LocalSale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = (new User())->newQuery();
        if (request()->has('search')) {
            $users->where('name', 'Like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $users->orderBy($attribute, $sort_order);
        } else {
            $users->latest();
        }

        $users = $users->with('tokens');
        $users = $users->paginate(10)->onEachSide(2);
        //dd($users);
        return Inertia::render('Users/List', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'establishments' => LocalSale::all(),
            'roles' => Role::all()
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            //'local_id' => 'required|unique:users,local_id',
            'local_id' => 'required',
            'name' => 'required',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name'          => $request->get('name'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('password')),
            'local_id'      => $request->get('local_id')
        ]);

        $user->assignRole($request->get('role'));

        $token = $user->createToken($request->get('email'))->plainTextToken;

        $user->api_token = $token;
        $user->save();

        return redirect()->route('users.index')
            ->with('message', __('Usuario creado con éxito'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('message', __('Usuario eliminado con éxito'));
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'establishments' => LocalSale::all(),
            'xuser' => $user,
            'xrole' => $user->getRoleNames(),
            'roles' => Role::all()
        ]);
    }
    public function update(Request $request, User $user)
    {
        if ($user->hasAnyRole(['Vendedor'])) {

            $this->validate($request, [
                'local_id' => 'required'
            ]);

            $user->local_id = $request->get('local_id');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
        ]);


        $user->syncRoles([]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->assignRole($request->get('role'));

        $user->save();

        return redirect()->route('users.edit', $user->id)
            ->with('message', __('Usuario modificado con éxito'));
    }
}
