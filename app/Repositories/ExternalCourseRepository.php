<?php

namespace App\Repositories;

use App\Models\Support\Language;
use App\Values\MoodleCompletionFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExternalCourseRepository implements ExternalCourseContract
{

    public function getCourseViewsByFiscalYear(MoodleCompletionFilter $filters) : Collection
    {
        return DB::table('external_course_views')
            ->selectRaw('sum(session) as total')
            ->selectRaw("CASE WHEN (MONTH(date)) <= 3 THEN CONCAT('FY',YEAR(date)-1,'-',YEAR(date)) ELSE CONCAT('FY',YEAR(date),'-',YEAR(date)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->groupBy('fiscal_year')
            ->get()
            ->pluck('total', 'fiscal_year');
    }

    public function getCourseViewsByLanguage(MoodleCompletionFilter $filters) : Collection
    {
        $views = DB::table('external_course_views')
            ->select('language_id')
            ->selectRaw('sum(session) as total')
            ->selectRaw("CASE WHEN (MONTH(date)) <= 3 THEN CONCAT('FY',YEAR(date)-1,'-',YEAR(date)) ELSE CONCAT('FY',YEAR(date),'-',YEAR(date)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->when($filters->getLanguages(), function ($query) use ($filters) {
                $query->whereIn('language_id', $filters->getLanguages());
            })
            ->groupBy('language_id')
            ->get();

        return Language::query()
            ->with('externalCourseViews')
            ->get()
            ->map(function ($language) use ($views) {
                return [
                    'name' => $language->name,
                    'total' => $views->whereIn('language_id', $language->externalCourseViews->pluck('language_id'))
                        ->sum('total')
                ];
            })
            ->pluck('total', 'name');
    }

    public function getCourseViewsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection
    {
        return DB::table('external_course_views')
            ->selectRaw('sum(session) as total')
            ->selectRaw("CASE WHEN (MONTH(date)) <= 3 THEN CONCAT('FY',YEAR(date)-1,'-',YEAR(date)) ELSE CONCAT('FY',YEAR(date),'-',YEAR(date)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date) IN (10,11,12) THEN 'Q3' END AS quarter")

            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->groupBy('fiscal_year', 'quarter')
            ->orderBy('fiscal_year')
            ->orderBy('quarter')
            ->get();
    }

    public function getTopFiveCourses(MoodleCompletionFilter $filters) : Collection
    {
        $views = DB::table('external_course_views')
            ->select('lesson as name')
            ->selectRaw('sum(session) as total, id')
            ->selectRaw("CASE WHEN (MONTH(date)) <= 3 THEN CONCAT('FY',YEAR(date)-1,'-',YEAR(date)) ELSE CONCAT('FY',YEAR(date),'-',YEAR(date)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date) IN (10,11,12) THEN 'Q3' END AS quarter")

            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->when($filters->getLanguages(), function ($query) use ($filters) {
                $query->whereIn('language_id', $filters->getLanguages());
            })
            ->groupBy('lesson')
            ->orderByDesc('total')
            ->take(5);

        return $views->pluck('total', 'name');
    }

    public function getCompletionsByFiscalYear(MoodleCompletionFilter $filters) : Collection
    {
        return DB::table('external_course_completions')
            ->selectRaw('count(id) as total')
            ->selectRaw("CASE WHEN (MONTH(date_completed)) <= 3 THEN CONCAT('FY',YEAR(date_completed)-1,'-',YEAR(date_completed)) ELSE CONCAT('FY',YEAR(date_completed),'-',YEAR(date_completed)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date_completed) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date_completed) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date_completed) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date_completed) IN (10,11,12) THEN 'Q3' END AS quarter")

            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->groupBy('fiscal_year')
            ->get()
            ->pluck('total', 'fiscal_year');

    }

    public function getCompletionsByLanguage(MoodleCompletionFilter $filters) : Collection
    {
        $completions = DB::table('external_course_completions')
            ->selectRaw('count(id) as total, language_id')
            ->selectRaw("CASE WHEN (MONTH(date_completed)) <= 3 THEN CONCAT('FY',YEAR(date_completed)-1,'-',YEAR(date_completed)) ELSE CONCAT('FY',YEAR(date_completed),'-',YEAR(date_completed)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date_completed) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date_completed) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date_completed) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date_completed) IN (10,11,12) THEN 'Q3' END AS quarter")

            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->when($filters->getLanguages(), function ($query) use ($filters) {
                $query->whereIn('language_id', $filters->getLanguages());
            })
            ->groupBy('language_id')
            ->get();

        return Language::query()
            ->with('externalCourseViews')
            ->get()
            ->map(function ($language) use ($completions) {
                return [
                    'name' => $language->name,
                    'total' => $completions
                        ->whereIn('language_id', $language->externalCourseCompletions->pluck('language_id'))
                        ->sum('total')
                ];
            })
            ->pluck('total', 'name');
    }

    public function getCompletionsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection
    {

        return DB::table('external_course_completions')
            ->selectRaw('count(id) as total')
            ->selectRaw("CASE WHEN (MONTH(date_completed)) <= 3 THEN CONCAT('FY',YEAR(date_completed)-1,'-',YEAR(date_completed)) ELSE CONCAT('FY',YEAR(date_completed),'-',YEAR(date_completed)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date_completed) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date_completed) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date_completed) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date_completed) IN (10,11,12) THEN 'Q3' END AS quarter")

            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->groupBy('fiscal_year', 'quarter')
            ->orderBy('fiscal_year')
            ->orderBy('quarter')
            ->get();
    }

    public function getTopFiveCompletedCourses(MoodleCompletionFilter $filters) : Collection
    {
        $completions = DB::table('external_course_completions')
            ->select('lesson as name')
            ->selectRaw('count(id) as total, id')
            ->selectRaw("CASE WHEN (MONTH(date_completed)) <= 3 THEN CONCAT('FY',YEAR(date_completed)-1,'-',YEAR(date_completed)) ELSE CONCAT('FY',YEAR(date_completed),'-',YEAR(date_completed)) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(date_completed) IN (1,2,3) THEN 'Q4' WHEN QUARTER(date_completed) IN (4,5,6) THEN 'Q1' WHEN QUARTER(date_completed) IN (7,8,9) THEN 'Q2' WHEN QUARTER(date_completed) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->when($filters->getQuarters(), function ($query) use ($filters) {
                foreach ($filters->getQuarters() as $key => $quarter) {
                    $key === 0
                        ? $query->having('quarter', '=', $quarter)
                        : $query->orHaving('quarter', '=', $quarter);
                }
            })
            ->when($filters->getFiscalYears(), function ($query) use ($filters) {
                foreach ($filters->getFiscalYears() as $key => $fiscalYear) {
                    $key === 0
                        ? $query->having('fiscal_year', '=', $fiscalYear)
                        : $query->orHaving('fiscal_year', '=', $fiscalYear);
                }
            })
            ->when($filters->getLanguages(), function ($query) use ($filters) {
                $query->whereIn('language_id', $filters->getLanguages());
            })
            ->groupBy('lesson')
            ->orderByDesc('total')
            ->take(5);

        return $completions->pluck('total', 'name');
    }
}
