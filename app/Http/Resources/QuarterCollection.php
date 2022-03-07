<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuarterCollection extends ResourceCollection
{
    /** @var string */
    public $collects = QuarterResource::class;
}
