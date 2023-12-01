<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Helpdesk\Entities\HelpLevel;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Helpdesk\Entities\HelpLevelUser;

class HelpLevelController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $levels = HelpLevel::with('users')->get();

        return Inertia::render('Helpdesk::Levels/List', [
            'levels' => $levels,
            'users' => User::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Helpdesk::Levels/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:300'
        ]);

        HelpLevel::create([
            'description' => $request->get('description')
        ]);

        return redirect()->route('help-level.index');
    }

    public function edit($id)
    {
        return Inertia::render('Helpdesk::Levels/Edit', [
            'helplevel' => HelpLevel::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required|max:300'
        ]);

        HelpLevel::find($id)->update([
            'description'   => $request->get('description'),
            'status'        => $request->get('status') ? true : false
        ]);
    }

    public function destroy($id)
    {
        HelpLevel::find($id)->delete();
        return redirect()->route('help-level.index');
    }

    public function saveUser(Request $request)
    {
        HelpLevelUser::where('level_id', $request->get('level_id'))->delete();
        foreach ($request->get('user_ids') as $id) {
            HelpLevelUser::create([
                'level_id'  => $request->get('level_id'),
                'user_id'   => $id
            ]);
        }
        return redirect()->route('help-level.index');
    }
}
