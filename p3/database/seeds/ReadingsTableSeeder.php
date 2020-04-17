<?php

use Illuminate\Database\Seeder;
use App\Readings;

class ReadingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # some seeder by faker to developing show view
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $Readings = new Readings();

            $Readings->device = $faker->numberBetween($min=0, $max=20);

            $Readings->temperature = $faker->randomFloat($nbMaxDecimals = 2, $min= 36, $max=38);

            $Readings->humidity = $faker->randomFloat($nbMaxDecimals = 2, $min=50, $max=98);

            $Readings->save();
        }
    }
}
