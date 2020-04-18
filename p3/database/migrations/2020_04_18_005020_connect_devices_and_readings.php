<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectDevicesAndReadings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('readings', function (Blueprint $table) {
    
            # Add a new bigint field called `device_id`
            # has to be unsigned (i.e. positive)
            # nullable so it's possible to have a book without an author
            $table->bigInteger('device_id')->unsigned()->nullable();
    
            # This field `device_id` is a foreign key that connects to the `id` field in the `devices` table
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('readings', function (Blueprint $table) {

            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('readings_device_id_foreign');
    
            $table->dropColumn('device_id');
        });
    }
}
