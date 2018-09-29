<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentManager extends Model
{
    protected $guarded = [];

    protected $table = 'department_manager';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
