<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reading;
use App\Charts\ReadingChart;
use App\Device;

class ReadingController extends Controller
{
   
   

    # Show all readings from a device
    public function show(Request $request, $slug)
    {
        # paginate variables
        # get page value from request
        $page = $request->page ?? 1;

        # get number of readings to load on chart
        $numberReadings = $request->numberReadings ?? 100; # default to 100
        
        # get device details from database to send over to view
        $device = Device::where('slug', '=', $slug)->first();

        # get total number of readings
        $countReadings = Reading::where('device_id', '=', $slug)->count();
        

        # calculates number of pages needed in view
        $numberPages = $countReadings/$numberReadings;

        # offset query results to load into pages
        $offsetPage = $numberReadings * ($page - 1);
        
        # retreive temperature and humidity values from database
        $temperature = Reading::orderBy('created_at', 'desc')->where('device_id', '=', $slug)
                                                     ->limit($numberReadings) # limit query to $number_readings
                                                     ->offset($offsetPage) # for paging through readings
                                                     ->pluck('temperature', 'created_at');
                                                    
        
   

        $humidity = Reading::orderBy('created_at', 'desc')->where('device_id', '=', $slug)
                                                  ->limit($numberReadings)
                                                  ->offset($offsetPage) # for paging through data
                                                  ->pluck('humidity', 'created_at');

        # create chart using laravel charts
        $chart = new ReadingChart;
        $chart->labels($humidity->keys());
        $chart->dataset('Temperature °C', 'line', $temperature->values())->color('Red');
        $chart->dataset('Humidity %RH', 'line', $humidity->values())->backgroundColor('rgb(3, 124, 255, .4)');
        
        

        return view('readings.show', compact('chart'))->with([
            'slug' => $slug,
            'device' => $device,
            'numberReadings' => $numberReadings,
            'numberPages' => $numberPages,
            'page' => $page
            
        ]);
    }
}
