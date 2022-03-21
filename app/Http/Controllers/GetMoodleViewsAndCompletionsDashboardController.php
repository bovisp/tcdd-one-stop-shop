<?php

namespace App\Http\Controllers;

use App\Http\Resources\FiscalYearCollection;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\QuarterCollection;
use App\Models\Support\FiscalYear;
use App\Models\Support\Language;
use App\Models\Support\Quarter;
use App\Repositories\MoodleRepositoryContract;
use App\Values\MoodleCompletionFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GetMoodleViewsAndCompletionsDashboardController extends Controller
{
    /** @var MoodleRepositoryContract */
    private $repo;

    public function __construct(MoodleRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(Request $request)
    {
        $filters = MoodleCompletionFilter::fromRequest($request);

        return Inertia::render('MoodleViewsCompletions/Dashboard', [
            'views' => [
                'by_fiscal_year' => $this->repo->getCourseViewsByFiscalYear($filters)->toArray(),
                'by_fy_and_quarter' => $this->repo->getCourseViewsByFiscalYearAndQuarter($filters)->toArray(),
                'by_language' => $this->repo->getCourseViewsByLanguage($filters)->toArray(),
                'top_five' => $this->repo->getTopFiveCourses($filters)->toArray(),
            ],
            'completions' => [
                // TODO: get queries for completions
                'by_fiscal_year' => [],
                'by_fy_and_quarter' => [],
                'by_language' => [],
                'top_five' => [],
            ],
            'meta' => [
                'fiscal_years' => FiscalYearCollection::make(FiscalYear::all()),
                'languages' => LanguageCollection::make(Language::all()),
                'quarters' => QuarterCollection::make(Quarter::all()),
                'filters' => [
                    'fiscal_years' => $filters->getFiscalYears() ?? [],
                    'quarters' => $filters->getQuarters() ?? [],
                    'languages' => $filters->getLanguages() ?? [],
                    'subject' => $filters->getSubject() ?? 'views',
                ]
            ]
        ]);
    }
}
