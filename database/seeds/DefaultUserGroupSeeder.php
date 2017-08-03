<?php

use Illuminate\Database\Seeder;

class DefaultUserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UserGroup')->insert([
            'UserID' => 1,
            'GroupCode' => 'ADMIN',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
