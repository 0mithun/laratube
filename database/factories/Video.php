<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'channel_id'        =>  function () {
            return factory(Channel::class)->create()->id;
        },
        'thumbnail'         =>  $faker->imageUrl(),
        'percentage'        =>  100,
        'views'             =>  $faker->numberBetween(1, 1000),
        'title'             =>  $faker->sentence(4),
        'description'       =>  $faker->paragraph(1),
        'path'              =>  $faker->word(),
    ];
});
