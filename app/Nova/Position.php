<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;

class Position extends Resource
{
    /** @var string */
    public static $model = \App\Models\Position::class;

    /** @var string[] */
    public static $search = [
        'id', 'reporting_structure_id', 'role_id'
    ];

    public function fields(Request $request) : array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Section')->rules('required'),
            BelongsTo::make('Role')->rules('required'),
            Number::make('Hierarchy Position', 'hierarchy_position')
                ->rules('required')
                ->min(1)
                ->creationRules('unique:reporting_structure_positions,hierarchy_position,reporting_structure_id'),
        ];
    }
}
