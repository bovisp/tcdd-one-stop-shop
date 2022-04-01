<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'moodle_id',
        'name',
    ];

    /** @var string[] */
    protected $casts = [
        'name' => 'array'
    ];

    /** @var string[] */
    protected $visible = ['name', 'moodle_id'];
}
