<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

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
                ->creationRules('unique:reporting_structure_positions,hierarchy_position,{{resourceId}},id,section_id,???'),
        ];
    }

    protected static function afterValidation(NovaRequest $request, $validator)
    {
        $unique = Rule::unique('reporting_structure_positions', 'hierarchy_position')
            ->where('section_id', $request->post('section'));

        if ($request->route('resourceId')) {
            $unique->ignore($request->route('resourceId'));
        }

        $uniqueValidator = Validator::make($request->only('hierarchy_position'), [
            'hierarchy_position' => [$unique],
        ]);

        if ($uniqueValidator->fails()) {
            $validator
                ->errors()
                ->add(
                    'hierarchy_position',
                    'This position is already taken on this section.'
                );
        }

    }
}
