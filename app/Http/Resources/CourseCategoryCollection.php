<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCategoryCollection extends ResourceCollection
{
    /** @var string */
    public $collects = CourseCategoryResource::class;
}
