<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Restaurant\Entities\ResComanda;
use Modules\Restaurant\Entities\ResMenu;
use Modules\Restaurant\Entities\ResMenuComanda;

class ResMenuComandaController extends Controller
{
    public function getComandas($id)
    {
        $comandasFree = ResComanda::whereDoesntHave('menus', function ($query) use ($id) {
            $query->where('menu_id', $id);
        })->get();

        $comandas = ResComanda::select('res_comandas.id', 'res_comandas.name', 'res_comandas.description')
            ->leftJoin('res_menu_comandas', function ($join) use ($id) {
                $join->on('res_comandas.id', '=', 'res_menu_comandas.comanda_id')
                    ->where('res_menu_comandas.menu_id', '=', $id);
            })
            ->selectRaw('IF(res_menu_comandas.comanda_id IS NOT NULL, 1, 0) as chosen')
            ->get();

        return response()->json([
            'comandasFree' => $comandas
        ]);
    }

    public function storeComandas(Request $request, $id)
    {
        ResMenuComanda::where('menu_id', $id)->delete();
        $comandas = $request->get('comandas');
        if (count($comandas) > 0) {
            foreach ($comandas as $key) {
                ResMenuComanda::firstOrCreate(
                    [
                        'menu_id' => $id,
                        'comanda_id' => $key
                    ]
                );
            }
        }
    }
}
