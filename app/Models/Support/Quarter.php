<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = ['name'];
}
