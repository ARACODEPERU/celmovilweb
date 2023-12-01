<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\Expense;
use App\Models\LocalSale;
use App\Models\PettyCash;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PettyCashController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $pettycashes = (new PettyCash())->newQuery();

        if (request()->has('search')) {
            $search = request()->input('search');
            if ($search['date_start'] && $search['date_end']) {
                $pettycashes->whereBetween('date_opening', [$search['date_start'], $search['date_end']]);
            } else if ($search['date_start']) {
                $pettycashes->whereDate('date_opening', $search['date_start'])->get();
            }
        }
        // if (request()->query('sort')) {
        //     $attribute = request()->query('sort');
        //     $sort_order = 'ASC';
        //     if (strncmp($attribute, '-', 1) === 0) {
        //         $sort_order = 'DESC';
        //         $attribute = substr($attribute, 1);
        //     }
        //     $pettycashes->orderBy('petty_cashes.' . $attribute, $sort_order);
        // } else {
        //     $pettycashes->latest();
        // }

        $pettycashes = $pettycashes->join('users', 'petty_cashes.user_id', 'users.id')
            ->leftJoin('expenses', 'petty_cashes.id', 'expenses.petty_cash_id')
            ->select(
                'petty_cashes.id',
                'petty_cashes.date_opening',
                'petty_cashes.time_opening',
                'petty_cashes.date_closed',
                'petty_cashes.time_closed',
                'petty_cashes.beginning_balance',
                'petty_cashes.final_balance',
                'petty_cashes.income',
                'petty_cashes.state',
                'petty_cashes.reference_number',
                'petty_cashes.local_sale_id',
                'petty_cashes.seller_name',
                'users.name AS name_user',
                DB::raw('sum(expenses.amount) AS expenses')
            )
            ->groupBy(
                'petty_cashes.id',
                'petty_cashes.date_opening',
                'petty_cashes.time_opening',
                'petty_cashes.date_closed',
                'petty_cashes.time_closed',
                'petty_cashes.beginning_balance',
                'petty_cashes.final_balance',
                'petty_cashes.income',
                'petty_cashes.state',
                'petty_cashes.reference_number',
                'petty_cashes.local_sale_id',
                'petty_cashes.seller_name',
                'users.name'
            )
            ->where(function ($query) {
                if (!Auth::user()->hasRole('admin')) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->orderBy('petty_cashes.created_at', 'DESC')
            ->paginate(10)
            ->onEachSide(2);



        return Inertia::render('Sales::Pettycashes/List', [
            'pettycashes' => $pettycashes,
            'filters' => request()->all('search'),
            'locals' => LocalSale::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'local_id' => 'required',
        ]);

        PettyCash::create([
            'user_id' => Auth::id(),
            'date_opening' => Carbon::now()->format('Y-m-d'),
            'time_opening' => date('H:i:s'),
            'seller_name' => $request->input('seller_name'),
            'beginning_balance' => $request->input('starting_amount'),
            'state' => '1',
            'local_sale_id' => $request->input('local_id'),
        ]);

        return redirect()->route('pettycash.index')
            ->with('message', __('Caja Chica creado con éxito'));
    }

    public function update(Request $request, PettyCash $pettycash)
    {
        $this->validate($request, [
            'local_id' => 'required',
        ]);

        $pettycash->update([
            'user_id' => Auth::id(),
            'seller_name' => $request->input('seller_name'),
            'beginning_balance' => $request->input('starting_amount'),
            'local_sale_id' => $request->input('local_id'),
        ]);

        return redirect()->route('pettycash.index')
            ->with('message', __('Caja Chica editada con éxito'));
    }

    public function store_expense(Request $request)
    {
        $this->validate($request, [
            'amount' => 'numeric|required',
            'description' => 'required',
        ], [
            'amount.numeric' => 'Ingrese un monto valido ejem. "2.50"',
            'amount.required', 'description.required' => 'Este Campos es Obligatorio',
        ]);
        $petty_cash_id = $request->get('petty_cash_id');
        $amount = $request->get('amount');
        $description = $request->get('description');
        $document = $request->get('document');
        try {
            Expense::create([
                'amount' => $amount,
                'description' => $description,
                'document' => $document,
                'petty_cash_id' => $petty_cash_id,
            ]);
        } catch (Exception $e) {
            return redirect()->route('pettycash.index');
        }
    }
    public function destroy($id)
    {
        $pettycash = PettyCash::find($id);
        if ($pettycash->income == 0) {
            $pettycash->delete();
            return redirect()->route('pettycash.index')
                ->with('message', __('Caja Chica eliminado con éxito'));
        }
    }

    public function close_petty($petty_id)
    {
        $v = PettyCash::find($petty_id)->state;
        if ($v) {
            try {
                $amount = Sale::where('petty_cash_id', $petty_id)->where('status', "=", 1)->sum('total');
                $expenses = Expense::where('petty_cash_id', $petty_id)->selectRaw('sum(amount) as expenses')->first()->expenses;
                PettyCash::where('id', $petty_id)->update([
                    'state' => false,
                    'date_closed' => Carbon::now()->format('Y-m-d'),
                    'time_closed' => date('H:i:s'),
                    'final_balance' => PettyCash::where('id', $petty_id)->select('beginning_balance')->first()->beginning_balance + $amount - $expenses,
                    'income' => $amount
                ]);
                return true;
            } catch (Exception $e) {
                return "<script>console.log(" . $e->getMessage() . ");</script>";
            }
        }
    }
}
