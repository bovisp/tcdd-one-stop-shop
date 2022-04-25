<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCourseView extends Model
{
    use HasFactory;

    protected $table = 'external_course_views';
    protected $fillable = [
        'lesson','language','session','date'
    ];

    protected $visible =[
        'lesson','language','session','date'

    ];
}
