<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserReportingStructureRequest extends FormRequest
{

    public function authorize() : bool
    {
        /** @var User $sessionUser */
        $sessionUser = Auth::user();

        /** @var User $user */
        $user = $this->route('user');

        return $sessionUser->canAccessReportingStructureForUser($user);
    }

    public function rules()
    {
        return [];
    }
}
