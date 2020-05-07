<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reading;
use App\Charts\ReadingChart;
use App\Device;

class ReadingController extends Controller
{
   
    /**
     * GET /readings
     * Show all the readings in the database
     */
    public function index()
    {
        # retreive temperature and humidity values from database
        $temperature = Reading::orderBy('created_at')->pluck('temperature', 'created_at');
        $humidity = Reading::orderBy('created_at')->pluck('humidity', 'created_at');

        # create chart using laravel charts
        $chart = new ReadingChart;
        $chart->labels($humidity->keys());
        $chart->dataset('Temperature °C', 'line', $temperature->values())->color('Red');
        $chart->dataset('Humidity %RH', 'line', $humidity->values())->backgroundColor('rgb(3, 124, 255, .4)');
        
        

        return view('readings.index', compact('chart'));
    }

    public function store(Request $request)
    {
        
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'device_id' => 'required',
            'temperature' => 'required',
            'humidity' => 'required'
           
        ]);
        
       

        # Note: If validation fails, it will automatically redirect the visitor back to the form page
        # and none of the code that follows will execute.

        # Add the reading to the database
        $newReading = new Reading();
        $newReading->device_id = $request->device_id;
        $newReading->temperature = $request->temperature;
        $newReading->humidity = $request->humidity;
       
        $newReading->save();
    }

    # Show all readings from a device
    public function show($slug)
    {
        # get device details from database to send over to view
        $device = Device::where('slug', '=', $slug)->first();

        # retreive temperature and humidity values from database
        $temperature = Reading::orderBy('created_at')->where('device_id', '=', $slug)->pluck('temperature', 'created_at');
        $humidity = Reading::orderBy('created_at')->where('device_id', '=', $slug)->pluck('humidity', 'created_at');

        # create chart using laravel charts
        $chart = new ReadingChart;
        $chart->labels($humidity->keys());
        $chart->dataset('Temperature °C', 'line', $temperature->values())->color('Red');
        $chart->dataset('Humidity %RH', 'line', $humidity->values())->backgroundColor('rgb(3, 124, 255, .4)');
        
        

        return view('readings.show', compact('chart'))->with([
            'slug' => $slug,
            'device' => $device
        ]);
    }
}
