<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Readings;

class ReadingController extends Controller
{
    /**
     * GET /readings
     * Show all the readings in the database
     */
    public function index()
    {
        $readings = Readings::orderBy('created_at')->get();
 
        
 
        # Or, filter out the new readings from the existing $readings Collection
        $newReadings = $readings->sortByDesc('created_at')->take(20);
         
        return view('readings.index')->with([
             'readings' => $readings,
             'newReadings' => $newReadings
         ]);
    }
}
