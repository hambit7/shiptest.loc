<?php

use Faker\Generator as Faker;

$factory->define(\App\ContainerRoute::class, function (Faker $faker) {
    return [
        'route_id' =>  factory('App\Route')->create()->id,
        'container_id' =>  factory('App\Container')->create()->id
    ];
});
