<?php

namespace App\Repositories;

use App\Models\MoodleCourseMetadata;
use App\Models\Support\Language;
use App\Values\MoodleCompletionFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MoodleDatabaseRepository implements MoodleRepositoryContract
{

    public function getCourseViewsByFiscalYear(MoodleCompletionFilter $filters) : Collection
    {
        return DB::connection('moodle')
            ->table('mdl_logstore_standard_log AS l')
            ->selectRaw('count(l.id) as total')
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(l.timecreated))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated))-1,'-',YEAR(FROM_UNIXTIME(l.timecreated))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated)),'-',YEAR(FROM_UNIXTIME(l.timecreated))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->leftJoin('mdl_role_assignments as a', function ($join) {
                $join->on('l.contextid', '=', 'a.contextid')
                    ->on('l.userid', '=', 'a.userid');
            })
            ->join('mdl_course AS c', 'l.courseid', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('l.target', '=', 'course')
            ->where('l.action', '=', 'viewed')
            ->where('l.courseid', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->where(function($q) {
                $q->whereIn('a.roleid', [5, 6, 7])->orWhere('l.userid', '=', 1);
            })
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
        $views = DB::connection('moodle')
            ->table('mdl_logstore_standard_log AS l')
            ->select('l.courseid', DB::raw('count(l.id) as total'))
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(l.timecreated))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated))-1,'-',YEAR(FROM_UNIXTIME(l.timecreated))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated)),'-',YEAR(FROM_UNIXTIME(l.timecreated))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->leftJoin('mdl_role_assignments as a', function ($join) {
                $join->on('l.contextid', '=', 'a.contextid')
                    ->on('l.userid', '=', 'a.userid');
            })
            ->join('mdl_course AS c', 'l.courseid', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('l.target', '=', 'course')
            ->where('l.action', '=', 'viewed')
            ->where('l.courseid', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->where(function($q) {
                $q->whereIn('a.roleid', [5, 6, 7])->orWhere('l.userid', '=', 1);
            })
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
            ->groupBy('l.courseid')
            ->get();


        return Language::query()
            ->with('courses')
            ->get()
            ->map(function ($language) use ($views) {
                return [
                    'name' => $language->name,
                    'total' => $views->whereIn('courseid', $language->courses->pluck('course_id'))
                        ->sum('total')
                ];
            })
            ->pluck('total', 'name');
    }

    public function getCourseViewsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection
    {
        return DB::connection('moodle')
            ->table('mdl_logstore_standard_log AS l')
            ->selectRaw('count(l.id) as total')
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(l.timecreated))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated))-1,'-',YEAR(FROM_UNIXTIME(l.timecreated))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated)),'-',YEAR(FROM_UNIXTIME(l.timecreated))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->leftJoin('mdl_role_assignments as a', function ($join) {
                $join->on('l.contextid', '=', 'a.contextid')
                    ->on('l.userid', '=', 'a.userid');
            })
            ->join('mdl_course AS c', 'l.courseid', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('l.target', '=', 'course')
            ->where('l.action', '=', 'viewed')
            ->where('l.courseid', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->where(function($q) {
                $q->whereIn('a.roleid', [5, 6, 7])->orWhere('l.userid', '=', 1);
            })
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
        $views = DB::connection('moodle')
            ->table('mdl_logstore_standard_log AS l')
            ->select(['l.courseid', DB::raw('count(l.id) as total')])
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(l.timecreated))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated))-1,'-',YEAR(FROM_UNIXTIME(l.timecreated))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(l.timecreated)),'-',YEAR(FROM_UNIXTIME(l.timecreated))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(l.timecreated)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->leftJoin('mdl_role_assignments as a', function ($join) {
                $join->on('l.contextid', '=', 'a.contextid')
                    ->on('l.userid', '=', 'a.userid');
            })
            ->join('mdl_course AS c', 'l.courseid', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('l.target', '=', 'course')
            ->where('l.action', '=', 'viewed')
            ->where('l.courseid', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->where(function($q) {
                $q->whereIn('a.roleid', [5, 6, 7])->orWhere('l.userid', '=', 1);
            })
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
            ->groupBy('l.courseid')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return $views->map(function ($view) {
            $names = MoodleCourseMetadata::query()
                ->select(['course_name_en', 'course_name_fr'])
                ->where('course_id', '=', $view->courseid)
                ->first();

            return [
                'name' => $names
                    ? $names->course_name_en . ' / ' . $names->course_name_fr
                    : 'ID #' . $view->courseid,
                'total' => $view->total
            ];
        })->pluck('total', 'name');
    }
}
