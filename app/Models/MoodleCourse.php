<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MoodleCourse extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'course_name',
        'languages',
        'publish_date',
        'presenters',
        'minimum_estimated_time',
        'maximum_estimated_time',
        'objectives',
        'descriptions',
        'tags'

    ];
    /**
     * @var array
     */
    protected $visible = [
        'course_id',
        'course_names',
        'languages',
        'publish_date',
        'presenters',
        'minimum_estimated_time',
        'maximum_estimated_time',
        'objectives',
        'descriptions',
        'tags'
    ];

    protected $casts = [
        'course_names' => 'array',
        'languages' => 'array',
        'presenters' => 'array',
        'objectives' => 'array',
        'descriptions' => 'array',
        'tags' => 'array',

    ];


    public function category() :BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }
}
