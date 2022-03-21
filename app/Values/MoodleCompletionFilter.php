<?php

namespace App\Values;

use Illuminate\Http\Request;

class MoodleCompletionFilter
{
    /** @var array|null */
    private $fiscalYears;

    /** @var array|null */
    private $quarters;

    /** @var array|null */
    private $languages;

    /** @var string */
    private $subject;

    public function __construct(string $subject, ?array $fiscalYears = [], ?array $quarters = [], ?array $languages = [])
    {
        $this->subject = $subject;
        $this->fiscalYears = $fiscalYears;
        $this->quarters = $quarters;
        $this->languages = $languages;
    }

    public static function fromRequest(Request $request) : self
    {
        return new self(
            $request->get('subject') ?? 'views',
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
        return $this->fiscalYears;
    }

    public function getQuarters() : ?array
    {
        return $this->quarters;
    }

    public function getLanguages() : ?array
    {
        return array_map('intval', $this->languages);
    }

    public function getSubject() : string
    {
        return $this->subject;
    }
}
