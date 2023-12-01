<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\District;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function show()
    {
        $company = Company::first();
        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        return Inertia::render('Company/Show', [
            'company'   => $company ? $company : [],
            'ubigeo'    => $ubigeo,
        ]);
    }
    public function updateCreate(Request $request)
    {
        $this->validate($request, [
            'ruc' => 'required|max:12',
            'name' => 'required|max:300',
            'business_name' => 'required|max:300',
            'tradename'  => 'required|max:300',
            'fiscal_address'  => 'required|max:300',
            'phone'  => 'required|max:15',
            'email'  => 'required|max:150',
            'mode'  => 'required'
        ]);

        $path = '';
        $path176x32 = '';
        $destination = 'uploads/company';
        $file = $request->file('logo');
        $file176x32 = $request->file('logo_document');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            //$extension = $file->getClientOriginalExtension();
            $file_name = 'logo.png';
            $path = $request->file('logo')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }

        if ($file176x32) {
            $original_name = strtolower(trim($file176x32->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            //$extension = $file->getClientOriginalExtension();
            $file_name176x32 = 'logo176x32.png';
            $path176x32 = $request->file('logo_document')->storeAs(
                $destination,
                $file_name176x32,
                'public'
            );
        }

        Company::updateOrCreate(
            ['ruc' =>  $request->get('ruc')],
            [
                'name'              => $request->get('name'),
                'business_name'     => $request->get('business_name'),
                'tradename'         => $request->get('tradename'),
                'fiscal_address'    => $request->get('fiscal_address'),
                'phone'             => $request->get('phone'),
                'representative'    => $request->get('representative'),
                'email'             => $request->get('email'),
                'logo'              => $path ? $path : Company::where('ruc', '=', $request->get('ruc'))->first()->logo,
                'logo_document'     => $path176x32 ? $path176x32 : Company::where('ruc', '=', $request->get('ruc'))->first()->logo,
                'mode'              => $request->get('mode'),
                'ubigeo'            => $request->get('ubigeo')
            ]
        );

        Company::where('ruc', '<>', $request->get('ruc'))->delete();

        return redirect()->route('company_show');
    }

    public function getdata()
    {
        $company = Company::first();
        return response()->json($company);
    }
}
