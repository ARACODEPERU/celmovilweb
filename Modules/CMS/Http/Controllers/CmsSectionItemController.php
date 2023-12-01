<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\CMS\Entities\CmsSectionItem;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\CMS\Entities\CmsItem;
use Modules\CMS\Entities\CmsItemType;
use Modules\CMS\Entities\CmsSection;

class CmsSectionItemController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        // EDITANDO --- 
        $items = (new CmsItem())->newQuery();

        if (request()->has('search')) {
            $items->where('description', 'like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $items->orderBy($attribute, $sort_order);
        } else {
            $items->latest();
        }

        $items = $items->where(function ($query) use ($id) {
            $query->whereRaw('(SELECT COUNT(item_id) FROM cms_section_items WHERE cms_section_items.item_id = cms_items.id AND cms_section_items.section_id = ?) = 0', [$id]);
        });



        $items = $items->paginate(10)->onEachSide(2);


        $items->getCollection()->transform(function ($item) {
            $item->display = true;
            return $item;
        });

        $sItems = CmsSectionItem::join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.id',
                'cms_items.type_id',
                'cms_items.position',
                'cms_items.content',
                'cms_items.description',
                'cms_section_items.id AS si_id',
                'cms_section_items.description AS si_description',
                'cms_section_items.position AS si_position'
            )
            ->where('section_id', $id)
            ->orderBy('cms_section_items.position')
            ->get();

        return Inertia::render('CMS::Sections/Items/List', [
            'section'   => CmsSection::find($id),
            'items'     => $items,
            'sItems'    => $sItems
        ]);
    }

    public function store(Request $request)
    {
        $items = $request->get('data');
        $section_id = $request->get('section_id');
        $description = $request->get('description');
        //dd($items);
        if (count($items) > 0) {
            foreach ($items as $k => $item) {
                //CmsSectionItem::firstOrCreate([ //crea o busca si no existe lo crea
                CmsSectionItem::updateOrCreate([ //si existe lo modifica si no lo crea
                    'item_id'       => $item['id'],
                    'section_id'    => $section_id
                ], [
                    'position'      => $item['si_position'],
                    'description'   => $description
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        CmsSectionItem::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Se eliminó correctamente'
        ]);
    }

    public function groupItems($id)
    {
        $types = CmsItemType::where('id', '<>', 5)->get();

        $groups = CmsSectionItem::with(['group' => function ($query) {
            $query->where('type_id', 5); // Ordena por el campo 'position' de la tabla 'cms_section_items'
        }, 'group.items'])->where('section_id', $id)->get();

        //$groups = CmsSectionItem::with('group.items')->where('section_id', $id)->get();
        // return response()->json([
        //     'types'     => $types,
        //     'section'   => CmsSection::find($id),
        //     'groups'    => $groups
        // ]);
        return Inertia::render('CMS::Sections/GroupItems', [
            'types'     => $types,
            'section'   => CmsSection::find($id),
            'groups'    => $groups
        ]);
    }

    public function groupItemsStore(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|max:255',
                'contents.*.type_id' => 'required',
                'contents.*.description' => 'required',
            ],
            [
                'contents.*.type_id.required' => 'Seleccionar Tipo',
                'contents.*.description.required' => 'El campo Descripción es obligatorio',
                'description.required' => 'El campo Descripción es obligatorio',
            ]
        );

        $items = $request->get('contents');
        $group = CmsItem::create([
            'type_id'       => 5,
            'position'      => 1,
            'description'   => $request->get('description')
        ]);

        foreach ($items as $k => $item) {
            CmsItem::create([
                'type_id'       => $item['type_id'],
                'item_id'       => $group->id,
                'position'      => $k + 1,
                'description'   => $item['description']
            ]);
        }

        CmsSectionItem::create([
            'item_id'       => $group->id,
            'section_id'    => $request->get('section_id'),
            'position'      => 1,
            'description'   => $request->get('section_description')
        ]);
    }

    public function groupItemsDestroy($id)
    {
        CmsItem::find($id)->delete();
        CmsSectionItem::where('item_id', $id)->delete();

        $message =  'Grupo eliminado correctamente';
        $success = true;

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
