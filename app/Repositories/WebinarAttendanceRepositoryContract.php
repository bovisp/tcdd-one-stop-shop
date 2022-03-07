<?php

namespace App\Repositories;

use App\Values\WebinarAttendanceFilter;

interface WebinarAttendanceRepositoryContract
{
    public function getWebinarAttendanceByFiscalYear(WebinarAttendanceFilter $filters) : array;
    public function getWebinarAttendanceByFiscalYearAndQuarter(WebinarAttendanceFilter $filters) : array;
    public function getWebinarAttendanceByLanguage(WebinarAttendanceFilter $filters) : array;
    public function getTopFiveAttendances(WebinarAttendanceFilter $filters) : array;
}
