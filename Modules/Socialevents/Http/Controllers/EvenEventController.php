<?php

namespace Modules\Socialevents\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Academic\Entities\AcaTeacher;
use Modules\Socialevents\Entities\EvenCategory;
use Modules\Socialevents\Entities\EvenEvent;
use Modules\Socialevents\Entities\EvenLocal;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Socialevents\Entities\EvenEventExhibitor;
use Modules\Socialevents\Entities\EvenEventLocal;
use Modules\Socialevents\Entities\EvenTicketType;

class EvenEventController extends Controller
{
    use ValidatesRequests;

    protected $P000010; ///token Tiny

    public function __construct()
    {
        $this->P000010  = Parameter::where('parameter_code', 'P000010')->value('value_default');
    }
    public function index()
    {
        $events = (new EvenEvent())->newQuery();

        if (request()->has('search')) {
            $events->where('title', 'Like', '%' . request()->input('search') . '%');
        }
        $events = $events->with('exhibitors.exhibitor');
        $events = $events->with('locales.local');
        $events = $events->with('prices');
        $events = $events->orderBy('id', 'DESC');
        $events = $events->paginate(10);

        $types = EvenTicketType::all();

        return Inertia::render('Socialevents::Events/List', [
            'socialevents' => $events,
            'filters' => request()->all('search'),
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EvenCategory::where('status', true)->get();
        $instructors = AcaTeacher::with('person')->get();
        $locales = EvenLocal::where('status', true)->get();

        return Inertia::render('Socialevents::Events/Create', [
            'categories' => $categories,
            'instructors'   => $instructors,
            'tiny_api_key' => $this->P000010,
            'locales' => $locales
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate(
            $request,
            [
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'advertising_video' => 'required',
                'tickets_quantity' => 'required',
                'date' => 'required'
            ]
        );
        //dd($request->all());
        $ds = $request->get('date')[0]['$d'];
        $de = $request->get('date')[1]['$d'];
        $days = Carbon::parse($ds)->diffInDays(Carbon::parse($de));

        $event = EvenEvent::create([
            'category_id' => $request->get('category_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'iframe_transmission' => $request->get('iframe_transmission'),
            'advertising_video' => $request->get('advertising_video'),
            'date_start' => Carbon::parse($ds)->format('Y-m-d'),
            'date_end'  => Carbon::parse($de)->format('Y-m-d'),
            'number_days'   => $days + 1,
            'tickets_quantity' => $request->get('tickets_quantity'),
            'status' => 'PE',
            'broadcast' => $request->get('broadcast') ? true : false,
            'tickets_available' => $request->get('tickets_quantity')
        ]);


        $locales = $request->get('locales');
        $exhibitors = $request->get('exhibitors');

        if (count($locales) > 0) {
            foreach ($locales as $local) {
                EvenEventLocal::create([
                    'event_id' => $event->id,
                    'local_id' => $local,
                ]);
            }
        }

        if (count($exhibitors) > 0) {
            foreach ($exhibitors as $exhibitor) {
                EvenEventExhibitor::create([
                    'event_id' => $event->id,
                    'exhibitor_id' => $exhibitor
                ]);
            }
        }

        $path = null;
        $destination = 'uploads/eventos/events';
        $base64Image = $request->get('image1');
        if ($base64Image) {
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0755, true);
            }
            try {
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                if (PHP_OS == 'WINNT') {
                    $tempFile = tempnam(sys_get_temp_dir(), 'img');
                } else {
                    $tempFile = tempnam('/var/www/html/img_temp', 'img');
                }
                //dd($tempFile);
                file_put_contents($tempFile, $fileData);
                $mime = mime_content_type($tempFile);

                $name = uniqid('', true) . '.' . str_replace('image/', '', $mime);
                $file = new UploadedFile(realpath($tempFile), $name, $mime, null, true);

                if ($file) {
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $event->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
            } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e) {
                dd($e->getMessage());
            }

            $event->image1 = $path;
            $event->save();
        }

        return to_route('even_eventos_list');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('socialevents::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = EvenCategory::where('status', true)->get();
        $instructors = AcaTeacher::with('person')->get();
        $locales = EvenLocal::where('status', true)->get();
        $event = EvenEvent::find($id);

        $eventLocales = EvenEventLocal::where('event_id', $id)->pluck('local_id');
        $eventExhibitors = EvenEventExhibitor::where('event_id', $id)->pluck('exhibitor_id');

        return Inertia::render('Socialevents::Events/Edit', [
            'categories' => $categories,
            'instructors'   => $instructors,
            'tiny_api_key' => $this->P000010,
            'locales' => $locales,
            'socialevent' => $event,
            'eventLocales' => $eventLocales,
            'eventExhibitors' => $eventExhibitors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'advertising_video' => 'required',
                'tickets_quantity' => 'required',
                'date' => 'required'
            ]
        );

        $event = EvenEvent::find($request->get('id'));
        $ds = $request->get('date')[0]['$d'];
        $de = $request->get('date')[1]['$d'];
        $days = Carbon::parse($ds)->diffInDays(Carbon::parse($de));

        $event->update([
            'category_id' => $request->get('category_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'iframe_transmission' => $request->get('iframe_transmission'),
            'advertising_video' => $request->get('advertising_video'),
            'date_start' => Carbon::parse($ds)->format('Y-m-d'),
            'date_end'  => Carbon::parse($de)->format('Y-m-d'),
            'number_days'   => $days + 1,
            'tickets_quantity' => $request->get('tickets_quantity'),
            'broadcast' => $request->get('broadcast') ? true : false,
            'tickets_available' => $request->get('tickets_quantity')
        ]);

        EvenEventLocal::where('event_id', $event->id)->delete();
        EvenEventExhibitor::where('event_id', $event->id)->delete();

        $locales = $request->get('locales');
        $exhibitors = $request->get('exhibitors');

        if (count($locales) > 0) {
            foreach ($locales as $local) {
                EvenEventLocal::create([
                    'event_id' => $event->id,
                    'local_id' => $local,
                ]);
            }
        }

        if (count($exhibitors) > 0) {
            foreach ($exhibitors as $exhibitor) {
                EvenEventExhibitor::create([
                    'event_id' => $event->id,
                    'exhibitor_id' => $exhibitor
                ]);
            }
        }

        $path = $request->get('image1_preview');
        $destination = 'uploads/eventos/events';
        $base64Image = $request->get('image1');
        if ($base64Image) {
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0755, true);
            }
            try {
                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                if (PHP_OS == 'WINNT') {
                    $tempFile = tempnam(sys_get_temp_dir(), 'img');
                } else {
                    $tempFile = tempnam('/var/www/html/img_temp', 'img');
                }

                file_put_contents($tempFile, $fileData);
                $mime = mime_content_type($tempFile);

                $name = uniqid('', true) . '.' . str_replace('image/', '', $mime);
                $file = new UploadedFile(realpath($tempFile), $name, $mime, null, true);

                if ($file) {
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $event->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
                $event->image1 = $path;
                $event->save();
            } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e) {
                dd($e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $message = null;
        $success = false;
        try {
            // Usamos una transacción para asegurarnos de que la operación se realice de manera segura.
            DB::beginTransaction();

            // Verificamos si existe.
            $item = EvenEvent::findOrFail($id);

            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Evento eliminada correctamente';
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
