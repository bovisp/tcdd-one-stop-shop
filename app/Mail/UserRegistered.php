<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    private $user;

    /** @var string */
    private $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build() : self
    {
        return $this->view('mail.welcome', [
            'name' => $this->user->name,
            'password' => $this->password,
            'link' => env('APP_URL')
        ]);
    }
}
