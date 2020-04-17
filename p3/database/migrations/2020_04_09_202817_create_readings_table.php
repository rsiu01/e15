<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function (Blueprint $table) {
            
            # Create a Primary, Auto-Incrementing column named `id`
            $table->bigIncrements('id');

            # This generates two columns: `created_at` and `updated_at`
            # Laravel will manage these columns automatically
            $table->timestamps();
            
            # each sensor device will have a unique integer id
            $table->tinyInteger('device');
            
            $table->decimal('temperature');

            $table->decimal('humidity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_values');
    }
}
