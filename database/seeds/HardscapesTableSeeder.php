<?php

use App\Model\Hardscape;
use App\Model\HardscapeRecord;
use Illuminate\Database\Seeder;

class HardscapesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Hardscape::class, 100)->create()->each(function ($hardscape) {
            $hardscape->records()->saveMany(factory(HardscapeRecord::class, 2)->make());
        });
    }
}
