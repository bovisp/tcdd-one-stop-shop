<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MoodleMediaCollection extends ResourceCollection
{
    public $collects = MoodleMediaResource::class;
}
