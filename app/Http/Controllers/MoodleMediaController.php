<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoodleMediaRequest;
use App\Http\Resources\MoodleMediaCollection;
use App\Http\Resources\MoodleMediaLicenseCollection;
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
     * @return \Inertia\Response
     */

    public function index()
    {
        return Inertia::render('MoodleMedia/Index', [
            'media' => MoodleMediaCollection::make(MoodleMedia::all()),
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

        MoodleMedia::query()->where('id', '=', $moodleMedia)->update(array_merge($request->getPayload(),[
            'media' => $filename
        ]));

        return Redirect::route('moodle-media.index');

    }
}
