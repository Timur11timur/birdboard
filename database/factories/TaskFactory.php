<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\Project;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'project_id' => function () {
        if (Project::count() == 0) {
            return factory(Project::class)->create()->id;
        }
        return Project::inRandomOrder()->first()->id;
    }
    ];
});
