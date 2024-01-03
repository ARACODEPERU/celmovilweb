<?php

namespace Modules\Socialevents\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Modules\Socialevents\Entities\EvenEventTicketPrice;

class EvenEventTickePriceController extends Controller
{
    use ValidatesRequests;

    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'event_id' => 'required'
            ]
        );

        $prices = $request->get('prices');

        foreach ($prices as $row) {
            EvenEventTicketPrice::updateOrCreate(
                [
                    'event_id' => $request->get('event_id'),
                    'type_id'   => $row['type_id'],
                ],
                [
                    'user_id' => Auth::id(),
                    'price' => $row['price'] ?? 0,
                    'quantity' => $row['quantity'] ?? 0,
                    'tickets_available' => $row['quantity'] ?? 0
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}
