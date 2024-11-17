<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\SoftscapeRecord;
use Faker\Generator as Faker;

$factory->define(SoftscapeRecord::class, function (Faker $faker) {
    $year = $faker->randomElement(['2018', '2019']);
    return [
        'nilai_semasa' => $faker->randomFloat(2, 5, 15),
        'gambar_keseluruhan' => 'gambar_keseluruhan.png',
        'gambar_batang' => 'gambar_batang.png',
        'gambar_daun' => 'gambar_daun.png',
        'gambar_bunga' => 'gambar_bunga.png',
        'gambar_buah' => 'gambar_buah.png',
        'catatan' => $faker->sentence(),
        'saiz_kanopi' => $faker->randomFloat(2, 1, 10),
        'ukuran_batang' => $faker->randomFloat(2, 1, 10),
        'ketinggian' => $faker->randomFloat(2, 1, 10),
        'tarikh' => $faker->date($year . '-m-d h:i:s'),
    ];
});
