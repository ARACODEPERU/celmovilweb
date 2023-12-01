<?php

namespace Modules\Onlineshop\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaCapRegistration;
use Modules\Academic\Entities\AcaStudent;
use Modules\Onlineshop\Entities\OnliItem;
use Modules\Onlineshop\Entities\OnliSale;
use Modules\Onlineshop\Entities\OnliSaleDetail;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class OnliSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sales = (new OnliSale())->newQuery();
        if (request()->has('search')) {
            $sales->whereDate('created_at', '=', request()->input('search'));
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $sales->orderBy($attribute, $sort_order);
        } else {
            $sales->latest();
        }
        $sales = $sales->with('person');
        $sales = $sales->with('details.item');
        $sales = $sales->paginate(20)->onEachSide(2);

        return Inertia::render('Onlineshop::Sales/List', [
            'sales' => $sales,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('onlineshop::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request): RedirectResponse
    {
        $ids = $request->get('item_id');

        $validator = Validator::make($request->all(), [
            'names' => 'required',
            'app' => 'required',
            'apm' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users,email',
            'document_type' => 'required',
            'number' => 'required',
        ], [
            'names.required' => 'El nombre es requerido',
            'app.required' => 'El apellido paterno requerido',
            'apm.required' => 'El apellido materno requerido',
            'phone.required' => 'El teléfono es requerido',
            'email.required' => 'El email es requerido',
            'document_type.required' => 'El tipo de documento es requerido',
            'number.required' => 'El numero de documento es requerido'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $person = Person::firstOrCreate(
            [
                'document_type_id' => $request->get('document_type'),
                'number' => $request->get('number')
            ],
            [
                'description'           => 'Estudiante',
                'email'                 => $request->get('email'),
                'short_name'            => $request->get('names'),
                'full_name'             => $request->get('names') . ' ' . $request->get('app') . ' ' . $request->get('apm'),
                'telephone'             => $request->get('phone'),
                'is_client'             => true,
                'names'                 => $request->get('names'),
                'father_lastname'       => $request->get('app'),
                'mother_lastname'       => $request->get('apm')

            ]
        );

        $student = AcaStudent::create([
            'student_code'  => $request->get('number'),
            'person_id'     => $person->id
        ]);

        $user = User::firstOrCreate(
            [
                'email' => $request->get('email')
            ],
            [
                'name'          => $request->get('names'),
                'password'      => Hash::make($request->get('number')),
                'local_id'      => 1,
                'person_id'     => $person->id
            ]
        );

        $user->assignRole('Alumno');

        $sale = OnliSale::create([
            'module_name'                   => 'Academic',
            'person_id'                     => $person->id,
            'email'                         => $request->get('email'),
            'clie_full_name'                => $request->get('app') . ' ' . $request->get('apm') . ' ' . $request->get('names'),
            'identification_type'           => $request->get('document_type'),
            'identification_number'         => $request->get('number'),
            'response_status'               => 'pendiente',
        ]);

        foreach ($ids as $id) {

            $item = OnliItem::find($id);
            OnliSaleDetail::create([
                'sale_id'       => $sale->id,
                'item_id'       => $item->item_id,
                'entitie'       => $item->entitie,
                'price'         => $item->price,
                'quantity'      => 1,
                'onli_item_id'  => $id
            ]);

            AcaCapRegistration::create([
                'student_id'        => $student->id,
                'course_id'         => $item->item_id,
                'status'            => false
            ]);
        }

        return to_route('web_pagar', [
            'sale'     => $sale->id
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function getPreference($id)
    {
        //dd(env('MERCADOPAGO_TOKEN'));
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));
        try {
            $client = new PreferenceClient();
            $preference = $client->get($id);

            dd($preference);
        } catch (MPApiException $e) {

            $response = $e->getApiResponse();
            $content  = $response->getContent();

            $message = $content['message'];
            $status = $content['status'];
            $error = $content['error'];

            // Mostrar o manejar los valores obtenidos
            echo "Mensaje: " . $message . PHP_EOL;
            echo "Estado: " . $status . PHP_EOL;
            echo "Error: " . $error . PHP_EOL;
        }
    }
}
