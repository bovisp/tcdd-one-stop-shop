<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\MoodleCourseMetadata
 */
class CourseMetadataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'course_name_en' => $this->course_name_en,
            'course_name_fr' => $this->course_name_fr,
            'publish_date' => $this->publish_date,
            'description_en' => $this->description_en,
            'description_fr' => $this->description_fr,
            'category' => [
                'en' => $this->category->category_name['english'],
                'fr' => $this->category->category_name['french'],
            ],
            'language_ids' => $this->languages->map(function ($language) {
                return $language->language_id;
            }),
            'languages' => $this->languages->map(function ($language) {
                return $language->language->name;
            }),
            'category_id' => $this->category->id,
            'presenters' => $this->presenters,
            'keywords_en' => $this->keywords_en,
            'keywords_fr' => $this->keywords_fr,
            'min_estimated_time' => $this->getMinimumTimeInDays(),
            'max_estimated_time' => $this->getMaximumTimeInDays(),
            'objectives_topics' => $this->objectives_topics,
        ];
    }
}
