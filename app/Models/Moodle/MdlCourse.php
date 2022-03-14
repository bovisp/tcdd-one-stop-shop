<?php

namespace App\Models\Moodle;

use App\Traits\ReadOnlyModel;
use Illuminate\Database\Eloquent\Model;

class MdlCourse extends Model
{
    use ReadOnlyModel;

    /** @var string */
    protected $connection = 'moodle';

    /** @var string */
    protected $table = 'mdl_course';

    /** @var string[] */
    protected $visible = [
        'id',
        'shortname'
    ];

}
