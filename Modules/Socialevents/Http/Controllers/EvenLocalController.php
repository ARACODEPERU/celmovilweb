<?php

namespace Modules\Socialevents\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Socialevents\Entities\EvenLocal;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvenLocalController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locales = (new EvenLocal())->newQuery();

        if (request()->has('search')) {
            $locales->where('names', 'Like', '%' . request()->input('search') . '%');
        }

        $locales = $locales->paginate(10);
        return Inertia::render('Socialevents::Local/List', [
            'locales' => $locales,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();
        return Inertia::render('Socialevents::Local/Create', [
            'ubigeo' => $ubigeo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate(
            $request,
            [
                'names'         => 'required',
                'address'       => 'required',
                'map_code'      => 'required',
                //'image1'        => 'required',
                'maximum_capacity'   => 'required'
            ]
        );

        $local = EvenLocal::create([
            'names' => $request->get('names'),
            'address' => $request->get('address'),
            'map_code' => $request->get('map_code'),
            'maximum_capacity' => $request->get('maximum_capacity'),
            'status' => $request->get('status') ? $request->get('status') : false,
            'ubigeo' => $request->get('ubigeo')
        ]);

        $path = null;
        $destination = 'uploads/eventos/locales';
        $base64Image = $request->get('image1');
        if ($base64Image) {
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0755, true);
            }
            try {
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                if (PHP_OS == 'WINNT') {
                    $tempFile = tempnam(sys_get_temp_dir(), 'img');
                } else {
                    $tempFile = tempnam('/var/www/html/img_temp', 'img');
                }
                //dd($tempFile);
                file_put_contents($tempFile, $fileData);
                $mime = mime_content_type($tempFile);

                $name = uniqid('', true) . '.' . str_replace('image/', '', $mime);
                $file = new UploadedFile(realpath($tempFile), $name, $mime, null, true);

                if ($file) {
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $local->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
            } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e) {
                dd($e->getMessage());
            }
        }

        $local->image1 = $path;
        $local->save();

        return to_route('even_local_list');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('socialevents::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();
        $local = EvenLocal::find($id);

        return Inertia::render('Socialevents::Local/Edit', [
            'ubigeo' => $ubigeo,
            'local' => $local
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'names'         => 'required',
                'address'       => 'required',
                'map_code'      => 'required',
                //'image1'        => 'required',
                'maximum_capacity'   => 'required'
            ]
        );

        $local = EvenLocal::find($request->get('id'));

        $local->update([
            'names' => $request->get('names'),
            'address' => $request->get('address'),
            'map_code' => $request->get('map_code'),
            'maximum_capacity' => $request->get('maximum_capacity'),
            'status' => $request->get('status') ? $request->get('status') : false,
            'ubigeo' => $request->get('ubigeo')
        ]);

        $path = null;
        $destination = 'uploads/eventos/locales';
        $base64Image = $request->get('image1');
        if ($base64Image) {
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0755, true);
            }
            try {
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                if (PHP_OS == 'WINNT') {
                    $tempFile = tempnam(sys_get_temp_dir(), 'img');
                } else {
                    $tempFile = tempnam('/var/www/html/img_temp', 'img');
                }

                file_put_contents($tempFile, $fileData);
                $mime = mime_content_type($tempFile);

                $name = uniqid('', true) . '.' . str_replace('image/', '', $mime);
                $file = new UploadedFile(realpath($tempFile), $name, $mime, null, true);

                if ($file) {
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $local->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
                $local->image1 = $path;
                $local->save();
            } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e) {
                dd($e->getMessage());
            }
        }
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
            $item = EvenLocal::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Local eliminada correctamente';
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
