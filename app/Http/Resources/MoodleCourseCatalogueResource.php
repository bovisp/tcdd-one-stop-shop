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
            'categories' =>  $this->courseCategories->map(function ($category) {
                return [
                    'en' => $category->category_name['english'] ?? '',
                    'fr' => $category->category_name['french'] ?? '',
                ];
            })
        ];
    }
}
