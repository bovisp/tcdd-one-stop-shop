<?php

namespace App\Models;

use App\Models\Moodle\UserInformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use \Awobaz\Compoships\Compoships;

    public function getPassword()
    {
        return $this->password;
    }

    /** @var string[] */
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'is_admin',
        'unhashed_password',
        'moodle_user_id'
    ];

    protected $visible = ['id', 'name', 'email', 'role_id', 'section_id', 'is_admin', 'moodleInfo'];

    /** @var string[] */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /** @var string[] */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    /** @var string[]  */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function position() : BelongsTo
    {
        return $this->belongsTo(Position::class, ['section_id', 'role_id'], ['section_id', 'role_id']);
    }

    public function moodleInfo() : BelongsTo
    {
        return $this->belongsTo(UserInformation::class, 'moodle_user_id');
    }

    public function getNameAttribute() : ?string
    {
        if (! $this->moodleInfo) {
            return $this->email;
        }

        return implode(' ', [$this->moodleInfo->firstname, $this->moodleInfo->lastname]);
    }

    public function isAdmin() : bool
    {
        return $this->is_admin;
    }

    public function hasSection() : bool
    {
        return (bool) $this->section_id;
    }

    public function hasRole() : bool
    {
        return (bool) $this->role_id;
    }

    public function canAccessReportingStructureForUser(self $user) : bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! every($this->hasRole(), $this->hasSection())) {
            return false;
        }

        if ($this->is($user)) {
            return true;
        }

        return $this->position->hierarchy_position < $user->position->hierarchy_position;
    }
}
