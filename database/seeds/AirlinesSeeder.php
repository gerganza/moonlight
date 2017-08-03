<?php

use Illuminate\Database\Seeder;

class AirlinesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //Empty the airlines table
        DB::table('Airlines')->delete();

        //Get all of the airlines
        $airlines = Airlines::getList();
        foreach ($airlines as $airlineId => $airline){
            DB::table('Airlines')->insert(array(
                'id' => $airlineId,
                'airline_code' => $airline['code'],
                'airline_name' => $airline['name'],
                'country_code' => $airline['country_code'],
                'country_name' => $airline['country_name'],
            ));
        }
    }
}
