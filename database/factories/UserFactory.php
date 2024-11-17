<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Article;
use App\Model\Category;
use App\Model\Tag;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->unique()->firstNameMaleMalay;
    $malayMale = $name . ' bin ' . $faker->unique()->lastNameMalay;

    return [
        'name' => $malayMale,
        'role_id' => rand(2, 3),
        'phone' => $faker->mobileNumber(null, null),
        'email' => strtolower($name) . "@gmail.com", //$faker->unique()->freeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('password'), // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(Category::class, function (Faker $faker) {
    $title = $faker->word;
    return [
        'name'      => $title,
        'description'      => $faker->sentence,
        'parent_id' => 0,
        'slug'      => Str::slug($title)
    ];
});
$factory->define(Article::class, function (Faker $faker) {
    $user_ids = User::pluck('id')->random();
    $category_ids = Category::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3, 10));
    return [
        'type'      => $faker->randomElement(['posts', 'pages']),
        'user_id'      => $user_ids,
        'category_id'  => $category_ids,
        'slug'     => Str::slug($title),
        'title'    => $title,
        'subtitle' => strtolower($title),
        'content'  => $faker->paragraph,
        'page_image'       => $faker->imageUrl(),
        'meta_description' => $faker->sentence,
        'is_status'      => $faker->randomElement(['publish', 'pending', 'draft']),
        'published_at'     => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')
    ];
});

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'label'              => $faker->unique()->word,
        'title'            => $faker->sentence,
        'meta_description' => $faker->sentence,
    ];
});
