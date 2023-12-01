<?php

namespace Modules\Onlineshop\Http\Controllers;

use App\Models\Parameter;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaCourse;
use Modules\Onlineshop\Entities\OnliItem;
use Modules\Onlineshop\Entities\AcaModality;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;




class OnliItemController extends Controller
{
    use ValidatesRequests;

    protected $P000009;

    public function __construct()
    {
        $vallue = Parameter::where('parameter_code', 'P000009')->value('value_default');
        $this->P000009 = $vallue ?? 1;
    }

    public function index()
    {
        $items = (new OnliItem())->newQuery();
        if (request()->has('search')) {
            $items->where('name', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $items->orderBy($attribute, $sort_order);
        } else {
            $items->latest();
        }

        $items = $items->paginate(20)->onEachSide(2);

        return Inertia::render('Onlineshop::Items/List', [
            'items' => $items,
            'filters' => request()->all('search'),
            'type'  => $this->P000009
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $courses = [];
        $courses = AcaCourse::with('category')
            ->with('modality')
            ->whereNotIn('id', function ($query) {
                $query->select('item_id')
                    ->from('onli_items');
            })
            ->get();

        $products = Product::whereNotIn('id', function ($query) {
            $query->select('item_id')
                ->from('onli_items')
                ->where('onli_items.entitie', 'App-Models-Product');
        })->get();


        return Inertia::render('Onlineshop::Items/Create', [
            'courses'   => $courses,
            'products'  => $products,
            'tiny_api_key' => env('TINY_API_KEY'),
            'type'  => $this->P000009
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'item_id'                   => 'required|unique:onli_items,item_id',
            'entitie'                   => 'required',
            'name'                      => 'required|max:255',
            ///'description'               => 'required|max:255',
            'description'               => 'required',

            'image'                     => 'required|image|mimes:jpeg,png,gif|max:2048'
        ], [
            'item_id.required' => 'Elija un Curso',
            'item_id.unique'   => 'Ya existe como item para la web',
        ]);

        if ($this->P000009 == 1) {
            $this->validate($request, [
                'category_description'      => 'required|max:255',
                'price'                     => 'required|numeric',
                //'discount'                  => 'required|max:255',
            ]);
        }

        // $path = 'img' . DIRECTORY_SEPARATOR . 'imagen-no-disponible.jpeg';
        // $destination = 'uploads' . DIRECTORY_SEPARATOR . 'products';
        $path = null;
        $destination = 'uploads/onlineshop/items';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }


        OnliItem::create([
            'item_id'                   => $request->get('item_id'),
            'entitie'                   => $request->get('entitie'),
            'category_description'      => $request->get('category_description'),
            'name'                      => $request->get('name'),
            'description'               => $request->get('description'),
            'scor'                      => 4,
            'price'                     => $request->get('price'),
            'discount'                  => $request->get('discount') ?? 0,
            'image'                     => $path,
            'status'                    => true,
            'additional'                => $request->get('additional'),
            'additional1'                => $request->get('additional1'),
            'additional2'                => $request->get('category_description')
        ]);

        return redirect()->route('onlineshop_items')
            ->with('message', __('Item creado con éxito'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('onlineshop::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $item = OnliItem::find($id);
        return Inertia::render('Onlineshop::Items/Edit', [
            'item' => $item,
            'type'  => $this->P000009,
            'tiny_api_key' => env('TINY_API_KEY'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $id = $request->get('id');

        $this->validate($request, [
            'name'                      => 'required|max:255',
            ///'description'               => 'required|max:255',
            'description'               => 'required',
            'image'                     => 'required|image|mimes:jpeg,png,gif|max:2048'
        ], [
            'item_id.required' => 'Elija un Curso',
            'item_id.unique'   => 'Ya existe como item para la web',
        ]);

        if ($this->P000009 == 1) {
            $this->validate($request, [
                'category_description'      => 'required|max:255',
                'price'                     => 'required|numeric'
            ]);
        }
        $OnliItem = OnliItem::find($id);

        $OnliItem->name = $request->get('name');
        $OnliItem->description = $request->get('description');
        $OnliItem->category_description = $request->get('category_description');
        $OnliItem->price = $request->get('price');
        $OnliItem->discount = $request->get('discount') ?? 0;
        $OnliItem->status = $request->get('status') ? true : false;
        $OnliItem->additional = $request->get('additional');
        $OnliItem->additional1 = $request->get('additional1');
        $OnliItem->additional2 = $request->get('category_description');

        // $path = 'img' . DIRECTORY_SEPARATOR . 'imagen-no-disponible.jpeg';
        // $destination = 'uploads' . DIRECTORY_SEPARATOR . 'products';
        $path = null;
        $destination = 'uploads/onlineshop/items';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $OnliItem->image = $path;
        }

        $OnliItem->save();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            // Verificamos si existe.
            $item = OnliItem::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Item eliminado correctamente';
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


    public function getItemCarrito(Request $request)
    {
        $ids = $request->get('ids');
        //dd($ids);
        $items = OnliItem::join('aca_courses', 'onli_items.item_id', '=', 'aca_courses.id')
            ->leftJoin('aca_teachers', 'aca_teachers.id', '=', 'aca_courses.teacher_id')
            ->join('people', 'people.id', '=', 'aca_teachers.person_id')
            ->join('users', 'users.person_id', '=', 'people.id')
            ->whereIn('onli_items.id', $ids)
            ->select(
                'onli_items.id as id',
                'onli_items.name as name',
                'onli_items.image as image',
                'onli_items.price as price',
                'onli_items.category_description', ////sector publico, sector empresarial .....
                'onli_items.additional as additional', ////tipo curso o diplomado
                'onli_items.additional1 as additional1', //////modalidad envivo, elearnig.presencial
                'people.names as teacher',
                'aca_teachers.id as teacher_id',
                'users.avatar as avatar',
                'onli_items.description as description'
            )
            ->get();

        $preference_id = null;
        // Verificar si se encontró el ítem
        if (count($items) > 0) {

            return response()->json([
                'items' => $items
            ]);
        } else {
            return response()->json(['error' => 'Ítem no encontrado'], 404);
        }
    }
}
