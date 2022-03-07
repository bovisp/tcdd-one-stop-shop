<?php

namespace App\Http\Controllers;

use App\Http\Resources\FiscalYearCollection;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\QuarterCollection;
use App\Models\Support\FiscalYear;
use App\Models\Support\Language;
use App\Models\Support\Quarter;
use App\Repositories\WebinarAttendanceRepositoryContract;
use App\Values\WebinarAttendanceFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GetWebinarDashboardController extends Controller
{
    /** @var WebinarAttendanceRepositoryContract */
    private $repo;

    public function __construct(WebinarAttendanceRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(Request $request)
    {
        $filters = WebinarAttendanceFilter::fromRequest($request);

        return Inertia::render('WebinarAttendance/Dashboard', [
            'attendance' => [
                'by_fiscal_year' => $this->repo->getWebinarAttendanceByFiscalYear($filters),
                'by_fy_and_quarter' => $this->repo->getWebinarAttendanceByFiscalYearAndQuarter($filters),
                'by_language' => $this->repo->getWebinarAttendanceByLanguage($filters),
                'top_five' => $this->repo->getTopFiveAttendances($filters),
            ],
            'meta' => [
                'fiscal_years' => FiscalYearCollection::make(FiscalYear::all()),
                'languages' => LanguageCollection::make(Language::all()),
                'quarters' => QuarterCollection::make(Quarter::all()),
                'filters' => [
                    'fiscal_years' => $filters->getFiscalYears() ?? [],
                    'quarters' => $filters->getQuarters() ?? [],
                    'languages' => $filters->getLanguages() ?? []
                ]
            ]
        ]);
    }
}
