<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminAccount extends Command
{
    /** @var string */
    protected $signature = 'user:create-admin-account {--email=}';

    /** @var string */
    protected $description = 'Creates admin account for a given email';

    public function handle() : int
    {
        if (! $email = $this->option('email')) {
            $this->error('E-mail not provided!');

            return Command::FAILURE;
        }

        User::create([
            'email' => $email,
            'is_admin' => true,
        ]);

        return Command::SUCCESS;
    }
}
