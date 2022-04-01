<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoodleMediaRequest;
use App\Http\Resources\MoodleMediaCollection;
use App\Http\Resources\MoodleMediaLicenseCollection;
use App\Http\Resources\MoodleMediaResource;
use App\Models\MoodleMedia;
use App\Models\MoodleMediaLicense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;


class MoodleMediaController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('MoodleMedia/Create', [
            'licenses' => MoodleMediaLicenseCollection::make(MoodleMediaLicense::all()),
        ]);
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $query = MoodleMedia::with('moodleMediaLicense');

        $data = $request->get('page') !== '0'
            ? $query->paginate(10)
            : $query->limit(10)->get();

        return Inertia::render('MoodleMedia/Index', [
            'media' => MoodleMediaCollection::make($data),
        ]);
    }

    public function edit($id)
    {
        $metadata = MoodleMedia::where('id', '=', $id)->first();

        return Inertia::render('MoodleMedia/Edit', [
            'metadata' => MoodleMediaResource::make($metadata)
        ]);
    }

    /**
     * @param StoreMoodleMediaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMoodleMediaRequest $request)
    {
        $filename = Str::uuid() . '.' . $request->file('media')->extension();

        $request->getFile()->storeAs('media', $filename);

        MoodleMedia::create(array_merge($request->getPayload(), [
            'media' => $filename
        ]));

        return Redirect::route('moodle-media.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        MoodleMedia::where('id', '=', $id)->delete();

        return Redirect::route('moodle-media.index');
    }

    /**
     * @param StoreMoodleMediaRequest $request
     * @param $moodleMedia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreMoodleMediaRequest $request, $moodleMedia)
    {
        $filename = Str::uuid() . '.' . $request->getFile()->getClientOriginalExtension();

        $request->getFile()->storeAs('media', $filename);

        MoodleMedia::query()
            ->where('id', '=', $moodleMedia)
            ->update(array_merge($request->getPayload(), [
                'media' => $filename
            ]));

        return Redirect::route('moodle-media.index');
    }
}
