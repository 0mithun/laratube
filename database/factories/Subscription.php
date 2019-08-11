<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model;
use App\Channel;
use Faker\Generator as Faker;
use App\Subscription;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'user_id'           =>  function(){
            return factory(User::class)->create()->id;
        },
        'channel_id'        =>  function(){
            return factory(Channel::class)->create()->id;
        }  
    ];
});