<?php

use Illuminate\Database\Seeder;

class DefaultGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Groups')->insert([
            'GroupName' => 'Administrator',
            'GroupCode' => 'ADMIN',
            'description' => 'master user',
            'isActive' => 1,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('Groups')->insert([
            'GroupName' => 'User',
            'GroupCode' => 'USER',
            'description' => 'limited access',
            'isActive' => 1,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
