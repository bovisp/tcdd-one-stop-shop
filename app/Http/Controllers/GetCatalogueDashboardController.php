<?php

namespace App\Http\Controllers;

use App\Http\Resources\MoodleCourseCatalogueCollection;
use App\Models\MoodleCourseCatalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GetCatalogueDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = DB::table('moodle_course_catalogues')
            ->where('title','LIKE','%'.$request->keyword.'%')
            ->orWhere('language', $request->language)
            ->orWhere('category_id', $request->category_id)
            ->get();
        return Inertia::render('MoodleCourseCatalogues/index', [
            'catalogue_filters' => MoodleCourseCatalogueCollection::make($data),
        ]);
    }

}
