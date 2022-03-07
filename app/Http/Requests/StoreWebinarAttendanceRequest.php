<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebinarAttendanceRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'fiscal_year_id'           => 'required|numeric|exists:fiscal_years,id',
            'quarter_id'               => 'required|numeric|exists:quarters,id',
            'attendance'               => 'required|array',
            'attendance.*.language_id' => 'required|numeric|exists:languages,id',
            'attendance.*.name'        => 'required|string',
            'attendance.*.attendance'  => 'required|numeric',
        ];
    }
}
