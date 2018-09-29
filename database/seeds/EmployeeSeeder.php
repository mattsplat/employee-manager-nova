<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Accounting',
            'Sales',
            'Maintenance',
            'Customer Service',
            'Development',
            'Marketing',
            'Executive'
        ];

        foreach ($departments as $department){
            \App\Department::create([
                'name' => $department
            ]);
        }
        $departments = \App\Department::get();

        $employees = factory(\App\Employee::class, 1000)->create();

        $employees->each(function ($employee){
            // create employee departments
            \App\EmployeeDepartment::create([
                'department_id' => rand(1,7),
                'employee_id' => $employee->id
            ]);

            // salary
            App\Salary::create([
                'amount' => rand(3,20)*10000,
                'employee_id' => $employee->id
            ]);

            // title
            \App\JobTitle::create([
                'name' => 'director',
                'employee_id' => $employee->id
            ]);
        });

        // create managers

        foreach($departments as $id => $department){

            $managers = \App\Employee::inRandomOrder()->limit(2)->get();
            $managers->each(function ($manager) use ($department){
                \App\DepartmentManager::create([
                    'department_id' => $department->id,
                    'employee_id' => $manager->id
                ]);
            });

        }

    }
}
