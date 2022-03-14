<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MdlCourseCollection extends ResourceCollection
{
    /** @var string */
    public $collects = MdlCourseResource::class;
}
