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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// $factory->define(App\User::class, function (Faker\Generator $faker) {
//     static $password;

//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => $password ?: $password = bcrypt('secret'),
//         'remember_token' => str_random(10),
//     ];
// });

$factory->define(App\Author::class, function (Faker\Generator $faker) {
    return [
        'name' => "{$faker->firstName} {$faker->lastName}"
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => ucfirst($faker->realText(15)),
        'description' => $faker->realText(200),
        'year' => (int)$faker->year,
        // 'author_id' => function () {
        // // We take the first random author from the table
        //     return App\Author::inRandomOrder(1)->first()->id;
        // }
    ];
});
