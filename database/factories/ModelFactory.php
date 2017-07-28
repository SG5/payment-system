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
    return [
        'currency_id' => Currency::where('id', '>', mt_rand(1, 5))->skip(mt_rand(1, 5))->firstOrFail()->id,
        'rate' => mt_rand(3000, 6000)/100,
        'date' => $faker->unique()->date('Y-m-d', '+1 years'),
    ];
});

$factory->define(App\Models\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'country' => $faker->country,
        'city' => $faker->city,
        'currency_id' => Currency::where('id', '>', mt_rand(1, 5))->skip(mt_rand(1, 5))->firstOrFail()->id,
    ];
});
