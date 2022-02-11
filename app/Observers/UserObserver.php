<?php

namespace App\Observers;

use App\Mail\UserRegistered;
use App\Models\Moodle\UserInformation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating($user) : void
    {
        if (! $user->moodle_user_id) {
            $moodleUser = UserInformation::query()
                ->where('email', '=', $user->email)
                ->where('deleted', '=', false)
                ->where('suspended', '=', false)
                ->where('confirmed', '=', true)
                ->first();

            if ($moodleUser) {
                $user->moodle_user_id = $moodleUser->id;
            }
        }

        $user->password = Str::random(8);

        Mail::to($user->email)->send(new UserRegistered($user, $user->getPassword()));

        $user->password = Hash::make($user->getPassword());
    }
}
