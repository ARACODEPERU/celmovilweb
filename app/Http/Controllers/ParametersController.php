<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use function Pest\Laravel\json;

class ParametersController extends Controller
{
    public function index()
    {
        $parameters = (new Parameter())->newQuery();

        if (request()->has('search')) {
            $parameters->where('description', 'Like', '%' . request()->input('search') . '%');
        }
        $parameters = $parameters->get();

        $formatted = [];

        foreach ($parameters as $parameter) {
            $json_query_data = [];
            if ($parameter->control_type == 'sq') {
                $json_query_data = $this->getSubQuery($parameter->json_query_data);
            } else {
                $data = json_decode($parameter->json_query_data);
                // Verifica si la decodificación fue exitosa
                if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                    // El JSON es inválido
                    $json_query_data = null;
                } else {
                    $json_query_data = $parameter->json_query_data;
                }
            }


            array_push($formatted, [
                'id' => $parameter->id,
                'parameter_code' => $parameter->parameter_code,
                'description' => $parameter->description,
                'control_type' => $parameter->control_type,
                'json_query_data' => $json_query_data,
                'value_default' => $parameter->value_default,
            ]);
        }
        //dd($formatted);
        return Inertia::render('Parameters/List', [
            'parameters' => $formatted
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
            'parameter_code'        => 'unique:parameters,parameter_code',
            'description'           => 'required|max:255',
            'control_type'          => 'required',
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

    public function edit($id)
    {
        $parameter = Parameter::find($id);
        return Inertia::render('Parameters/Edit', [
            'parameter' => $parameter
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'parameter_code'        => 'required|max:10',
            'parameter_code'        => 'unique:parameters,parameter_code,' . $id,
            'description'           => 'required|max:255',
            'control_type'          => 'required',
            'value_default'         => 'required'
        ]);
        //dd($id);
        Parameter::find($id)->update([
            'parameter_code'        => $request->get('parameter_code'),
            'description'           => $request->get('description'),
            'control_type'          => $request->get('control_type'),
            'json_query_data'       => $request->get('json_query_data'),
            'value_default'         => $request->get('value_default')
        ]);
    }

    public function getSubQuery($json_query_data)
    {
        $result  = DB::select($json_query_data);

        return json_encode($result);
    }

    public function updateDefaultValue($id, $val)
    {
        Parameter::find($id)->update([
            'value_default' => $val
        ]);
    }
}
