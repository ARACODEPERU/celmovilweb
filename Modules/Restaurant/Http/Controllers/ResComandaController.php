<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Entities\ResCategory;
use Modules\Restaurant\Entities\ResCategoryPresentation;
use Modules\Restaurant\Entities\ResComanda;
use Modules\Restaurant\Entities\ResPresentation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ResComandaController extends Controller
{
    use ValidatesRequests;
    protected $RPTABLE;

    public function __construct()
    {
        $this->RPTABLE = env('RECORDS_PAGE_TABLE') ?? 10;
    }

    public function index()
    {
        $comandas = (new ResComanda())->newQuery();
        if (request()->has('search')) {
            $comandas->where('name', 'like', '%' . request()->input('search') . '%');
        }
        $comandas->with('category');
        $comandas->with('presentation');
        $comandas->orderBy('id', 'DESC');

        $comandas = $comandas->paginate($this->RPTABLE)->onEachSide(2);

        return Inertia::render('Restaurant::Comandas/List', [
            'comandas' => $comandas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ResCategory::with('subcategories')
            ->whereNull('category_id')
            ->where('status', true)->get();
        return Inertia::render('Restaurant::Comandas/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'          => 'required',
                'description'   => 'required',
                'image'         => 'required',
                'price'         => 'required',
                'category_id'   => 'required',
                'presentation_id' => 'required'
            ]
        );

        $comanda = ResComanda::create([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'price'         => $request->get('price'),
            'category_id'   => $request->get('category_id'),
            'presentation_id' => $request->get('presentation_id'),
            'status' => $request->get('status') ?? false
        ]);

        $path = null;
        $destination = 'uploads/comandas';
        $base64Image = $request->get('image');

        if ($base64Image) {
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
                // $original_name = strtolower(trim($file->getClientOriginalName()));
                // $file_name = time() . rand(100, 999) . $original_name;
                $original_name = strtolower(trim($file->getClientOriginalName()));
                $original_name = str_replace(" ", "_", $original_name);
                $extension = $file->getClientOriginalExtension();
                $file_name = $comanda->id . '.' . $extension;
                $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
            }
        }

        $comanda->image = $path;
        $comanda->save();
    }

    public function edit($id)
    {
        $comanda = ResComanda::find($id);

        $presentations = ResCategoryPresentation::join('res_presentations', 'presentation_id', 'res_presentations.id')
            ->select(
                'res_presentations.id',
                'res_presentations.description'
            )
            ->where('category_id', $comanda->category_id)->get();

        $categories = ResCategory::with('subcategories')
            ->whereNull('category_id')
            ->where('status', true)->get();

        return Inertia::render('Restaurant::Comandas/Edit', [
            'categories'    => $categories,
            'comanda'       => $comanda,
            'presentations' => $presentations
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
                'name'          => 'required',
                'description'   => 'required',
                'price'         => 'required',
                'category_id'   => 'required',
                'presentation_id' => 'required'
            ]
        );

        $comanda = ResComanda::find($request->get('id'));

        $comanda->update([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'price'         => $request->get('price'),
            'category_id'   => $request->get('category_id'),
            'presentation_id' => $request->get('presentation_id'),
            'status' => $request->get('status') ?? false
        ]);

        $path = null;

        $destination = 'uploads/comandas';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = $comanda->id . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $comanda->image = $path;
        }


        $comanda->save();
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
            $item = ResComanda::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Comanda eliminada correctamente';
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
