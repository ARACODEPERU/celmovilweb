<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Helpdesk\Entities\HelpCategory;
use Modules\Helpdesk\Entities\HelpIncident;
use Illuminate\Foundation\Validation\ValidatesRequests;

class HelpIncidentController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = (new HelpIncident())->newQuery();

        if (request()->has('search')) {
            $incidents->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        $incidents = $incidents->with('category');
        $incidents = $incidents->orderBy('id', 'DESC');
        $incidents = $incidents->get();

        $incidents->each(function ($incident) {
            $incident->editable = false;
        });

        $categories = HelpCategory::get();

        return Inertia::render('Helpdesk::Incidents/List', [
            'incidents' => $incidents,
            'categories' => $categories,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('helpdesk::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'description' => 'required'
        ]);

        HelpIncident::create([
            'description' => $request->get('description'),
            'status' => $request->get('status') == 1 ? true : false,
            'category_id' => $request->get('category_id')
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('helpdesk::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('helpdesk::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'description' => 'required'
        ]);

        HelpIncident::find($id)->update([
            'description' => $request->get('description'),
            'status' => $request->get('status') == 1 ? true : false,
            'category_id' => $request->get('category_id')
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
