<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Restaurant\Entities\ResCategory;
use Modules\Restaurant\Entities\ResComanda;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurant\Entities\ResSale;
use Modules\Restaurant\Entities\ResSaleDetail;

class ResSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Restaurant::Sales/List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Person::where('is_client', true)->get();
        $comandas = ResCategory::with('subcategories.comandas.presentation')
            ->with('comandas.presentation')
            ->whereNull('category_id')
            ->get();
        $paymentMethods = PaymentMethod::all();

        return Inertia::render('Restaurant::Sales/Create', [
            'clients'   => $clients,
            'comandas'  => $comandas,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $success = false;
        $message = null;

        $client_id = $request->get('client_id');
        $total = $request->get('total');
        $comandas = $request->get('comandas');
        $payments = $request->get('payments');

        $tt = 0;

        foreach ($payments  as  $payment) {
            $tt = $tt + $payment['amount'];
        }

        if ($total <> $tt) {
            $success = false;
            $message = 'El total de venta no coincide con el total de los pagos';
        } else {
            $sale = ResSale::create([
                'sale_date' => Carbon::now()->format('Y-m-d'),
                'sale_hour' => Carbon::now()->format('H:i:s'),
                'user_id'   => Auth::id(),
                'person_id' => $client_id,
                'local_id'  => Auth::user()->local_id,
                'total'     => $total,
                'payments'  => json_encode($payments)
            ]);

            foreach ($comandas  as  $comanda) {
                ResSaleDetail::create([
                    'sale_id'       => $sale->id,
                    'comanda_id'    => $comanda['id'],
                    'quantity'      => $comanda['quantity'],
                    'price'         => $comanda['price']
                ]);
            }
            $success = true;
            $message = 'Cobro registrada  con éxito';
        }



        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('restaurant::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('restaurant::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
