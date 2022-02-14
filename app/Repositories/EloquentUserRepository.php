<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryContract
{
    public function getUserReportingStructure(User $user) : Collection
    {
        if (! $user->section) {
            return collect([]);
        }

        return $user->section
            ->positions()
            ->getQuery()
            ->with(['users.moodleInfo', 'role'])
            ->orderBy('hierarchy_position')
            ->get();
    }
}
