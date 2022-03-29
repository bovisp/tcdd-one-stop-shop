<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseCategoryCollection;
use App\Http\Resources\MdlCourseCollection;
use App\Http\Resources\MoodleCourseCatalogueCollection;
use App\Imports\MoodleCourseCatalogueImport;
use App\Models\CourseCategory;
use App\Models\Moodle\MdlCourse;
use App\Models\MoodleCourseCatalogue;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class MoodleCourseCatalogueController extends Controller
{
    public function index()
    {
        $data = MoodleCourseCatalogue::all();
        return Inertia::render('MoodleCourseCatalogue/Index', [
            'catalogues' => MoodleCourseCatalogueCollection::make($data),
            'categories' => CourseCategoryCollection::make(CourseCategory::all()),
        ]);

    }

    public function create()
    {
        return Inertia::render('MoodleCourseCatalogue/Create', [
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'catalogue'   => 'max:10240|required|mimes:csv,xlsx',
        ));
        $catalogueFile = $request->catalogue;

       $file =  (new MoodleCourseCatalogueImport)->import($catalogueFile, 'local', \Maatwebsite\Excel\Excel::XLSX);

        return Redirect::route('course-catalogues.index');

    }
}
