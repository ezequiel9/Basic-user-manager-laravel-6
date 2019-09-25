<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $user = \App\Models\User::where('role', 'administrator')->inRandomOrder()->first();
    return [
        'name' => $faker->name,
        'website' => $faker->name,
        'location' => $faker->city,
        'user_id' => $user->id,
    ];
});
