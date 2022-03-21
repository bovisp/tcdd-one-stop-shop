<?php

use App\Http\Controllers\GetMoodleViewsAndCompletionsDashboardController;
use App\Http\Controllers\GetReportingStructureController;
use App\Http\Controllers\GetWebinarDashboardController;
use App\Http\Controllers\MoodleCourseMetadataController;
use App\Http\Controllers\WebinarAttendanceController;
use App\Http\Controllers\MoodleMediaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $route = auth()->check() ? 'Dashboard' : 'Auth/Login';

    return Inertia::render($route);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/users/{user}/reporting-structure', GetReportingStructureController::class);

    Route::resource('webinar-attendance', WebinarAttendanceController::class)
        ->except('show', 'index', 'destroy');

    Route::get('webinar-attendance/dashboard', GetWebinarDashboardController::class)
        ->name('webinar-attendance.dashboard');

    Route::get(
        'moodle-views-completions/dashboard',
        GetMoodleViewsAndCompletionsDashboardController::class
    )->name('moodle-views-completions.dashboard');

    Route::resource('moodle-courses', MoodleCourseMetadataController::class);

    Route::resource('moodle-media', MoodleMediaController::class);
});
