<?php

namespace App\Nova;

use App\Models\Moodle\MdlBadge;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Badge extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Badge::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $moodleBadges = MdlBadge::query()
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        return [
            ID::make()->sortable(),
            Select::make('Moodle Badge', 'moodle_id')
                ->options($moodleBadges)
                ->sortable()
                ->rules('required'),
            Text::make('Name (English)', 'name->english')
                ->sortable()
                ->rules('required'),
            Text::make('Name (French)', 'name->french')
                ->sortable()
                ->rules('required')
        ];
    }
}
