<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCourseCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson',
        'language_id',
        'date_completed',
    ];

    protected $visible = [
        'lesson',
        'language_id',
        'date_completed',
    ];
}
