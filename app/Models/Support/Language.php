<?php

namespace App\Models\Support;

use App\Models\MoodleCourseLanguage;
use App\Models\MoodleCourseMetadata;
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
}
