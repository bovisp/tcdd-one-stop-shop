<?php

namespace App\Models;

use App\Models\Support\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MoodleCourseLanguage extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = ['course_id', 'language_id'];

    /** @var bool */
    public $timestamps = false;

    public function language() : HasOne
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function courseMetadata() : BelongsTo
    {
        return $this->belongsTo(MoodleCourseMetadata::class);
    }

    public function getNameAttribute() : string
    {
        return $this->language->name;
    }
}
