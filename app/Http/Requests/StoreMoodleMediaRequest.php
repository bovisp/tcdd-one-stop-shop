<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoodleMediaRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'title_en' => 'required',
            'title_fr' => 'required',
            'description_en' => 'required',
            'description_fr' => 'required',
            'media' => 'required',
            'license_id' => 'required',
            'keywords_en' => 'required',
            'keywords_fr' => 'required',
        ];
    }

    public function getPayload() : array
    {
        return [
            'title' => [
                'english' => $this->get('title_en'),
                'french' => $this->get('title_fr'),
            ],
            'license_id' => $this->get('license_id'),
            'keywords' => [
                'english' => $this->get('keywords_en'),
                'french' => $this->get('keywords_fr'),
            ],
            'description' => [
                'english' => $this->get('description_en'),
                'french' => $this->get('description_fr')
            ],
        ];
    }

    public function getFile()
    {
        return $this->file('media');
    }
}
