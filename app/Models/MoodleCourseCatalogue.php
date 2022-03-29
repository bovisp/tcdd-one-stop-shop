<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MoodleCourseCatalogue extends Model
{
    use HasFactory;

    protected $table = 'moodle_course_catalogues';


    protected $fillable= [
        'publish_date','title','language','completion_time','objective','topic'
    ];

    protected $visible = [
        'publish_date','title','language','completion_time','objective','topic'

    ];


    public function category() : HasOne
    {
        return $this->hasOne(CourseCategory::class,  'id', 'category_id');
    }

}
