<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Ticket;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'id_no'=> $faker->name,
        'service'=> $faker->name,
        'issuer'=> $faker->name,
        'user_id'=> $faker->randomNumber,
        'client_id'=> $faker->name,
        // 'incidents'=> $faker->name,
        // 'item_brand'=> $faker->name,
        // 'item_sn'=> $faker->name,
        // 'item_model'=> $faker->name,
        'description'=> $faker->sentence(6),
    ];
});
