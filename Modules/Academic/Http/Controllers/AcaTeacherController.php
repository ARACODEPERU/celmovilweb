<?php

namespace Modules\Academic\Http\Controllers;

use App\Models\District;
use App\Models\Person;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaTeacher;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Academic\Entities\AcaTeachingResume;
use Illuminate\Support\Facades\Hash;

class AcaTeacherController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $teachers = (new AcaTeacher())->newQuery();
        $teachers = $teachers->join('people', 'aca_teachers.person_id', 'people.id')
            ->select(
                'aca_teachers.id',
                'aca_teachers.teacher_code',
                'people.document_type_id',
                'people.full_name',
                'people.number',
                'people.telephone',
                'people.email',
                'people.address',
                'people.birthdate',
                'people.image as people_image',
                'aca_teachers.created_at'
            );
        if (request()->has('search')) {
            $teachers->where('people.full_name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $teachers->orderBy($attribute, $sort_order);
        } else {
            $teachers->latest();
        }

        $teachers = $teachers->paginate(12)->onEachSide(2);

        return Inertia::render('Academic::Teachers/List', [
            'teachers' => $teachers,
            'filters' => request()->all('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $identityDocumentTypes = DB::table('identity_document_type')->get();

        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        return Inertia::render('Academic::Teachers/Create', [
            'identityDocumentTypes' => $identityDocumentTypes,
            'ubigeo'       => $ubigeo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $update_id = null;

        $this->validate(
            $request,
            [
                'document_type_id'  => 'required',
                'number'            => 'required|max:12',
                'number'            => 'unique:people,number,' . $update_id . ',id,document_type_id,' . $request->get('document_type_id'),
                'telephone'         => 'required|max:12',
                'email'             => 'required|max:255',
                'email'             => 'unique:people,email',
                'address'           => 'required|max:255',
                'ubigeo'            => 'required|max:255',
                'birthdate'         => 'required|',
                'names'             => 'required|max:255',
                'father_lastname'   => 'required|max:255',
                'mother_lastname'   => 'required|max:255',
            ]
        );

        // $path = 'img' . DIRECTORY_SEPARATOR . 'imagen-no-disponible.jpeg';
        // $destination = 'uploads' . DIRECTORY_SEPARATOR . 'products';
        $path = null;
        $destination = 'uploads/teachers';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset("storage/" . $path); //guardar la ruta COMPLETA
        }


        $per = Person::create([
            'document_type_id'      => $request->get('document_type_id'),
            'short_name'            => $request->get('names'),
            'full_name'             => $request->get('father_lastname') . ' ' .  $request->get('mother_lastname') . ' ' . $request->get('names'),
            'description'           => $request->get('description'),
            'number'                => $request->get('number'),
            'telephone'             => $request->get('telephone'),
            'email'                 => $request->get('email'),
            'image'                 => $path,
            'address'               => $request->get('address'),
            'is_provider'           => false,
            'is_client'             => true,
            'ubigeo'                => $request->get('ubigeo'),
            'birthdate'             => $request->get('birthdate'),
            'names'                 => $request->get('names'),
            'father_lastname'       => $request->get('father_lastname'),
            'mother_lastname'       => $request->get('mother_lastname')
        ]);

        User::create([
            'name'          => $request->get('names'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('number')),
            'information'   => $request->get('description'),
            'avatar'        => $path,
            'person_id'     => $per->id
        ]);

        AcaTeacher::create([
            'person_id'     => $per->id,
            'teacher_code'  => $request->get('number'),
        ]);

        return redirect()->route('aca_teachers_list')
            ->with('message', __('Docente creado con éxito'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $identityDocumentTypes = DB::table('identity_document_type')->get();

        $ubigeo = District::join('provinces', 'province_id', 'provinces.id')
            ->join('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'districts.id AS district_id',
                'districts.name AS district_name',
                'provinces.name AS province_name',
                'departments.name AS department_name'
            )
            ->get();

        $teacher = AcaTeacher::join('people', 'person_id', 'people.id')
            ->leftJoin('districts', 'ubigeo', 'districts.id')
            ->leftJoin('provinces', 'districts.province_id', 'provinces.id')
            ->leftJoin('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'people.*',
                'aca_teachers.id AS teacher_id',
                DB::raw('CONCAT(departments.name,"-",provinces.name,"-",districts.name) AS city')
            )
            ->where('aca_teachers.id', $id)
            ->first();

        $teacher->image_preview = $teacher->image;  //Ruta completa

        return Inertia::render('Academic::Teachers/Edit', [
            'identityDocumentTypes' => $identityDocumentTypes,
            'ubigeo'                => $ubigeo,
            'teacher'               => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $person_id = $request->get('id');
        $student_id = $request->get('teacher_id');

        $this->validate(

            $request,
            [
                'document_type_id'  => 'required',
                'number'            => 'required|max:12',
                'number'            => 'unique:people,number,' . $person_id . ',id,document_type_id,' . $request->get('document_type_id'),
                'telephone'         => 'required|max:12',
                'email'             => 'required|max:255',
                'email'             => 'unique:people,email,' . $person_id . ',id',
                'address'           => 'required|max:255',
                'ubigeo'            => 'required|max:255',
                'birthdate'         => 'required|',
                'names'             => 'required|max:255',
                'father_lastname'   => 'required|max:255',
                'mother_lastname'   => 'required|max:255',
            ]
        );

        // $path = 'img' . DIRECTORY_SEPARATOR . 'imagen-no-disponible.jpeg';
        // $destination = 'uploads' . DIRECTORY_SEPARATOR . 'products';
        $path = null;
        $destination = 'uploads/students';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );
        }
        $path = asset("storage/" . $path); //RUTA COMPLETA
        Person::find($person_id)->update([
            'document_type_id'      => $request->get('document_type_id'),
            'short_name'            => $request->get('names'),
            'full_name'             => $request->get('father_lastname') . ' ' .  $request->get('mother_lastname') . ' ' . $request->get('names'),
            'description'           => $request->get('description'),
            'number'                => $request->get('number'),
            'telephone'             => $request->get('telephone'),
            'email'                 => $request->get('email'),
            'image'                 => $path,
            'address'               => $request->get('address'),
            'is_provider'           => false,
            'is_client'             => true,
            'ubigeo'                => $request->get('ubigeo'),
            'birthdate'             => $request->get('birthdate'),
            'names'                 => $request->get('names'),
            'father_lastname'       => $request->get('father_lastname'),
            'mother_lastname'       => $request->get('mother_lastname')
        ]);

        User::where('person_id', $person_id)->update([
            'name'          => $request->get('names'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('number')),
            'information'   => $request->get('description'),
            'avatar'        => $path
        ]);

        AcaTeacher::find($student_id)->update([
            'teacher_code'  => $request->get('number'),
        ]);

        // return redirect()->route('aca_teachers_edit', $student_id)
        //     ->with('message', __('Estudiante creado con éxito'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;

        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            $tea = AcaTeacher::findOrFail($id);
            $person_id = $tea->person_id;
            // Verificamos si existe.
            $per = Person::findOrFail($person_id);
            $tea->delete();
            // Si no hay detalles asociados, eliminamos.
            $per->delete();
            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Docente eliminada correctamente';
            $success = true;
        } catch (\Exception $e) {
            // Si ocurre alguna excepción durante la transacción, hacemos rollback para deshacer cualquier cambio.
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    public function resume($id)
    {
        $tea = AcaTeacher::findOrFail($id);
        $person_id = $tea->person_id;

        $per = Person::findOrFail($person_id);

        $resumes = AcaTeachingResume::select(
            DB::raw('true AS destroy'),
            DB::raw('false AS loading'),
            'id',
            'teacher_id',
            'description'
        )
            ->where('teacher_id', $id)
            ->get();

        if (count($resumes) > 0) {
            $resumes = $resumes->toArray();
        }

        return Inertia::render('Academic::Teachers/Resume', [
            'person'                => $per,
            'teacher'               => $tea,
            'resumes'               => $resumes
        ]);
    }

    public function workExperienceStore(Request $request)
    {
        $description = $request->get('description');
        $id = $request->get('id');
        $teacher_id = $request->get('teacher_id');

        $this->validate(
            $request,
            [
                'teacher_id'    => 'required',
                'description'   => 'required|max:500'
            ]
        );

        if ($id) {
            AcaTeachingResume::find($id)->update([
                'description'   => $description
            ]);
        } else {
            $resume = AcaTeachingResume::create([
                'type'          => 'work experience',
                'teacher_id'    => $teacher_id,
                'description'   => $description,
                'person_id'     => AcaTeacher::find($teacher_id)->person_id
            ]);

            $id = $resume->id;
        }

        return response()->json([
            'id' => $id
        ]);
    }

    public function workExperienceDestroy($id)
    {
        $message = null;
        $success = false;

        try {

            DB::beginTransaction();

            $resume = AcaTeachingResume::findOrFail($id);

            $resume->delete();

            DB::commit();

            $message =  'Experiencia eliminada correctamente';
            $success = true;
        } catch (\Exception $e) {

            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
