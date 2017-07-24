<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Currency;

$factory->define(App\Models\CurrencyRate::class, function (Faker\Generator $faker) {
    $q = 1;
    return [
        'currency_id' => Currency::where('id', '>', mt_rand(1, 5))->skip(mt_rand(1, 5))->firstOrFail()->id,
        'rate' => mt_rand(3000, 6000)/100,
        'date' => $faker->unique()->dateTimeBetween('-90 days')->format('Y-m-d'),
    ];
});
