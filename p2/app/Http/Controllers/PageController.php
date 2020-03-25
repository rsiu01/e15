<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * GET /
     */
    public function welcome()
    {
        # Using the global `session` helper, we can extract our data that was
        # passed from `BookController@search` as part of the redirect
        
        $wheel = session('wheel', null);
        $erd = session('erd', null);
        $osb = session('osb', null);
        $wl = session('wl', null);
        $wr= session('wr', null);
        $dl = session('dl', null);
        $dr = session('dr', null);
        $nspoke = session('nspoke', null);
        $dspokehole = session('dspokehole', null);
        $ncross = session('ncross', null);
        $spokeLengths = session('spokeLengths', null);
 
        # Return the view, making the above data available for use
        return view('pages.welcome')->with([
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
