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
        'dob' => now()->subMonths(rand(18*12, 12*64))->subDays(rand(0,30)),
        'gender' => rand(0,1)? 'M': 'F',

    ];
});

$factory->define('App\Address', function(Faker $faker){

    return [

        'address_line_1' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => 'US',
        'employee_id' => \App\Employee::doesnthave('address')->first(),
    ];

});
