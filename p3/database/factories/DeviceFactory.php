<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Device;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    $slug = $faker->word;

    $low_temperature = 35;

    $high_temperature = 39;

    $calibration_offset = 0;

    $location = 'N/A';

    $alarm = true;

    
    return [
        'slug' => $slug,

        'low_temperature' => $low_temperature,

        'high_temperature' => $high_temperature,

        'calibration_offset' => $calibration_offset,

        'location' => $location,

        'alarm' => $alarm,
    ];
});
