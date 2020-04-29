<?php

use Illuminate\Database\Seeder;
use App\Reading;
use App\Device;

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

            # Find that device in the devices table
            $device = Device::where('id', '=', ($faker->numberBetween($min=1, $max=20)))->first();

            $Reading->device()->associate($device);

            $Reading->temperature = $faker->randomFloat($nbMaxDecimals = 2, $min= 36, $max=38);

            $Reading->humidity = $faker->randomFloat($nbMaxDecimals = 2, $min=50, $max=98);

            $Reading->save();
        }
    }
}
