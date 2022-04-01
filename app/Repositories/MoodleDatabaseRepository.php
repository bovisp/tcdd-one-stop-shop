<?php

namespace App\Repositories;

use App\Models\Badge;
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

    public function getCompletionsByFiscalYear(MoodleCompletionFilter $filters) : Collection
    {
        $badgeCompletions = collect([]);

        if ($badgesToFilter = Badge::all()->pluck('moodle_id')->toArray()) {
            $badgeCompletions = DB::connection('moodle')
                ->table('mdl_badge_issued AS i')
                ->selectRaw('count(i.id) as total')
                ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(i.dateissued))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued))-1,'-',YEAR(FROM_UNIXTIME(i.dateissued))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued)),'-',YEAR(FROM_UNIXTIME(i.dateissued))%100+1) END AS fiscal_year")
                ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (10,11,12) THEN 'Q3' END AS quarter")
                ->join('mdl_badge AS b', 'i.badgeid', '=', 'i.id')
                ->join('mdl_course AS c', 'b.courseid', '=', 'c.id')
                ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
                ->where('b.courseid', '<>', 1)
                ->where('c.category', '<>', 29)
                ->where('c.visible', '<>', 0)
                ->whereIn('i.badgeid', $badgesToFilter)
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

        $courseCompletions = DB::connection('moodle')
            ->table('mdl_course_completions AS comp')
            ->selectRaw('count(comp.id) as total')
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(comp.timecompleted))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted))-1,'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted)),'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->join('mdl_course AS c', 'comp.course', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('comp.course', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->whereNotNull('comp.timecompleted')
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

        $completions = collect([]);

        $badgeCompletions->merge($courseCompletions)
            ->keys()
            ->each(function ($key) use ($completions, $badgeCompletions, $courseCompletions) {
                $completions->put($key, $badgeCompletions->get($key) + $courseCompletions->get($key));
        });

        return $completions;
    }

    public function getCompletionsByLanguage(MoodleCompletionFilter $filters) : Collection
    {
        $badgeCompletions = collect([]);

        if ($badgesToFilter = Badge::all()->pluck('moodle_id')->toArray()) {
            $badgeCompletions = DB::connection('moodle')
                ->table('mdl_badge_issued AS i')
                ->select('b.courseid', DB::raw('count(i.id) as total'))
                ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(i.dateissued))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued))-1,'-',YEAR(FROM_UNIXTIME(i.dateissued))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued)),'-',YEAR(FROM_UNIXTIME(i.dateissued))%100+1) END AS fiscal_year")
                ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (10,11,12) THEN 'Q3' END AS quarter")
                ->join('mdl_badge AS b', 'i.badgeid', '=', 'i.id')
                ->join('mdl_course AS c', 'b.courseid', '=', 'c.id')
                ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
                ->where('b.courseid', '<>', 1)
                ->where('c.category', '<>', 29)
                ->where('c.visible', '<>', 0)
                ->whereIn('i.badgeid', $badgesToFilter)
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
                ->groupBy('b.courseid')
                ->get();
        }

        $courseCompletions = DB::connection('moodle')
            ->table('mdl_course_completions AS comp')
            ->select('comp.course as courseid', DB::raw('count(comp.id) as total'))
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(comp.timecompleted))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted))-1,'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted)),'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->join('mdl_course AS c', 'comp.course', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('comp.course', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->whereNotNull('comp.timecompleted')
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
            ->groupBy('comp.course')
            ->get();

        $completions = $badgeCompletions->merge($courseCompletions);

        return Language::query()
            ->with('courses')
            ->get()
            ->map(function ($language) use ($completions) {
                return [
                    'name' => $language->name,
                    'total' => $completions->whereIn('courseid', $language->courses->pluck('course_id'))
                        ->sum('total')
                ];
            })
            ->pluck('total', 'name');
    }

    public function getCompletionsByFiscalYearAndQuarter(MoodleCompletionFilter $filters) : Collection
    {
        $badgeCompletions = collect([]);

        if ($badgesToFilter = Badge::all()->pluck('moodle_id')->toArray()) {
            $badgeCompletions = DB::connection('moodle')
                ->table('mdl_badge_issued AS i')
                ->selectRaw('count(i.id) as total')
                ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(i.dateissued))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued))-1,'-',YEAR(FROM_UNIXTIME(i.dateissued))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued)),'-',YEAR(FROM_UNIXTIME(i.dateissued))%100+1) END AS fiscal_year")
                ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (10,11,12) THEN 'Q3' END AS quarter")
                ->join('mdl_badge AS b', 'i.badgeid', '=', 'i.id')
                ->join('mdl_course AS c', 'b.courseid', '=', 'c.id')
                ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
                ->where('b.courseid', '<>', 1)
                ->where('c.category', '<>', 29)
                ->where('c.visible', '<>', 0)
                ->whereIn('i.badgeid', $badgesToFilter)
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

        $courseCompletions = DB::connection('moodle')
            ->table('mdl_course_completions AS comp')
            ->selectRaw('count(comp.id) as total')
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(comp.timecompleted))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted))-1,'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted)),'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->join('mdl_course AS c', 'comp.course', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('comp.course', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->whereNotNull('comp.timecompleted')
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

        return $badgeCompletions->merge($courseCompletions);
    }

    public function getTopFiveCompletedCourses(MoodleCompletionFilter $filters) : Collection
    {
        $badgeCompletions = collect([]);

        if ($badgesToFilter = Badge::all()->pluck('moodle_id')->toArray()) {
            $badgeCompletions = DB::connection('moodle')
                ->table('mdl_badge_issued AS i')
                ->select('b.courseid', DB::raw('count(i.id) as total'))
                ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(i.dateissued))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued))-1,'-',YEAR(FROM_UNIXTIME(i.dateissued))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(i.dateissued)),'-',YEAR(FROM_UNIXTIME(i.dateissued))%100+1) END AS fiscal_year")
                ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(i.dateissued)) IN (10,11,12) THEN 'Q3' END AS quarter")
                ->join('mdl_badge AS b', 'i.badgeid', '=', 'i.id')
                ->join('mdl_course AS c', 'b.courseid', '=', 'c.id')
                ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
                ->where('b.courseid', '<>', 1)
                ->where('c.category', '<>', 29)
                ->where('c.visible', '<>', 0)
                ->whereIn('i.badgeid', $badgesToFilter)
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
                ->groupBy('b.courseid')
                ->orderByDesc('total')
                ->get();
        }

        $courseCompletions = DB::connection('moodle')
            ->table('mdl_course_completions AS comp')
            ->select('comp.course as courseid', DB::raw('count(comp.id) as total'))
            ->selectRaw("CASE WHEN (MONTH(FROM_UNIXTIME(comp.timecompleted))) <= 3 THEN CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted))-1,'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100) ELSE CONCAT('FY',YEAR(FROM_UNIXTIME(comp.timecompleted)),'-',YEAR(FROM_UNIXTIME(comp.timecompleted))%100+1) END AS fiscal_year")
            ->selectRaw("CASE WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (1,2,3) THEN 'Q4' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (4,5,6) THEN 'Q1' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (7,8,9) THEN 'Q2' WHEN QUARTER(FROM_UNIXTIME(comp.timecompleted)) IN (10,11,12) THEN 'Q3' END AS quarter")
            ->join('mdl_course AS c', 'comp.course', '=', 'c.id')
            ->join('mdl_course_categories AS cc', 'c.category', '=', 'cc.id')
            ->where('comp.course', '<>', 1)
            ->where('c.category', '<>', 29)
            ->where('c.visible', '<>', 0)
            ->whereNotNull('comp.timecompleted')
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
            ->groupBy('comp.course')
            ->orderByDesc('total')
            ->get();

        return $badgeCompletions
            ->merge($courseCompletions)
            ->groupBy('courseid')
            ->map(function ($course) {
                $names = MoodleCourseMetadata::query()
                    ->select(['course_name_en', 'course_name_fr'])
                    ->where('course_id', '=', $course->first()->courseid)
                    ->first();

                return [
                    'name' => $names
                        ? $names->course_name_en . ' / ' . $names->course_name_fr
                        : 'ID #' . $course->first()->courseid,
                    'total' => $course->sum('total')
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values()
            ->pluck('total', 'name');
    }
}
