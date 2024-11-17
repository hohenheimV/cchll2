<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('roles')->delete();
        $roles = array(
            array('name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Pengurus', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Editor', 'created_at' => now(), 'updated_at' => now())
        );
        DB::table('roles')->insert($roles);
    }
}
