<?php

use Faker\Generator as Faker;

$factory->define(\App\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Employee::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'dob' => now()->subMonths(rand(18*12, 18*64))->subDays(rand(0,30)),
        'gender' => rand(0,1)? 'M': 'F',

    ];
});
