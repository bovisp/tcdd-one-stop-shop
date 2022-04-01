<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CourseCategory extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'category_name'
    ];

    /** @var string[] */
    protected $casts = [
        'category_name' => 'array'
    ];

    /** @var string[] */
    protected $visible = ['category_name'];

    public function moodleCourses() : HasMany
    {
        return $this->hasMany(MoodleCourse::class);
    }
}
