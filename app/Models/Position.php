<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $section_id
 * @property int $role_id
 *
 * @property \App\Models\Role $role
 * @property \App\Models\Section $section
 */
class Position extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    /** @var string */
    protected $table = 'reporting_structure_positions';

    /** @var string[] */
    protected $fillable = [
        'section_id', 'role_id', 'hierarchy_position'
    ];

    /** @var string[] */
    protected $dates = [
         'created_at', 'updated_at'
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, ['role_id', 'section_id'], ['role_id', 'section_id']);
    }


}
