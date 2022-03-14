<?php

namespace App\Repositories;

use App\Models\WebinarAttendance;
use App\Values\WebinarAttendanceFilter;

class EloquentWebinarAttendanceRepository implements WebinarAttendanceRepositoryContract
{
    public function getWebinarAttendanceByFiscalYear(WebinarAttendanceFilter $filters) : array
    {
        return WebinarAttendance::query()
            ->join('webinars AS w', 'w.id', 'webinars_attendance.webinar_id')
            ->join('fiscal_years AS fy', 'fy.id', 'w.fiscal_year_id')
            ->when($filters->getFiscalYears(), function ($query, $fiscalYears) {
                $query->whereIn('w.fiscal_year_id', $fiscalYears);
            })
            ->when($filters->getQuarters(), function ($query, $quarters) {
                $query->whereIn('w.quarter_id', $quarters);
            })
            ->when($filters->getLanguages(), function ($query, $languages) {
                $query->whereIn('webinars_attendance.language_id', $languages);
            })
            ->groupBy('w.fiscal_year_id')
            ->orderBy('fy.name')
            ->select('fy.name')
            ->selectRaw('sum(attendance) AS total')
            ->get()
            ->pluck('total','name')
            ->map(function ($value) {
                return intval($value);
            })
            ->sortBy('name')
            ->toArray();
    }

    public function getWebinarAttendanceByLanguage(WebinarAttendanceFilter $filters) : array
    {
        return WebinarAttendance::query()
            ->join('webinars AS w', 'w.id', 'webinars_attendance.webinar_id')
            ->join('languages AS l', 'l.id', 'webinars_attendance.language_id')
            ->when($filters->getFiscalYears(), function ($query, $fiscalYears) {
                $query->whereIn('w.fiscal_year_id', $fiscalYears);
            })
            ->when($filters->getQuarters(), function ($query, $quarters) {
                $query->whereIn('w.quarter_id', $quarters);
            })
            ->when($filters->getLanguages(), function ($query, $languages) {
                $query->whereIn('webinars_attendance.language_id', $languages);
            })
            ->groupBy('webinars_attendance.language_id')
            ->select('l.name')
            ->selectRaw('sum(attendance) AS total')
            ->get()
            ->pluck('total','name')
            ->map(function ($value) {
                return intval($value);
            })
            ->toArray();
    }

    public function getTopFiveAttendances(WebinarAttendanceFilter $filters) : array
    {
        return WebinarAttendance::query()
            ->join('webinars AS w', 'w.id', 'webinars_attendance.webinar_id')
            ->when($filters->getFiscalYears(), function ($query, $fiscalYears) {
                $query->whereIn('w.fiscal_year_id', $fiscalYears);
            })
            ->when($filters->getQuarters(), function ($query, $quarters) {
                $query->whereIn('w.quarter_id', $quarters);
            })
            ->when($filters->getLanguages(), function ($query, $languages) {
                $query->whereIn('webinars_attendance.language_id', $languages);
            })
            ->groupBy('webinars_attendance.id')
            ->select('webinars_attendance.name')
            ->selectRaw('sum(attendance) AS total')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'name')
            ->take(5)
            ->map(function ($value) {
                return intval($value);
            })
            ->toArray();
    }

    public function getWebinarAttendanceByFiscalYearAndQuarter(WebinarAttendanceFilter $filters): array
    {
        return WebinarAttendance::query()
            ->join('webinars AS w', 'w.id', 'webinars_attendance.webinar_id')
            ->join('fiscal_years AS fy', 'fy.id', 'w.fiscal_year_id')
            ->join('quarters AS q', 'q.id', 'w.quarter_id')
            ->when($filters->getFiscalYears(), function ($query, $fiscalYears) {
                $query->whereIn('w.fiscal_year_id', $fiscalYears);
            })
            ->when($filters->getQuarters(), function ($query, $quarters) {
                $query->whereIn('w.quarter_id', $quarters);
            })
            ->when($filters->getLanguages(), function ($query, $languages) {
                $query->whereIn('webinars_attendance.language_id', $languages);
            })
            ->groupBy('w.fiscal_year_id', 'w.quarter_id')
            ->select('fy.name AS fiscal_year', 'q.name AS quarter')
            ->selectRaw('sum(attendance) AS total')
            ->get()
            ->map(function ($attendance) {
                return [
                    'fiscal_year' => $attendance['fiscal_year'],
                    'quarter' => $attendance['quarter'],
                    'total' => intval($attendance['total']),
                ];
            })
            ->sortBy([
                'fiscal_year' => 'ASC',
                'quarter' => 'ASC'
            ])
            ->toArray();
    }
}
