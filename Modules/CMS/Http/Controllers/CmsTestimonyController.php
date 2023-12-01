<?php

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\CMS\Entities\CmsTestimony;
use Modules\Onlineshop\Entities\OnliItem;

class CmsTestimonyController extends Controller
{
    protected $P000009;
    protected $reg;

    public function __construct()
    {
        $vallue = Parameter::where('parameter_code', 'P000009')->value('value_default');
        $this->P000009 = $vallue ?? 1;
        $this->reg = env('RECORDS_PAGE_TABLE');
    }

    public function index()
    {
        $testimonies = (new CmsTestimony())->newQuery();
        if (request()->has('search')) {
            $testimonies->where('title', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $testimonies->orderBy($attribute, $sort_order);
        } else {
            $testimonies->latest();
        }


        $testimonies = $testimonies->paginate($this->reg)->onEachSide(2);

        return Inertia::render('CMS::Testimonies/List', [
            'testimonies' => $testimonies,
            'filters' => request()->all('search'),
            'type'  => $this->P000009
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = [];

        if ($this->P000009 == 2) {
            $items = OnliItem::select(
                'id AS value',
                'name'
            )
                ->where('entitie', 'App-Models-Product')
                ->get();
        }

        return Inertia::render('CMS::Testimonies/Create', [
            'venture'  => $this->P000009,
            'items' => $items,
            'tiny_api_key' => env('TINY_API_KEY')
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
                'item_id' => 'required',
                'title' => 'required|max:255',
                'description' => 'required',
                'image' => 'required',
                'video' => 'required'
            ],
            [
                'item_id.required' => 'el campo producto o servicio es obligatorio',
                'title.required' => 'el campo titulo es obligatorio',
                'title.max' => 'el campo titulo solo acepta 255 caracteres',
                'description.required' => 'el campo Descripción es obligatorio',
                'image.required' => 'el campo imagen es obligatorio',
                'video.required' => 'el campo vídeo es obligatorio',
            ]
        );

        $destination = 'uploads/cms/testimonies';
        $file = $request->file('image');
        $path = null;

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

            $path  = asset('storage/' . $img);
        }

        CmsTestimony::create([
            'item_id'           => $request->get('item_id'),
            'entitie'           => OnliItem::class,
            'title'             => $request->get('title'),
            'description'       => $request->get('description'),
            'image'             => $path,
            'video'             => $request->get('video'),
            'status'            => $request->get('status') ? true : false
        ]);
    }

    public function edit($id)
    {
        $items = [];

        if ($this->P000009 == 2) {
            $items = OnliItem::select(
                'id AS value',
                'name'
            )
                ->where('entitie', 'App-Models-Product')
                ->get();
        }

        return Inertia::render('CMS::Testimonies/Edit', [
            'venture'  => $this->P000009,
            'testimony' => CmsTestimony::find($id),
            'items' => $items,
            'tiny_api_key' => env('TINY_API_KEY')
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
                'item_id' => 'required',
                'title' => 'required|max:255',
                'description' => 'required',
                'video' => 'required'
            ],
            [
                'item_id.required' => 'el campo producto o servicio es obligatorio',
                'title.required' => 'el campo titulo es obligatorio',
                'title.max' => 'el campo titulo solo acepta 255 caracteres',
                'description.required' => 'el campo Descripción es obligatorio',
                'video.required' => 'el campo vídeo es obligatorio',
            ]
        );

        $testimony = CmsTestimony::find($request->get('id'));
        $testimony->item_id = $request->get('item_id');
        //$testimony->entitie = OnliItem::class;
        $testimony->title = $request->get('title');
        $testimony->description = $request->get('description');
        $testimony->video = $request->get('video');
        $testimony->status = $request->get('status') ? true : false;

        $destination = 'uploads/cms/testimonies';
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

            $testimony->image = asset('storage/' . $img);
        }

        $testimony->save();
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
            $testimony = CmsTestimony::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $testimony->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Testimonio eliminado correctamente';
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
