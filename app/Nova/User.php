<?php

namespace App\Nova;

use App\Models\Moodle\UserInformation;
use App\Models\User as EloquentUser;
use App\Rules\UserExistsOnMoodle;
use Gkermer\TextAutoComplete\TextAutoComplete;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;

class User extends Resource
{
    /** @var string */
    public static $model = \App\Models\User::class;

    /** @var string */
    public static $title = 'email';

    /** @var string[] */
    public static $search = [
        'id', 'email', 'role_id'
    ];

    public function fields(Request $request) : array
    {
        $registeredEmails = EloquentUser::all()->pluck('email')->toArray();

        return [
            ID::make()->sortable(),
            TextAutoComplete::make('Email')
                ->items(function ($search) use ($registeredEmails) {
                    return UserInformation::query()
                        ->where('email', 'like', '%' . $search . '%')
                        ->whereNotIn('email', $registeredEmails)
                        ->where('deleted', '=', false)
                        ->where('suspended', '=', false)
                        ->where('confirmed', '=', true)
                        ->get()
                        ->pluck('email');
                })
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules(['unique:users,email', new UserExistsOnMoodle()])
                ->updateRules('unique:users,email,{{resourceId}}'),
            BelongsTo::make('Role')->creationRules('required'),
            BelongsTo::make('Section')->creationRules('required'),
        ];
    }
}
