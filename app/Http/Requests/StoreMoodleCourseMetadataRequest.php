<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoodleCourseMetadataRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'course_id' => 'required|integer',
            'course_name_en' => 'required|string',
            'course_name_fr' => 'required|string',
            'description_en' => 'required|string',
            'description_fr' => 'required|string',
            'category_id' => 'required|integer|exists:course_categories,id',
            'language_ids' => 'required|array',
            'publish_date' => 'required|date',
            'presenters' => 'array',
            'presenters.*' => 'string',
            'keywords_en' => 'array',
            'keywords_en.*' => 'string',
            'keywords_fr' => 'array',
            'keywords_fr.*' => 'string',
            'min_estimated_time' => 'required',
            'objectives_topics' => 'required|array',
        ];
    }

    public function getPayload() : array
    {
        return array_merge($this->validated(), [
            'minimum_estimated_time' => $this->getMinEstimatedTimeInMinutes(),
            'maximum_estimated_time' => $this->getMaxEstimatedTimeInMinutes(),
        ]);
    }

    public function getMinEstimatedTimeInMinutes() : int
    {
        $time = $this->get('min_estimated_time');

        return intval($time['days'] * 24 * 60 + $time['hours'] * 60 + $time['minutes']);
    }

    public function getMaxEstimatedTimeInMinutes() : int
    {
        $time = $this->get('max_estimated_time');

        return intval($time['days'] * 24 * 60 + $time['hours'] * 60 + $time['minutes']);
    }
}
