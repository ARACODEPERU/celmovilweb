<?php

namespace Modules\Academic\Http\Controllers;

use App\Rules\AcaRegistrationExists;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaCapRegistration;
use Modules\Academic\Entities\AcaCertificate;

class AcaCertificateController extends Controller
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

        $courses = AcaCourse::whereHas('registrations', function ($query) use ($id) {
            $query->where('student_id', $id);
        })->get();

        $certificates = AcaCertificate::with('course')
            ->where('student_id', $id)->get();


        return Inertia::render('Academic::Certificates/Create', [
            'student'   => $student,
            'courses'   => $courses,
            'certificates' => $certificates
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
                'student_id'  => ['required', new AcaRegistrationExists($course_id)],
                'course_id'   => 'required',
                'image'       => 'required|max:255'
            ]
        );



        $path = null;

        $destination = 'uploads/certificate';
        $file = $request->file('image');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = $student_id . 'X' . $course_id . '.' . $extension;
            $img = $request->file('image')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $img);
        }
        $true = AcaCertificate::where('student_id', $student_id)->where('course_id', $course_id)->doesntExist();

        if ($true) {
            AcaCertificate::create([
                'student_id'        => $student_id,
                'registration_id'   => AcaCapRegistration::where('student_id', $student_id)->where('course_id', $course_id)->value('id'),
                'course_id'         => $course_id,
                'image'             => $path,
                'content'           => null
            ]);
        }

        return redirect()->route('aca_students_certificates_create', $student_id);
    }


    public function update(Request $request, $id)
    {
        //
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
            $item = AcaCertificate::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Certificado eliminado correctamente';
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
