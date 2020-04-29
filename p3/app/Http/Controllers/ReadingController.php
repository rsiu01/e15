<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reading;

class ReadingController extends Controller
{
    /**
     * GET /readings
     * Show all the readings in the database
     */
    public function index()
    {
        $reading = Reading::orderBy('created_at')->get();
 
        
 
        # Or, filter out the new readings from the existing $readings Collection
        $newReading = $reading->sortByDesc('created_at')->take(20);
         
        return view('reading.index')->with([
             'reading' => $reading,
             'newReading' => $newReading
         ]);
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
}
