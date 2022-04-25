<?php

namespace App\Repositories;

use App\Values\MoodleCompletionFilter;
use Illuminate\Support\Collection;

interface ExternalCourseContract
{
    public function getCourseViewsByFiscalYear(MoodleCompletionFilter $filters) : Collection;
    public function getCourseViewsByLanguage(MoodleCompletionFilter $filters) : Collection;
    public function getCourseViewsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection;
    public function getTopFiveCourses(MoodleCompletionFilter $filters) : Collection;
    public function getCompletionsByFiscalYear(MoodleCompletionFilter $filters) : Collection;
    public function getCompletionsByLanguage(MoodleCompletionFilter $filters) : Collection;
    public function getCompletionsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection;
    public function getTopFiveCompletedCourses(MoodleCompletionFilter $filters) : Collection;

}
