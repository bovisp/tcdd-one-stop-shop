<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseMetadataCollection extends ResourceCollection
{
    /** @var string */
    public $collects = CourseMetadataResource::class;
}
