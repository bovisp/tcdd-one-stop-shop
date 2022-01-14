<?php

namespace App\Nova;

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
    public static $title = 'name';

    /** @var string[] */
    public static $search = [
        'id', 'name', 'email', 'role_id'
    ];

    public function fields(Request $request) : array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            BelongsTo::make('Role')->creationRules('required'),
            BelongsTo::make('Section')->creationRules('required'),
        ];
    }
}
