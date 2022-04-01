<?php

namespace App\Models\Moodle;

use App\Traits\ReadOnlyModel;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use ReadOnlyModel;

    /** @var string */
    protected $connection = 'moodle';

    /** @var string */
    protected $table = 'mdl_user';

    /** @var string[] */
    protected $visible = [
        'username',
        'confirmed',
        'deleted',
        'suspended',
        'firstname',
        'lastname',
        'email',
        'city',
        'country',
        'lang',
        'timezone'
    ];

    /** @var string[] */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'deleted' => 'boolean',
        'suspended' => 'boolean'
    ];
}
