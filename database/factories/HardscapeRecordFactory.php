<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\HardscapeRecord;
use Faker\Generator as Faker;

$factory->define(HardscapeRecord::class, function (Faker $faker) {
    $year = $faker->randomElement(['2018', '2019']);
    return [
        'tarikh' => $faker->date($year . '-m-d h:i:s'),
        'gambar_baikpulih' => 'gambar_baikpulih.png',
        'kos_selenggara' => $faker->randomFloat(2, 100, 500),
        'catatan_selenggara' => $faker->sentence(),
        'kos_baikpulih' => $faker->randomFloat(2, 100, 500),
        'catatan_baikpulih' => $faker->sentence(),
    ];
});
