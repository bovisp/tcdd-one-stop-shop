<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Model
 */
trait HasPermissions
{
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }

    public function grantPermissions(Permission ...$permissions) : self
    {
        $this->permissions()
            ->syncWithoutDetaching(collect($permissions)->pluck('id')->all());

        return $this;
    }

    public function revokePermissions(Permission ...$permissions) : self
    {
        $this->permissions()
            ->detach(collect($permissions)->pluck('id')->all());

        return $this;
    }
}
