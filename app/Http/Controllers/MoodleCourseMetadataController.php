<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoodleCourseMetadataRequest;
use App\Http\Resources\CourseCategoryCollection;
use App\Http\Resources\CourseMetadataCollection;
use App\Http\Resources\CourseMetadataResource;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\MdlCourseCollection;
use App\Models\CourseCategory;
use App\Models\Moodle\MdlCourse;
use App\Models\MoodleCourseMetadata;
use App\Models\Support\Language;
use Illuminate\Http\Request;
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

    public function edit($id)
    {
        $metadata = MoodleCourseMetadata::where('id', '=', $id)->first();

        return Inertia::render('MoodleCourse/Edit', [
            'mdl_courses' => MdlCourseCollection::make(MdlCourse::all()),
            'categories' => CourseCategoryCollection::make(CourseCategory::all()),
            'languages' => LanguageCollection::make(Language::all()),
            'metadata' => CourseMetadataResource::make($metadata)
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

    public function update(StoreMoodleCourseMetadataRequest $request, $id)
    {
        $metadata = MoodleCourseMetadata::query()
            ->where('id', '=', $id)
            ->first();

        $metadata->update($request->getPayload());

        $languages = $request->get('language_ids');

        foreach ($languages as $language) {
            $metadata->languages()->update(['language_id' => $language]);
        }

        return Redirect::route('moodle-courses.index');
    }

    public function index(Request $request)
    {
        $query = MoodleCourseMetadata::query();

        $data = $request->get('page') !== '0'
            ? $query->paginate(10)
            : $query->limit(10)->get();

        return Inertia::render('MoodleCourse/Index', [
            'courses' => CourseMetadataCollection::make($data),
        ]);
    }

    public function destroy($id)
    {
        MoodleCourseMetadata::where('id', '=', $id)->delete();

        return Redirect::route('moodle-courses.index');
    }
}
