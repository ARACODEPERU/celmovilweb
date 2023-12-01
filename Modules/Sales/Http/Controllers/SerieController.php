<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\LocalSale;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SerieController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description'       => 'required|unique:series,description',
            'number'            => 'required|numeric',
            'document_type_id'  => 'required'
        ]);

        $user = User::where('local_id', $request->get('local_id'))->first();

        Serie::create([
            'document_type_id'      => $request->get('document_type_id'),
            'description'           => strtoupper($request->get('description')),
            'number'                => $request->get('number'),
            'user_id'               => $user->id,
            'local_id'              => $request->get('local_id')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show(Serie $serie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function edit(Serie $serie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serie $serie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Serie::find($id)->delete();
            return redirect()->route('establishments.index');
        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }
}
