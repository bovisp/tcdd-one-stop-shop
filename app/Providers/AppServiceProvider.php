<?php

namespace App\Providers;

use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentWebinarAttendanceRepository;
use App\Repositories\UserRepositoryContract;
use App\Repositories\WebinarAttendanceRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(UserRepositoryContract::class, EloquentUserRepository::class);
        $this->app->bind(WebinarAttendanceRepositoryContract::class, EloquentWebinarAttendanceRepository::class);
    }

    public function boot() : void
    {
        //
    }
}
