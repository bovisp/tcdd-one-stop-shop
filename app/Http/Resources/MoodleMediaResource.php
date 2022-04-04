<?php

namespace App\Http\Resources;

use App\Models\MoodleMedia;
use App\Values\MediaUrl;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MoodleMedia
 */
class MoodleMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'media' => (new MediaUrl($this->media))->__toString(),
            'license_id' => $this->license_id,
            'keywords' => $this->keywords,
            'moodleMediaLicense' => [
                'en' => optional($this->moodleMediaLicense)->name['english'] ?? '',
                'fr' => optional($this->moodleMediaLicense)->name['french'] ?? '',
            ],
        ];
    }
}
