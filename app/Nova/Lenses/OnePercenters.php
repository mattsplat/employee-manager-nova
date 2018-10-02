<?php

namespace App\Nova\Lenses;

use App\Employee;
use App\Salary;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Http\Requests\LensRequest;

class OnePercenters extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest $request
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        $salaries = Salary::select('id')->orderBy('amount', 'desc')->limit(10)->get();

        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
                ->join('salaries', 'salaries.employee_id', 'employees.id')
                ->WhereIn('salaries.id', $salaries)
                ->orderBy('amount', 'desc')

        ));
    }

    protected static function columns()
    {
        return [
            'employees.id',
            'employees.name',
            'salaries.amount'
        ];
    }
    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id')->sortable(),
            Text::make('Name'),
            Currency::make('amount'),
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'one-percenters';
    }
}
