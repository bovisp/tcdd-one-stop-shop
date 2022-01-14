<?php

namespace App\Models;

use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|\App\Models\Permission[] $permissions
 */
class Role extends Model
{
    use HasFactory, HasPermissions;

    /** @var string[] */
    protected $fillable = [
        'name',
    ];

    /** @var string[] */
    protected $visible = ['name'];
}
