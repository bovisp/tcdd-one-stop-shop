<?php

namespace App\Models\Support;

use App\Models\ExternalCourseCompletion;
use App\Models\ExternalCourseView;
use App\Models\MoodleCourseLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = ['name'];

    public function courses() : HasMany
    {
        return $this->hasMany(MoodleCourseLanguage::class, 'language_id', 'id');
    }

    public function externalCourseViews() : HasMany
    {
        return $this->hasMany(ExternalCourseView::class, 'language_id', 'id');
    }

    public function externalCourseCompletions() : HasMany
    {
        return $this->hasMany(ExternalCourseCompletion::class, 'language_id', 'id');
    }
}
