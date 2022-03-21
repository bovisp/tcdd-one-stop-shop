<?php

namespace App\Repositories;

use App\Values\MoodleCompletionFilter;
use Illuminate\Support\Collection;

interface MoodleRepositoryContract
{
    public function getCourseViewsByFiscalYear(MoodleCompletionFilter $filters) : Collection;
    public function getCourseViewsByLanguage(MoodleCompletionFilter $filters) : Collection;
    public function getCourseViewsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection;
    public function getTopFiveCourses(MoodleCompletionFilter $filters) : Collection;

}
