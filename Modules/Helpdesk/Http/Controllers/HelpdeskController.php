<?php

namespace Modules\Helpdesk\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Helpdesk\Entities\HelpCategory;
use Modules\Helpdesk\Entities\HelpIncident;

class HelpdeskController extends Controller
{
    public function getRecords()
    {
        $categories = HelpCategory::get();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function getThemesQuestions($id)
    {
        $incidents = HelpIncident::where('category_id', $id)->get();

        return response()->json([
            'incidents' => $incidents
        ]);
    }
}
