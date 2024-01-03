<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaInstitution;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

class AcaInstitutionController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutions = (new AcaInstitution())->newQuery();
        if (request()->has('search')) {
            $institutions->where('name', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $institutions->orderBy($attribute, $sort_order);
        } else {
            $institutions->latest();
        }

        $institutions = $institutions->paginate(20)->onEachSide(2);

        return Inertia::render('Academic::Institution/List', [
            'institutions' => $institutions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Academic::Institution/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required|max:300',
                'image'     => 'required|max:255',
                'address'   => 'required|max:255'
            ]
        );

        $path = null;

        $destination = 'uploads/institutions';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $img = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $img);
        }

        AcaInstitution::create([
            'name'      => $request->get('name'),
            'image'     => $path,
            'phone'     => $request->get('phone'),
            'address'   => $request->get('address'),
            'status'    => $request->get('status') ? true : false
        ]);

        return redirect()->route('aca_institutions_list')
            ->with('message', __('Institucion creado con éxito'));
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('academic::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $institution = AcaInstitution::find($id);

        return Inertia::render('Academic::Institution/Edit', [
            'institution' => $institution
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->get('id');

        $this->validate(
            $request,
            [
                'name'      => 'required|max:300',
                'address'   => 'required|max:255'
            ]
        );

        $path = null;

        $destination = 'uploads/institutions';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $img = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $img);
        }
        AcaInstitution::find($id)->update([
            'name'      => $request->get('name'),
            'image'     => $path,
            'phone'     => $request->get('phone'),
            'address'   => $request->get('address'),
            'status'    => $request->get('status') ? true : false
        ]);

        // return redirect()->route('aca_institutions_edit', $id)
        //     ->with('message', __('Institucion creado con éxito'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            // Verificamos si existe.
            $item = AcaInstitution::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Institucion eliminada correctamente';
            $success = true;
        } catch (\Exception $e) {
            // Si ocurre alguna excepción durante la transacción, hacemos rollback para deshacer cualquier cambio.
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
