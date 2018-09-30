<?php

namespace App\Nova;

use App\Nova\Filters\EmployeeAge;
use App\Nova\Filters\EmployeeGender;
use App\Nova\Metrics\EmployeesByYears;
use App\Nova\Metrics\NewEmployees;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Employee extends Resource
{

    public static $with = ['salary', 'address', 'departments', 'address', 'title'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Employee';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make()->sortable(),

            Date::make('Hire Date', 'created_at')
                ->format('M/D/Y')
                ->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable(),

            Date::make('Date of Birth', 'dob')->format('M/D/Y')
                ->sortable(),

            Select::make('Gender')
                ->options(
                    [
                        'M' => 'Male',
                        'F' => 'Female'
                    ])
                ->sortable(),

            Text::make('Age', 'dob')
                ->resolveUsing(function ($dob) {

                    return $dob->diffInYears(now());

                })
                ->sortable()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Text::make('Phone')
                ->hideFromIndex(),

            Trix::make('Bio'),

            Avatar::make('Image')
                ->disk('local')
                ->path('photos')
                ->prunable(),

            HasOne::make('Address'),
            HasOne::make('Salary'),
            HasOne::make('Job Title', 'title'),


            BelongsToMany::make('Departments'),

            HasMany::make('Deparment Manager', 'managers', DepartmentManager::class),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new NewEmployees(),
            new EmployeesByYears(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new EmployeeAge(),
            new EmployeeGender,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
