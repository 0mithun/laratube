<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model;
use App\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'name'      =>  $faker->sentence(4),
        'user_id'   =>  function(){
            return factory(User::class)->create()->id;
        },
        'description'   =>  $faker->paragraph(1),
        
    ];
});
