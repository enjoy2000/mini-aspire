<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Loan::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\User::class),
        'package_id' => factory(App\Models\Package::class),
        'start_date' => \Carbon\Carbon::now(),
        'amount' => $faker->numberBetween(100, 9000),
    ];
});
