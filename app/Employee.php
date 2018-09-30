<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dob' => 'date'
    ];

    public function title()
    {
        return $this->hasOne(JobTitle::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'employee_department');
    }

    public function managers()
    {
        return $this->belongsToMany(Department::class, 'department_manager', 'employee_id', 'department_id');
    }

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }


}
