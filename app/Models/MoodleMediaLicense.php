<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MoodleMediaLicense extends Model
{
    use HasFactory;

    protected $table = 'moodle_media_licenses';

    /**
     * @var array
     */
    protected $fillable = [
        'name','description'
    ];
    /**
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',

    ];

    /**
     * @var array
     */
    protected $visible = ['name','description'];

    public function moodleMedia() : HasMany
    {
        return $this->hasMany(MoodleMedia::class);
    }
}
