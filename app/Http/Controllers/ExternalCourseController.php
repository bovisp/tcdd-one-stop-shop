<?php

namespace App\Http\Controllers;

use App\Imports\Comet\ExternalCourseImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ExternalCourseController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function create()
    {
         return Inertia::render('ExternalCourse/Create');
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('max_input_time', 300);

        $this->validate($request, array(
            'externalCourse'   => 'max:10240|required|mimes:csv,xlsx',
        ));

        $courseFile = $request->externalCourse;

        $file =  (new ExternalCourseImport())
            ->import($courseFile, 'local', \Maatwebsite\Excel\Excel::XLSX);

        return Redirect::route('external-course.dashboard');
    }
}
