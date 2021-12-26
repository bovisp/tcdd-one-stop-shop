<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminAccount extends Command
{
    /** @var string */
    protected $signature = 'user:create-admin-account {--email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
