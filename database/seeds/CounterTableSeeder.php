<?php

use Illuminate\Database\Seeder;

class CounterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $roles = array(
            array('counter' => 0)
        );
        DB::table('counter')->insert($roles);
    }
}
