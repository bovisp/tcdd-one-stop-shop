<?php

namespace App\Console\Commands;

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

        $password = Str::random(8);

        User::create([
            'name'     => $this->option('name') ?? 'Admin',
            'email'    => $email,
            'password' => bcrypt($password),
            'is_admin' => true
        ]);

        $this->info('password: ' . $password);

        return Command::SUCCESS;
    }
}
