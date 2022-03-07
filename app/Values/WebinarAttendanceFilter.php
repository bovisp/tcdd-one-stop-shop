<?php

namespace App\Values;

use Illuminate\Http\Request;

class WebinarAttendanceFilter
{
    /** @var array|null */
    private $fiscalYears;

    /** @var array|null */
    private $quarters;

    /** @var array|null */
    private $languages;

    public function __construct(?array $fiscalYears = [], ?array $quarters = [], ?array $languages = [])
    {
        $this->fiscalYears = $fiscalYears;
        $this->quarters = $quarters;
        $this->languages = $languages;
    }

    public static function fromRequest(Request $request) : self
    {
        return new self(
            $request->get('fiscalYear')
                ? explode(',', $request->get('fiscalYear'))
                : [],
                $request->get('quarter')
                    ? explode(',', $request->get('quarter'))
                    : [],
            $request->get('language')
                ? explode(',', $request->get('language'))
                : []
        );
    }

    public function getFiscalYears() : ?array
    {
        return array_map('intval', $this->fiscalYears);
    }

    public function getQuarters() : ?array
    {
        return array_map('intval', $this->quarters);
    }

    public function getLanguages() : ?array
    {
        return array_map('intval', $this->languages);
    }
}
