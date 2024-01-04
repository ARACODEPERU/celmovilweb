<?php

namespace Modules\Onlineshop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Onlineshop\Entities\OnliItemImage;
use Illuminate\Support\Facades\Storage;

class OnliItemImageController extends Controller
{
    public function upload(Request $request)
    {

        $destination = 'uploads/onlineshop/items';
        $file = $request->file('file');
        if ($file) {
            $original_name = strtolower(trim($file->getClientOriginalName()));
            $original_name = str_replace(" ", "_", $original_name);
            $extension = $file->getClientOriginalExtension();
            $file_name = date('YmdHis') . '.' . $extension;
            $path = $request->file('file')->storeAs(
                $destination,
                $file_name,
                'public'
            );

            OnliItemImage::create([
                'item_id'           => $request->get('item_id'),
                'image_path'        => $path,
                'image_name'        => $original_name,
                'image_extension'   => $extension
            ]);
        }
    }
    public function destroy($id)
    {

        $image = OnliItemImage::find($id);
        $image_path = storage_path('app/public/' . $image->image_path);
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
        $image->delete();
    }
}
