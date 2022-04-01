<?php

namespace App\Models\Moodle;

use App\Traits\ReadOnlyModel;
use Illuminate\Database\Eloquent\Model;

class MdlBadge extends Model
{
    use ReadOnlyModel;

    /** @var string */
    protected $connection = 'moodle';

    /** @var string */
    protected $table = 'mdl_badge';

    /** @var string[] */
    protected $visible = [
        'id',
        'name'
    ];
}
