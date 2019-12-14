<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Matapelajaran;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Matapelajaran::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'mata_pelajaran' => $name,
    ];
});
