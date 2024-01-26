<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Sales\Entities\SaleProductBrand;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SaleProductBrandController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = (new SaleProductBrand())->newQuery();

        if (request()->has('search')) {
            $brands->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $brands->orderBy($attribute, $sort_order);
        } else {
            $brands->latest();
        }

        $brands = $brands->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Sales::Brands/List', [
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Sales::Brands/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDirect(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        try {
            $brand = SaleProductBrand::create([
                'description' => $request->get('description')
            ]);

            return response()->json([
                'success' => true,
                'brand' => $brand
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        try {
            $brand = SaleProductBrand::create([
                'description' => $request->get('description'),
                'status' => $request->get('status') ? true : false
            ]);

            $path = null;
            $destination = 'uploads/ventas/marcas';
            $base64Image = $request->get('image');

            if ($base64Image) {
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
                    // $original_name = strtolower(trim($file->getClientOriginalName()));
                    // $file_name = time() . rand(100, 999) . $original_name;
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $brand->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
            }

            $brand->image = $path;
            $brand->save();
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Inertia::render('Sales::Brands/Edit', [
            'brand' => SaleProductBrand::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        try {
            $brand = SaleProductBrand::find($request->get('id'));
            $brand->update([
                'description' => $request->get('description'),
                'status' => $request->get('status') ? true : false
            ]);

            $path = null;
            $destination = 'uploads/ventas/marcas';
            $base64Image = $request->get('image');

            if ($base64Image) {
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
                    // $original_name = strtolower(trim($file->getClientOriginalName()));
                    // $file_name = time() . rand(100, 999) . $original_name;
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = $brand->id . '.' . $extension;
                    $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
                }
            }

            $brand->image = $path;
            $brand->save();
        } catch (Exception $e) {
            dd($e);
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
            $item = SaleProductBrand::findOrFail($id);

            $image_path = storage_path('app/public/' . $item->image);
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Marca eliminada correctamente';
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
