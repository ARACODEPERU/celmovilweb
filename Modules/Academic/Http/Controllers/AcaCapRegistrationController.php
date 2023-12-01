<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaCapRegistration;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

class AcaCapRegistrationController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        return view('academic::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {
        $student = AcaStudent::with('person')->where('id', $id)->first();

        $courses = AcaCourse::where('status', true)
            ->get();

        $registrations = AcaCapRegistration::with('course')
            ->where('student_id', $id)->get();


        return Inertia::render('Academic::Registrations/Create', [
            'student'   => $student,
            'courses'   => $courses,
            'registrations' => $registrations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $student_id = $request->get('student_id');
        $course_id = $request->get('course_id');

        $this->validate(
            $request,
            [
                'student_id'  => 'required',
                'course_id'   => 'required',
            ]
        );

        $true = AcaCapRegistration::where('student_id', $student_id)->where('course_id', $course_id)->doesntExist();

        if ($true) {
            AcaCapRegistration::create([
                'student_id'        => $student_id,
                'course_id'         => $course_id,
                'status'             => true
            ]);
        }

        return redirect()->route('aca_students_registrations_create', $student_id);
    }

    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            DB::beginTransaction();

            $item = AcaCapRegistration::findOrFail($id);

            $item->delete();

            DB::commit();

            $message =  'Matricula eliminado correctamente';
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
