<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|\App\Models\Position[] $reportingStructure
 */
class Section extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'name',
    ];

    /** @var string[] */
    protected $visible = ['name'];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function positions() : HasMany
    {
        return $this->hasMany(Position::class);
    }
}
