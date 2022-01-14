<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Role extends Resource
{
    /** @var string */
    public static $model = \App\Models\Role::class;

    /** @var string */
    public static $title = 'name';

    /** @var string[] */
    public static $search = [
        'id', 'name'
    ];

    public function fields(Request $request) : array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
        ];
    }
}
