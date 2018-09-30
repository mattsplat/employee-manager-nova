<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{

    public static $titles = [
        'Director',
        'Assistant',
        'Janitor',
        'Developer',
        'Accountant',
        'Representative'

    ];


    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
