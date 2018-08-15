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

$factory->define(App\Voucher::class, function (Faker\Generator $faker) {
    return [
        'offer_id' => function () {
            return factory(App\Offer::class)->create()->id;
        },
        'recipient_id' => function () {
            return factory(App\Recipient::class)->create()->id;
        },
        'expires_at' => $faker->dateTimeBetween('now', '+1 year'),
    ];
});

$factory->define(App\Offer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'discount' => $faker->numberBetween(0, 100),
    ];
});

$factory->define(App\Recipient::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});