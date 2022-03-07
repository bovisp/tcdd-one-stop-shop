<?php

namespace App\Models;

use App\Models\Support\FiscalYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webinar extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'reference_code',
        'fiscal_year_id',
        'quarter_id'
    ];

    public function fiscalYear() : BelongsTo
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function attendance() : HasMany
    {
        return $this->hasMany(WebinarAttendance::class);
    }
}
