<?php

use App\Model\Softscape;
use App\Model\SoftscapeRecord;
use Illuminate\Database\Seeder;

class SoftscapesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Softscape::class, 400)->create()->each(function ($softscape) {
            $softscape->records()->saveMany(factory(SoftscapeRecord::class, 2)->make());
        });
    }
}
