<?php

use Faker\Generator as Faker;

$factory->define(\App\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Employee::class, function (Faker $faker) {

    $gender = rand(0,1)? 'male': 'female';
    return [
        'name' => $faker->name($gender),
        'email' => $faker->unique()->safeEmail,
        'phone' => '('.rand(100,999).')'.rand(100,999).'-'.rand(1000,9999),
        'dob' => now()->subMonths(rand(18*12, 12*64))->subDays(rand(0,30)),
        'gender' => $gender == 'male'? 'M' : 'F',
        'created_at' => now()->subMonths(rand(1, 12*10))

    ];
});

$factory->define('App\Address', function(Faker $faker){

    return [

        'address_line_1' => $faker->address,
        'address_line_2' => null,
        'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => 'US',
        'employee_id' => \App\Employee::doesnthave('address')->first(),
    ];

});
