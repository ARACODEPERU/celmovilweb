<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Inertia\Inertia;
use Modules\Helpdesk\Entities\HelpBoard;
use Modules\Helpdesk\Entities\HelpBoardLevel;
use Modules\Helpdesk\Entities\HelpLevel;

class BoardController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $boards = (new HelpBoard())->newQuery();
        //dd(request()->all());
        if (request()->has('search')) {
            $boards->where('description', 'Like', '%' . request()->input('search') . '%');
        }
        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $boards->orderBy($attribute, $sort_order);
        } else {
            $boards->latest();
        }

        $boards = $boards->with('levels')->paginate(10)->onEachSide(2);

        return Inertia::render('Helpdesk::Boards/List', [
            'levels' => HelpLevel::where('status', true)->get(),
            'boards' => $boards,
            'filters' => request()->all('search'),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:400'
        ]);

        HelpBoard::create([
            'description' => $request->get('description')
        ]);

        return redirect()->route('help-boards.index')
            ->with('message', __('Producto creado con éxito'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'description' => 'required|max:400'
        ]);

        HelpBoard::find($id)->update([
            'description' => $request->get('description')
        ]);

        return redirect()->route('help-boards.index')
            ->with('message', __('Producto creado con éxito'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        HelpBoard::find($id)->delete();
        return redirect()->route('help-boards.index');
    }

    public function saveLevels(Request $request)
    {
        $this->validate($request, [
            'level_id' => 'required'
        ]);
        HelpBoardLevel::updateOrInsert(
            [
                'board_id' => $request->get('board_id'),
                'level_id' => $request->get('level_id')
            ],
            ['index_number' => 1]
        );
        return redirect()->route('help-boards.index');
    }
}
