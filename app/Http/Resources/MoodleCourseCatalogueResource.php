<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoodleCourseCatalogueResource extends JsonResource
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
            'language' => $this->language,
            'publish_date' => $this->publish_date,
            'completion_time' =>$this->completion_time,
            'category_id' => $this->category->id ?? '',
            'category' => [
                'en' => optional($this->category)->category_name['english'] ?? '',
                'fr' => optional($this->category)->category_name['french'] ?? '',
            ],
        ];
    }
}
