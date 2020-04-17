<?php

use Illuminate\Database\Seeder;
use App\Reading;

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
            $Reading = new Reading();

            $Reading->device = $faker->numberBetween($min=0, $max=20);

            $Reading->temperature = $faker->randomFloat($nbMaxDecimals = 2, $min= 36, $max=38);

            $Reading->humidity = $faker->randomFloat($nbMaxDecimals = 2, $min=50, $max=98);

            $Reading->save();
        }
    }
}
