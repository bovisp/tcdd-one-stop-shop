<?php

namespace App\Providers;

use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentWebinarAttendanceRepository;
use App\Repositories\MoodleDatabaseRepository;
use App\Repositories\MoodleRepositoryContract;
use App\Repositories\UserRepositoryContract;
use App\Repositories\WebinarAttendanceRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(UserRepositoryContract::class, EloquentUserRepository::class);
        $this->app->bind(WebinarAttendanceRepositoryContract::class, EloquentWebinarAttendanceRepository::class);
        $this->app->bind(MoodleRepositoryContract::class, MoodleDatabaseRepository::class);
    }

    public function boot() : void
    {
        //
    }
}
