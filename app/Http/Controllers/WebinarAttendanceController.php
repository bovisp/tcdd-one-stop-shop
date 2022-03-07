<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebinarAttendanceRequest;
use App\Http\Resources\FiscalYearCollection;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\QuarterCollection;
use App\Models\Support\FiscalYear;
use App\Models\Support\Language;
use App\Models\Support\Quarter;
use App\Models\Webinar;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class WebinarAttendanceController extends Controller
{
    public function create()
    {
        return Inertia::render('WebinarAttendance/Create', [
            'fiscal_years' => FiscalYearCollection::make(FiscalYear::all()),
            'languages' => LanguageCollection::make(Language::all()),
            'quarters' => QuarterCollection::make(Quarter::all()),
        ]);
    }

    public function store(StoreWebinarAttendanceRequest $request)
    {
        $webinar = Webinar::query()->create($request->except('attendance'));

        $attendances = $request->get('attendance');

        foreach($attendances as $attendance) {
            $webinar->attendance()->create($attendance);
        }

        return Redirect::route('webinar-attendance.dashboard');
    }
}
