<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /** @var string */
    protected $rootView = 'app';

    public function version(Request $request) :? string
    {
        return parent::version($request);
    }

    public function share(Request $request) : array
    {
        /** @var User|null $user */
        $user = auth()->user();

        return array_merge(parent::share($request), [
            'username' => optional($user)->name,
            'show_reporting_structure' => optional($user)->section_id && optional($user)->role_id,
        ]);
    }
}
