<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCourseCompletion extends Model
{
    use HasFactory;

    protected $table = 'external_course_completions';
    protected $fillable = [
        'lesson','language','date_completed'
    ];

    protected $visible =[
        'lesson','language','date_completed'

    ];
}
