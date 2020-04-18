<?php

use Illuminate\Database\Seeder;
use App\Device;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 30; $i++) {
            $Device = new Device();

            $Device->freezer = $i;

            $Device->low_temperature = 35;

            $Device->high_temperature = 39;

            $Device->calibration_offset = 0;

            $Device->alarm = true;

            $Device->save();
        }
    }
}
