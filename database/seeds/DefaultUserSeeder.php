<?php

use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Users')->insert([
            'name' => 'Gerard Ganza',
            'email' => 'gerardganza@gmail.com',
            'password' => bcrypt('121212'),
            'firstname' => 'Gerard',
            'lastname' => 'Ganza',
            'isActive' => 1,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
