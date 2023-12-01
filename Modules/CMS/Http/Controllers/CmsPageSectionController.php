<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Entities\CmsPageSection;
use Inertia\Inertia;
use Modules\CMS\Entities\CmsPage;
use Modules\CMS\Entities\CmsSection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CMS\Entities\CmsItem;
use Modules\CMS\Entities\CmsSectionItem;

class CmsPageSectionController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $xsections = CmsPageSection::join('cms_sections', 'section_id', 'cms_sections.id')
            ->select(
                'cms_sections.*',
                'cms_page_sections.id AS page_sections_id',
                'cms_page_sections.description AS page_sections_description'
            )
            ->where('page_id', $id)
            ->get();

        return Inertia::render('CMS::Pages/Sections/List', [
            'page' => CmsPage::find($id),
            'sections' => CmsSection::all(),
            'xsections' => $xsections
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
                'description' => 'required|string',
                'section_id' => 'required',
            ]
        );

        CmsPageSection::create([
            'description'   => $request->get('description'),
            'section_id'    => $request->get('section_id'),
            'page_id'       => $request->get('page_id')
        ]);
    }

    public function getSectionItems($id)
    {
        $items = CmsSectionItem::with('item.items')->where('section_id', $id)->get();
        //dd($items->toRawSql());
        return response()->json([
            'items' => $items
        ]);
    }

    public function updateItems(Request $request)
    {
        $destination = 'uploads/cms/items';
        $items = $request->all();
        //dd($request->all());
        foreach ($items['items'] as $key => $item) {

            $type_id = $item['type_id'];

            $content = null;

            if ($type_id == 1 || $type_id == 3) {
                if ($item['is_file'] === 'yes') {
                    $file = $item['content'];
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $original_name = str_replace(" ", "_", $original_name);
                    $extension = $file->getClientOriginalExtension();
                    $file_name = date('YmdHis') . '.' . $extension;
                    $path = $item['content']->storeAs(
                        $destination,
                        $file_name,
                        'public'
                    );

                    $content = $type_id == 1 ? asset('storage/' . $path) : $path;
                } else {
                    $content = $item['content'];
                }
            }

            if ($type_id == 2 || $type_id == 4) {
                $content = $item['content'];
            }


            CmsItem::find($item['id'])->update([
                'content' => $content
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function destroySection($id)
    {
        CmsPageSection::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Se eliminó correctamente'
        ]);
    }

    public function groupSectionStore(Request $request)
    {
        $items = CmsItem::where('item_id', $request->get('group_id'))->get();

        $group = CmsItem::create([
            'type_id'       => 5,
            'position'      => 1,
            'description'   => $request->get('group_description')
        ]);

        foreach ($items as $k => $item) {
            CmsItem::create([
                'type_id'       => $item->type_id,
                'item_id'       => $group->id,
                'position'      => $item->position,
                'description'   => $item->description
            ]);
        }

        CmsSectionItem::create([
            'item_id'       => $group->id,
            'section_id'    => $request->get('section_id'),
            'position'      => 1,
            'description'   => 'grupo copiado'
        ]);
    }
}
