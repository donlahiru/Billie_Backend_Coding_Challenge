<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address_street' => $faker->streetAddress,
        'address_zip_code' => $faker->postcode,
        'address_city' => $faker->city,
        'address_country' => $faker->country,
        'debtor_limit' => 10000,
        'status' => 'active'
    ];
});
