<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use App\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(4),
        'notes' => 'Foobar nootes',
        'owner_id' => function () {
            if (rand(0, 1)) {
                if (User::count() != 0) {
                    return User::inRandomOrder()->first()->id;
                }
            }
            return factory(User::class)->create()->id;
        }
    ];
});
