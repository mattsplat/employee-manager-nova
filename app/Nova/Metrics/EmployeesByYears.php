<?php

namespace App\Nova\Metrics;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class EmployeesByYears extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $employees = Employee::all();
        $grouped = $employees->groupBy(function ($item) {return $item->created_at->diffInYears(now()); })
            ->mapWithKeys(function ($item, $key) {
                return [ $key.' Years' => $item->count()];
            })
            ->sortBy(function($item, $key){
                return $item;
            })
            ->toArray();


        return $this->result( $grouped);
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'employees-by-years';
    }
}
