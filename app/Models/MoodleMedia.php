<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MoodleMedia extends Model
{
    use HasFactory;

    protected $table = 'moodle_medias';


    /**
     * @var array
     */
    protected $fillable = [
        'title','description','media','license_id','keywords'
    ];
    /**
     * @var array
     */
    protected $casts = [
        'description'=> 'array',
        'title' => 'array',
        'keywords' => 'array',
    ];

    /**
     * @var array
     */
    protected $visible = ['title','description','media','license_id','keywords'];


    public function moodleMediaLicense() : HasOne
    {
        return $this->hasOne(MoodleMediaLicense::class, 'id', 'license_id');
    }

}
