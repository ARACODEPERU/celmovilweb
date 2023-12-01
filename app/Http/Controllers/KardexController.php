<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\KardexSize;
use App\Models\LocalSale;
use App\Models\SaleProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class KardexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $establishments = LocalSale::all();
        $local_id = request()->input('local_id');
        if ($local_id != null && $local_id != 0) {
            $kardexes = Kardex::join('products', 'kardexes.product_id', 'products.id')
                ->join('local_sales', 'kardexes.local_id', 'local_sales.id')
                ->select(
                    'products.*',
                    'local_sales.id AS local_id',
                    'local_sales.description AS local_names'
                )
                ->selectRaw('CONVERT(SUM(quantity), SIGNED INTEGER) AS kardex_stock')
                ->groupBy(
                    'products.id',
                    'local_sales.description',
                    'local_sales.id'
                )
                ->where('products.interne', '=', request()->input('search'))
                ->orWhere('products.description', 'Like', '%' . request()->input('search') . '%')
                ->where(function ($query) use ($local_id) {
                    $query->where('kardexes.local_id', $local_id);
                })
                ->orderBy('local_sales.description')
                ->paginate(20);
        } else {
            $kardexes = Kardex::join('products', 'kardexes.product_id', 'products.id')
                ->join('local_sales', 'kardexes.local_id', 'local_sales.id')
                ->select(
                    'products.*',
                    'local_sales.id AS local_id',
                    'local_sales.description AS local_names'
                )
                ->selectRaw('CONVERT(SUM(quantity), SIGNED INTEGER) AS kardex_stock')
                ->groupBy(
                    'products.id',
                    'local_sales.description',
                    'local_sales.id'
                )
                ->where('products.interne', '=', request()->input('search'))
                ->orWhere('products.description', 'Like', '%' . request()->input('search') . '%')
                ->orderBy('local_sales.description')
                ->paginate(20);
        }


        return Inertia::render('Kardex/List', [
            'establishments' => $establishments,
            'kardexes' => $kardexes,
            'local_id' => $local_id,
            'filters' => request()->all('search')
        ]);
    }

    public function kardexDeailsSises(Request $request)
    {
        $kardex_sizes = KardexSize::select(
            'kardex_sizes.size',
            DB::raw('SUM(kardex_sizes.quantity) AS total')
        )
            ->where('local_id', $request->get('local_id'))
            ->where('product_id', $request->get('product_id'))
            ->groupBy('kardex_sizes.size')
            ->get();

        return response()->json($kardex_sizes);
    }

    public function generalStock()
    {
        $previous_date = Carbon::now()->subDay()->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $local_id = Auth::user()->local_id;
        $local = LocalSale::find($local_id);

        $stock_old = Kardex::whereDate('created_at', '<=', $previous_date)
            ->where('local_id', $local_id)
            ->sum('quantity');

        $stock_sales = SaleProduct::join('sales', 'sale_id', 'sales.id')
            ->whereDate('sale_products.created_at', $current_date)
            ->where('sales.local_id', $local_id)
            ->sum('quantity');

        $stock_input = Kardex::whereDate('created_at', '=', $current_date)
            ->where('motion', '=', 'purchase')
            ->where('local_id', $local_id)
            ->sum('quantity');

        $stock_today = Kardex::where('local_id', $local_id)->sum('quantity');

        return response()->json([
            'stock_old' => (int) $stock_old,
            'stock_sales' => (int) $stock_sales,
            'stock_today' => (int) $stock_today,
            'stock_input' => (int) $stock_input,
            'local' => $local
        ]);
    }
}
