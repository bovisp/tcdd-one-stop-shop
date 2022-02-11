<?php

namespace App\Console\Commands;

use App\Models\Moodle\UserInformation;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdminAccount extends Command
{
    /** @var string */
    protected $signature = 'user:create-admin-account {--email=} {--name=}';

    /** @var string */
    protected $description = 'Creates admin account for a given email';

    public function handle() : int
    {
        if (! $email = $this->option('email')) {
            $this->error('E-mail not provided!');

            return Command::FAILURE;
        }

        $moodleUser = UserInformation::query()
            ->where('email', '=', $email)
            ->where('deleted', '=', false)
            ->where('suspended', '=', false)
            ->where('confirmed', '=', true)
            ->first();

        if (! $moodleUser) {
            $this->error('No valid user on Moodle\'s database with this e-mail');

            return Command::FAILURE;
        }

        $password = Str::random(8);

        User::create([
            'email' => $email,
            'password' => $password,
            'is_admin' => true,
            'moodle_user_id' => $moodleUser->id,
        ]);

        $this->info('password: ' . $password);

        return Command::SUCCESS;
    }
}
