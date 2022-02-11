<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class UserResource implements Arrayable
{
    /** @var string */
    private $name;

    /** @var string  */
    private $email;

    /** @var string */
    private $section;

    /** @var string */
    private $role;

    public function __construct(string $name, string $email, string $section = '', string $role = '')
    {
        $this->name = $name;
        $this->email = $email;
        $this->section = $section;
        $this->role = $role;
    }

    public static function fromUser(User $user) : self
    {
        return new self($user->moodleInfo->name, $user->email, optional($user->section)->name, optional($user->role)->name);
    }

    public function toArray() : array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'section' => $this->section,
            'role' => $this->role
        ];
    }
}
