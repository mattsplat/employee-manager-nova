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
        $titles_array = \App\JobTitle::$titles;


        foreach ($departments as $department){
            \App\Department::create([
                'name' => $department
            ]);
        }
        $departments = \App\Department::get();

        $employees = factory(\App\Employee::class, 1000)->make()->toArray();

        \App\Employee::insert($employees);

        $titles = [];
        $addresses = [];
        $salaries = [];
        $employee_departments = [];

        foreach(\App\Employee::get() as $employee){
            // create employee departments
            $employee_departments[] = [
                'department_id' => rand(1,7),
                'employee_id' => $employee->id
            ];

            // salary
            $salaries[] = [
                'amount' => rand(30,300)*1000,
                'employee_id' => $employee->id
            ];

            // title
            $title[] = [
                'name' => array_rand($titles_array),
                'employee_id' => $employee->id
            ];

            $addresses[] = factory('App\Address')->make(['employee_id' => $employee->id])->toArray();

        };

        \App\JobTitle::insert($titles);
        \App\Address::insert($addresses);
        \App\Salary::insert($salaries);
        \App\EmployeeDepartment::insert($employee_departments);

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
