<?php

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //Empty the cities table
        DB::table('Cities')->delete();

        //Get all of the cities
        $cities = Cities::getList();
        foreach ($cities as $cityId => $city){
            DB::table('Cities')->insert(array(
                'id' => $cityId,
                'city_code' => $city['iso_3166_3'],
                'country_code' => $city['country_code'],
                'city_name' => $city['name'],
            ));
        }
    }
}
