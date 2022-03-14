<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoodleCourseMetadataRequest;
use App\Http\Resources\CourseCategoryCollection;
use App\Http\Resources\CourseMetadataCollection;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\MdlCourseCollection;
use App\Models\CourseCategory;
use App\Models\Moodle\MdlCourse;
use App\Models\MoodleCourseMetadata;
use App\Models\Support\Language;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MoodleCourseMetadataController extends Controller
{
    public function create()
    {
        return Inertia::render('MoodleCourse/Create', [
            'mdl_courses' => MdlCourseCollection::make(MdlCourse::all()),
            'categories' => CourseCategoryCollection::make(CourseCategory::all()),
            'languages' => LanguageCollection::make(Language::all()),
        ]);
    }

    public function store(StoreMoodleCourseMetadataRequest $request)
    {
        $metadata = MoodleCourseMetadata::query()->create($request->getPayload());

        $languages = $request->get('language_ids');

        foreach ($languages as $language) {
            $metadata->languages()->create(['language_id' => $language]);
        }

        return Redirect::route('moodle-courses.index');
    }

    public function index()
    {
        return Inertia::render('MoodleCourse/Index', [
            'courses' => CourseMetadataCollection::make(MoodleCourseMetadata::all()),
        ]);
    }

    public function destroy($id)
    {
        MoodleCourseMetadata::where('id', '=', $id)->delete();

        return Redirect::route('moodle-courses.index');
    }
}
