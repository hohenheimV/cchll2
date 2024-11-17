<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Administrator',
            'Pengurus',
            'Editor',
            'User'
         ];
         foreach ($roles as $role) {
            DB::table('roles')->insert(['name' => $role,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()]);
         }

         DB::table('users')->insert([]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'role_id' => 1,
            'email' => "admin@gmail.com", //$faker->unique()->freeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        factory(User::class, 10)->create();
    }
}
