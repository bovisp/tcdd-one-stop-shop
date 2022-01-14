<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryContract
{
    public function getUserReportingStructure(User $user) : Collection;
}
