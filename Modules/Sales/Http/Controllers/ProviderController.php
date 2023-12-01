<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProviderController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $providers = (new Person())->newQuery()->where('is_provider', true);
        if (request()->has('search')) {
            $providers->where('full_name', 'Like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $providers->orderBy($attribute, $sort_order);
        } else {
            $providers->latest();
        }

        $providers = $providers->paginate(10)->onEachSide(2);

        return Inertia::render('Sales::Providers/List', [
            'providers' => $providers,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Sales::Providers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'short_name' => 'required|unique:people,short_name',
            'description' => 'required',
            'name' => 'required|unique:people,full_name',
            'number' => 'required|numeric|unique:people,number',
            'contact_name' => 'required',
            'contact_telephone' => 'required',
        ]);
        $path = 'img/imagen-no-disponible.jpeg';
        $destination = 'uploads/providers';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }
        Person::create([
            'short_name' => $request->get('short_name'),
            'full_name'  => $request->get('name'),
            'description'  => $request->get('description'),
            'image'  => $path,
            'document_type_id' => 6,
            'number'  => $request->get('number'),
            'telephone'  => $request->get('telephone'),
            'email'  => $request->get('email'),
            'address'  => $request->get('address'),
            'is_provider' => true,
            'contact_telephone'  => $request->get('contact_telephone'),
            'contact_name'  => $request->get('contact_name'),
            'contact_email'  => $request->get('contact_email'),
            'ubigeo'  => $request->get('ubigeo'),
        ]);

        return redirect()->route('providers.create')
            ->with('message', __('Proveedor creado con éxito'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Person $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $provider)
    {
        return Inertia::render('Sales::Providers/Edit', [
            'provider' => $provider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $provider)
    {
        // dd($request->all());
        $this->validate($request, [
            'short_name' => 'required|required|unique:people,short_name,' . $provider->id,
            'description' => 'required',
            'name' => 'required',
            'number' => 'required|numeric',
            'contact_name' => 'required',
            'contact_telephone' => 'required',
        ]);

        $path = 'img/imagen-no-disponible.jpeg';
        $destination = 'uploads/providers';
        $file = $request->file('image');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }

        //dd($request->get('sale_prices'));
        if ($request->get('short_name') != $provider->short_name) {
            $this->validate($request, [
                'short_name' => 'required|unique:people,short_name'
            ]);
            $provider->update([
                'short_name' => $request->get('short_name')
            ]);
        }
        if ($request->get('name') != $provider->full_name) {
            $this->validate($request, [
                'name' => 'required|unique:people,full_name'
            ]);
            $provider->update([
                'full_name' => $request->get('name')
            ]);
        }

        if ($request->get('number') != $provider->number) {
            $this->validate($request, [
                'number' => 'required|unique:people,number'
            ]);
            $provider->update([
                'number'  => $request->get('number')
            ]);
        }

        if ($request->get('email') != $provider->email) {
            $this->validate($request, [
                'email' => 'required|unique:people,email'
            ]);
            $provider->update([
                'email'  => $request->get('email')
            ]);
        }

        $provider->update([
            'description'  => $request->get('description'),
            'image'  => $path,
            'telephone'  => $request->get('telephone'),
            'address'  => $request->get('address'),
            'contact_telephone'  => $request->get('contact_telephone'),
            'contact_name'  => $request->get('contact_name'),
            'contact_email'  => $request->get('contact_email'),
            'ubigeo'  => $request->get('ubigeo'),
        ]);

        return redirect()->route('providers.index')
            ->with('message', __('Proveedor editado con éxito'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index')
            ->with('message', __('Providero eliminado con éxito'));
    }
}
