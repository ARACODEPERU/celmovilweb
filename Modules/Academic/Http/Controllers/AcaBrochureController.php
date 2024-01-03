<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Academic\Entities\AcaBrochure;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaTeacher;
use Modules\Academic\Entities\AcaTeacherCourse;

class AcaBrochureController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('academic::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academic::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'course_id' => 'required',
                'resolution' => 'required',
                'presentation' => 'required',
                'benefits' => 'required',
                'frequent_questions' => 'required'
            ]
        );

        $teachers = $request->get('teaching_plan');
        $path = null;
        $destination = 'uploads/institutions';
        $file = $request->file('path_file');

        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $img = $request->file('path_file')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            $path = asset('storage/' . $img);
        }

        $baseUrl = env('APP_URL'); // Ruta base de tu aplicación
        $resolution = $request->get('resolution');
        $presentation = $request->get('presentation');
        $benefits = $request->get('benefits');
        $frequent_questions = $request->get('frequent_questions');
        // Reemplazar las rutas de imágenes en el contenido
        $resolution = preg_replace('/src="\/storage\/brochures\/([^"]+)"/', 'src="' . $baseUrl . '/storage/brochures/$1"', $resolution);
        $presentation = preg_replace('/src="\/storage\/brochures\/([^"]+)"/', 'src="' . $baseUrl . '/storage/brochures/$1"', $presentation);
        $benefits = preg_replace('/src="\/storage\/brochures\/([^"]+)"/', 'src="' . $baseUrl . '/storage/brochures/$1"', $benefits);
        $frequent_questions = preg_replace('/src="\/storage\/brochures\/([^"]+)"/', 'src="' . $baseUrl . '/storage/brochures/$1"', $frequent_questions);


        AcaBrochure::updateOrCreate(
            ['course_id' => $request->get('course_id')],
            [
                'resolution' => $resolution,
                'presentation' => $presentation,
                'benefits' => $benefits,
                'frequent_questions' => $frequent_questions,
                'path_file' => $path !== null ? $path : AcaBrochure::where('course_id', $request->get('course_id'))->value('path_file')
            ]
        );

        AcaTeacherCourse::where('course_id', $request->get('course_id'))->delete();
        AcaCourse::find($request->get('course_id'))->update([
            'teacher_id' => null
        ]);
        if (count($teachers) > 0) {
            foreach ($teachers as $teacher) {
                AcaTeacherCourse::create([
                    'teacher_id'    => $teacher['teacher']['id'],
                    'course_id'     => $request->get('course_id')
                ]);
                if ($teacher['is_main']) {
                    AcaCourse::find($request->get('course_id'))->update([
                        'teacher_id' => $teacher['teacher']['id']
                    ]);
                }
            }
        }


        return redirect()->route('aca_courses_list', $request->get('course_id'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('academic::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('academic::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function uploadImage(Request $request)
    {
        //dd($request->all());
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $file_name = 'course_' . date('YmdHis') . '.' . $extension;

        //indicamos que queremos guardar un nuevo archivo en el disco local
        $path = $request->file('file')->storeAs(
            'brochures',
            $file_name,
            'public'
        );

        $url = asset('storage/' . $path);

        return response()->json(['location' =>  $url]);
    }
}
