<?php

namespace App\Nova;

use App\Rules\UserExistsOnMoodle;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

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
        return [
            ID::make()->sortable(),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules(['unique:users,email', new UserExistsOnMoodle()])
                ->updateRules('unique:users,email,{{resourceId}}'),
            BelongsTo::make('Role')->creationRules('required'),
            BelongsTo::make('Section')->creationRules('required'),
        ];
    }
}
