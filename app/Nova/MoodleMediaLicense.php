<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;



class MoodleMediaLicense extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MoodleMediaLicense::class;

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
        'id','description','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name (English)', 'name->english')
                ->sortable()
                ->rules('required'),
            Text::make('Name (French)', 'name->french')
                ->sortable()
                ->rules('required'),
            Textarea::make('Description (English)', 'description->english')
                  ->sortable()
                  ->rules('required'),
            Textarea::make('Description (French)', 'description->french')
                ->sortable()
                ->rules('required')
        ];
    }
}
