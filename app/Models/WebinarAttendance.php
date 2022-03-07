<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebinarAttendance extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'webinars_attendance';

    /** @var string[] */
    protected $fillable = [
        'webinar_id',
        'language_id',
        'name',
        'attendance'
    ];

    public function webinar() : BelongsTo
    {
        return $this->belongsTo(Webinar::class);
    }
}
