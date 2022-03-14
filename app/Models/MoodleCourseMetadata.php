<?php

namespace App\Models;

use App\Models\Moodle\MdlCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MoodleCourseMetadata extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'course_id',
        'course_name_en',
        'course_name_fr',
        'publish_date',
        'description_en',
        'description_fr',
        'category_id',
        'presenters',
        'keywords_en',
        'keywords_fr',
        'minimum_estimated_time',
        'maximum_estimated_time',
        'objectives_topics',
    ];

    /** @var string */
    protected $table = 'moodle_courses';

    /** @var string[] */
    protected $casts = [
        'presenters' => 'array',
        'keywords_en' => 'array',
        'keywords_fr' => 'array',
        'objectives_topics' => 'array',
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(MdlCourse::class, 'course_id');
    }

    public function languages() : HasMany
    {
        return $this->hasMany(MoodleCourseLanguage::class, 'course_id', 'id');
    }

    public function category() : HasOne
    {
        return $this->hasOne(CourseCategory::class,  'id', 'category_id');
    }

    public function getMinimumTimeInDays() : array
    {
        $now = now();
        $days = $now->diffInDays($now->copy()->addMinutes($this->minimum_estimated_time));
        $hours = $now->diffInHours($now->copy()->addMinutes($this->minimum_estimated_time)->subDays($days));
        $minutes = $now->diffInMinutes($now->copy()->addMinutes($this->minimum_estimated_time)->subDays($days)->subHours($hours));

        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes
        ];
    }

    public function getMaximumTimeInDays() : array
    {
        $now = now();
        $days = $now->diffInDays($now->copy()->addMinutes($this->maximum_estimated_time));
        $hours = $now->diffInHours($now->copy()->addMinutes($this->maximum_estimated_time)->subDays($days));
        $minutes = $now->diffInMinutes($now->copy()->addMinutes($this->maximum_estimated_time)->subDays($days)->subHours($hours));

        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes
        ];
    }
}
