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

$factory->define(App\Models\Package::class, function (Faker $faker) {
    $periodInMonths = $faker->numberBetween(1, 5);
    return [
        'interest_rate' => $faker->numberBetween(1, 99),
        'period_in_months' => $periodInMonths * $faker->numberBetween(12, 24),
        'repayment_frequency_in_months'=> $periodInMonths,
        'arrangement_fee' => $faker->numberBetween(300, 500),
    ];
});
