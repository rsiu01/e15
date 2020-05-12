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

        for ($i = 0; $i < 10000; $i++) {
            $Reading = new Reading();

            # Find that device in the devices table
            $device = Device::where('id', '=', ($faker->numberBetween($min=1, $max=5)))->first();

            $Reading->device()->associate($device);

            # having to set timezone to account for daylight savings time
            # https://github.com/fzaninotto/Faker/issues/914#issuecomment-565539803
            $Reading->created_at = $faker->unique()->dateTimeBetween($startDate = '-2 years ', $endDate = 'now', $timezone = 'America/New_York');

            $Reading->temperature = $faker->randomFloat($nbMaxDecimals = 2, $min= 36, $max=38);

            $Reading->humidity = $faker->randomFloat($nbMaxDecimals = 2, $min=65, $max=98);

            $Reading->save();
        }
    }
}
