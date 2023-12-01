<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaBrochure;
use Modules\Academic\Entities\AcaCategoryCourse;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaInstitution;
use Modules\Academic\Entities\AcaModality;
use Modules\Academic\Entities\AcaTeacher;
use Modules\Academic\Entities\AcaTeacherCourse;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AcaCourseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $RPTABLE;

    public function __construct()
    {
        $this->RPTABLE = env('RECORDS_PAGE_TABLE') ?? 10;
    }

    public function index()
    {
        $courses = (new AcaCourse())->newQuery();
        if (request()->has('search')) {
            $courses->where('description', 'like', '%' . request()->input('search') . '%');
        }
        $courses->orderBy('id', 'DESC');
        $courses->with('category');
        $courses->with('modality');
        $courses->with('modules');
        $courses = $courses->paginate($this->RPTABLE)->onEachSide(2);

        $institutions = AcaInstitution::where('status', true)->get();

        return Inertia::render('Academic::Courses/List', [
            'courses'       => $courses,
            'institutions'  => $institutions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = AcaCategoryCourse::all();
        $modalities = AcaModality::all();

        return Inertia::render('Academic::Courses/Create', [
            'modalities'    => $modalities,
            'categories'    => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required',
                'course_date' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'modality_id' => 'required',
                'type_description' => 'required',
            ]
        );


        $path = null;

        $destination = 'uploads/courses';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $img = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $img);
        }
        $timestamp = strtotime($request->get('course_date'));

        $courseNew = AcaCourse::create([
            'status'            => $request->get('status') ? true : false,
            'description'       => $request->get('description'),
            'course_day'        => date("d", $timestamp),
            'course_month'      => date("m", $timestamp),
            'course_year'       => date("Y", $timestamp),
            'category_id'       => $request->get('category_id'),
            'image'             => $path,
            'modality_id'       => $request->get('modality_id'),
            'type_description'  => $request->get('type_description'),
            'sector_description' => AcaCategoryCourse::find($request->get('category_id'))->description
        ]);

        return redirect()->route('aca_courses_information', $courseNew->id)
            ->with('message', 'Curso creado con éxito, registrar informacion del curso');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function information($id)
    {
        $course_teachers = AcaTeacherCourse::with('teacher.person')->where('course_id', $id)->get();

        $teachers = AcaTeacher::with('person')->get();

        if (count($teachers) > 0) {
            $teachers = $teachers->toArray();
        }
        if (count($course_teachers) > 0) {
            $course_teachers = $course_teachers->toArray();
        }

        return Inertia::render('Academic::Courses/Information', [
            'brochure' => AcaBrochure::where('course_id', $id)->first(),
            'course' => AcaCourse::find($id),
            'tiny_api_key' => env('TINY_API_KEY'),
            'teachers' => $teachers,
            'course_teachers' => $course_teachers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $categories = AcaCategoryCourse::all();
        $modalities = AcaModality::all();

        return Inertia::render('Academic::Courses/Edit', [
            'course'        => AcaCourse::find($id),
            'modalities'    => $modalities,
            'categories'    => $categories
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
        $id = $request->get('id');

        $this->validate(
            $request,
            [
                'description' => 'required',
                'course_date' => 'required',
                'category_id' => 'required',
                'modality_id' => 'required',
                'type_description' => 'required',
            ]
        );

        $course = AcaCourse::find($id);
        $timestamp = strtotime($request->get('course_date'));


        $course->status           = $request->get('status') ? true : false;
        $course->description      = $request->get('description');
        $course->course_day       = date("d", $timestamp);
        $course->course_month     = date("m", $timestamp);
        $course->course_year       = date("Y", $timestamp);
        $course->category_id      = $request->get('category_id');
        $course->modality_id       = $request->get('modality_id');
        $course->type_description  = $request->get('type_description');
        $course->sector_description = AcaCategoryCourse::find($request->get('category_id'))->description;

        $destination = 'uploads/courses';
        $file = $request->file('image');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $img = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $course->image  = asset('storage/' . $img);
        }

        $course->save();
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

            // Verificamos si existe.
            $item = AcaCourse::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Curso eliminado correctamente';
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
}
