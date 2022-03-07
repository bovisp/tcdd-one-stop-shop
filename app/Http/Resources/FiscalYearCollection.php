<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FiscalYearCollection extends ResourceCollection
{
    /** @var string */
    public $collects = FiscalYearResource::class;
}
