<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            # there will be unique identifier for each device
            $table->string('slug');
            $table->text('description')->nullable();
            $table->float('low_temperature');
            $table->float('high_temperature');
            $table->float('calibration_offset');
            $table->string('location');
            $table->boolean('alarm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
