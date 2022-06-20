<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCourseView extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson',
        'language_id',
        'session',
        'date',
    ];

    protected $visible = [
        'lesson',
        'language_id',
        'session',
        'date',
    ];
}
