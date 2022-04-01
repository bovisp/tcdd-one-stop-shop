<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseCategoryCollection;
use App\Http\Resources\MoodleCourseCatalogueCollection;
use App\Imports\MoodleCourseCatalogueImport;
use App\Models\CourseCategory;
use App\Models\MoodleCourseCatalogue;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class MoodleCourseCatalogueController extends Controller
{

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $category_id =$request->category_id;
        $query = MoodleCourseCatalogue::query()->with('courseCategories')
            ->where('title','LIKE','%'.$request->keyword.'%')
            ->orWhere('language', $request->language)
           ->orwhereHas('courseCategories', function ($q) use ($category_id) {
               $q->where('course_category_id', $category_id);
            });

        $data = $request->get('page') !== '0'
            ? $query->paginate(10)
            : $query->limit(10)->get();

         return Inertia::render('MoodleCourseCatalogue/Index', [
            'catalogues' => MoodleCourseCatalogueCollection::make($data),
            'categories' => CourseCategoryCollection::make(CourseCategory::all()),
        ]);
    }

    /**
     * @return \Inertia\Response
     */

    public function create()
    {
        return Inertia::render('MoodleCourseCatalogue/Create', [
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

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
