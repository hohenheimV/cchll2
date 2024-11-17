<?php

use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array('slider_image' => env('APP_URL') . 'storage/' . 'images/sliders/slider_1.jpg', 'created_at' => now(), 'updated_at' => now()),
            array('slider_image' => env('APP_URL') . 'storage/' . 'images/sliders/slider_2.jpg', 'created_at' => now(), 'updated_at' => now()),
            array('slider_image' => env('APP_URL') . 'storage/' . 'images/sliders/slider_3.jpg', 'created_at' => now(), 'updated_at' => now()),
            array('slider_image' => env('APP_URL') . 'storage/' . 'images/sliders/slider_4.jpg', 'created_at' => now(), 'updated_at' => now()),
        );
        DB::table('sliders')->insert($roles);
    }
}
