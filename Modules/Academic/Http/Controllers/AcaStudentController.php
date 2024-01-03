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
use Modules\Academic\Entities\AcaStudent;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Academic\Entities\AcaCourse;

class AcaStudentController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $students = (new AcaStudent())->newQuery();
        $students = $students->join('people', 'aca_students.person_id', 'people.id')
            ->select(
                'aca_students.id',
                'aca_students.student_code',
                'people.document_type_id',
                'people.full_name',
                'people.number',
                'people.telephone',
                'people.email',
                'people.address',
                'people.birthdate',
                'people.image AS people_image',
                'aca_students.created_at'
            );
        if (request()->has('search')) {
            $students->where('people.full_name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $students->orderBy($attribute, $sort_order);
        } else {
            $students->latest();
        }

        $students = $students->paginate(12)->onEachSide(2);

        return Inertia::render('Academic::Students/List', [
            'students' => $students,
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

        return Inertia::render('Academic::Students/Create', [
            'identityDocumentTypes' => $identityDocumentTypes,
            'ubigeo'       => $ubigeo,
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
            $file_name = trim($request->get('number')) . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $path);
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

        $user = User::create([
            'name'          => $request->get('names'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('number')),
            'information'   => $request->get('description'),
            'avatar'        => $path,
            'person_id'     => $per->id
        ]);

        $user->assignRole('Alumno');

        AcaStudent::create([
            'person_id'     => $per->id,
            'student_code'  => $request->get('number'),
        ]);

        return redirect()->route('aca_students_list')
            ->with('message', __('Estudiante creado con éxito'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('academic::show');
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

        $student = AcaStudent::join('people', 'person_id', 'people.id')
            ->leftJoin('districts', 'ubigeo', 'districts.id')
            ->leftJoin('provinces', 'districts.province_id', 'provinces.id')
            ->leftJoin('departments', 'provinces.department_id', 'departments.id')
            ->select(
                'people.*',
                'aca_students.id AS student_id',
                DB::raw('CONCAT(departments.name,"-",provinces.name,"-",districts.name) AS city')
            )
            ->where('aca_students.id', $id)
            ->first();

        $student->image_preview = $student->image;

        return Inertia::render('Academic::Students/Edit', [
            'identityDocumentTypes' => $identityDocumentTypes,
            'ubigeo'                => $ubigeo,
            'student'               => $student
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
        $student_id = $request->get('student_id');
        $user = User::where('person_id', $person_id)->first();

        $this->validate(

            $request,
            [
                'document_type_id'  => 'required',
                'number'            => 'required|max:12',
                'number'            => 'unique:people,number,' . $person_id . ',id,document_type_id,' . $request->get('document_type_id'),
                'telephone'         => 'required|max:12',
                'email'             => 'required|max:255',
                'email'            => 'unique:people,email,' . $person_id . ',id',
                'email'            => 'unique:users,email,' . $user->id . ',id',
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
            $file_name = trim($request->get('number')) . '.' . $extension;
            $path = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $path);
        }

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

        $user->update([
            'name'          => $request->get('names'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request->get('number')),
            'information'   => $request->get('description'),
            'avatar'        => $path
        ]);

        AcaStudent::find($student_id)->update([
            'student_code'  => $request->get('number'),
        ]);

        return redirect()->route('aca_students_edit', $student_id)
            ->with('message', __('Estudiante creado con éxito'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function myCourses()
    {
        $user = Auth::user();
        $student_id = AcaStudent::where('person_id', $user->person_id)->value('id');
        $courses = [];
        // También puedes verificar múltiples roles a la vez
        if ($user->hasAnyRole(['admin', 'Docente', 'Administrador'])) {
            $courses = AcaCourse::with('modules.themes.contents')
                ->with('teacher.person')->where('status', true)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $courses = AcaCourse::with('modules.themes.contents')
                ->with('teacher.person')->whereHas('registrations', function ($query) use ($student_id) {
                    $query->where('student_id', $student_id);
                })->orderBy('id', 'DESC')
                ->get();
        }

        return Inertia::render('Academic::Students/MyCourses', [
            'courses' => $courses
        ]);
    }
}
