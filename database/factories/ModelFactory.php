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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => str_random(6),
        //'wdoc1'		=> $faker->name,
        //'wdoc2'		=> $faker->name,
        //'wdoc3'		=> $faker->name,
    //    'email' => $faker->safeEmail,
        'type'		=> $faker->randomElement(['01','02','03','09']),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
