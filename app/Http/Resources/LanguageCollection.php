<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LanguageCollection extends ResourceCollection
{
    /** @var string */
    public $collects = LanguageResource::class;
}
