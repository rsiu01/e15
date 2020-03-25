<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpokeController extends Controller
{
    # Handles data from form submsission and calculates spoke lengths
    public function calculate(Request $request)
    {
        
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'wheel' => 'required',
            'erd' => 'required|numeric',
            'osb' => 'required|numeric',
            'wl' => 'required|numeric',
            'wr' => 'required|numeric',
            'dl' => 'required|numeric',
            'dr' => 'required|numeric',
            'nspoke' => 'required|numeric',
            'dspokehole' => 'required|numeric',
            'ncross' => 'required|numeric'

        ]);

        # Get the input values (default to null if no values exist)
        $wheel = $request->input('wheel', null);
        $erd = $request->input('erd', null);
        $osb = $request->input('osb', null);
        $wl = $request->input('wl', null);
        $wr = $request->input('wr', null);
        $dl = $request->input('dl', null);
        $dr = $request->input('dr', null);
        $nspoke = $request->input('nspoke', null);
        $dspokehole = $request->input('dspokehole', null);
        $ncross = $request->input('ncross', null);

 

        # calculate left and right spoke lengths using formula from https://www.wheelpro.co.uk/support/spoke-length-calculators/
        $leftSpoke = (((($erd/2)**2)+(($dl/2)**2)+(($wl)**2)-(2*($erd/2)*($dl/2)*cos(((4*pi()*$ncross)/$nspoke)))))**(.5)-($dspokehole/2);
        $rightSpoke = (((($erd/2)**2)+(($dr/2)**2)+(($wr)**2)-(2*($erd/2)*($dr/2)*cos(((4*pi()*$ncross)/$nspoke)))))**(.5)-($dspokehole/2);
        
        
        
 
        # empty array to store calculated spoke lengths
        $spokeLengths = [
            'leftSpoke' => $leftSpoke,
            'rightSpoke' => $rightSpoke
        ];
 
    
    
        # Redirect back to the form with data/results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/')->with([
        'wheel' => $wheel,
        'erd' => $erd,
        'osb' => $osb,
        'wl' => $wl,
        'wr' => $wr,
        'dl' => $dl,
        'dr' => $dr,
        'nspoke' => $nspoke,
        'dspokehole' => $dspokehole,
        'ncross' => $ncross,
        'spokeLengths' => $spokeLengths

    ]);
    }
}
