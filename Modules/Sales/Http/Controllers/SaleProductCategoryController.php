<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Inertia\Inertia;
use Modules\Sales\Entities\SaleProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SaleProductCategoryController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = (new SaleProductCategory())->newQuery();

        if (request()->has('search')) {
            $categories->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $categories->orderBy($attribute, $sort_order);
        } else {
            $categories->latest();
        }
        $categories = $categories->with('category.category');

        $categories = $categories->paginate(10)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Sales::Categories/List', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = SaleProductCategory::with('subcategories')->whereNull('category_id')->get();

        return Inertia::render('Sales::Categories/Create', [
            'categories' => $categories
        ]);
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
            $category = SaleProductCategory::create([
                'description' => $request->get('description'),
                'category_id' => $request->get('category_id') ?? null
            ]);

            return response()->json([
                'success' => true,
                'category' => $category
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
            'description' => 'required'
        ]);

        $category = SaleProductCategory::create([
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id') ?? null,
            'status' => $request->get('status') ? true : false
        ]);

        $path = null;
        $destination = 'uploads/ventas/categorias';
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
                $file_name = $category->id . '.' . $extension;
                $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);
            }
        }

        $category->image = $path;
        $category->save();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = SaleProductCategory::with('subcategories')->whereNull('category_id')->get();
        $category = SaleProductCategory::find($id);

        return Inertia::render('Sales::Categories/Edit', [
            'categories' => $categories,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $category = SaleProductCategory::find($request->get('id'));

        $category->update([
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id') ?? null,
            'status' => $request->get('status') ? true : false
        ]);

        $path = null;
        $destination = 'uploads/ventas/categorias';
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
                $file_name = $category->id . '.' . $extension;
                $path = Storage::disk('public')->putFileAs($destination, $file, $file_name);

                $category->image = $path;
                $category->save();
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
            $item = SaleProductCategory::findOrFail($id);

            $image_path = storage_path('app/public/' . $item->image);
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            // Si no hay detalles asociados, eliminamos.
            $item->delete();

            // Si todo ha sido exitoso, confirmamos la transacción.
            DB::commit();

            $message =  'Categoría eliminada correctamente';
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
