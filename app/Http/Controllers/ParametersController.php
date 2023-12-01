<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParametersController extends Controller
{
    public function index()
    {
        $parameters = (new Parameter())->newQuery();

        if (request()->has('search')) {
            $parameters->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $parameters->orderBy($attribute, $sort_order);
        } else {
            $parameters->latest();
        }

        $parameters = $parameters->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Parameters/List', [
            'parameters' => $parameters
        ]);
    }

    public function create()
    {
        return Inertia::render('Parameters/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parameter_code'        => 'required|max:10',
            'description'           => 'required|max:255',
            'control_type'          => 'required',
            'json_query_data'       => 'required',
            'value_default'         => 'required'
        ]);

        Parameter::create([
            'parameter_code'        => $request->get('parameter_code'),
            'description'           => $request->get('description'),
            'control_type'          => $request->get('control_type'),
            'json_query_data'       => $request->get('json_query_data'),
            'value_default'         => $request->get('value_default')
        ]);
    }
}
