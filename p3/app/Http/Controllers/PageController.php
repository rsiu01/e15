<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * GET /
     */
    public function welcome(Request $request)
    {
        
        //$user = Auth::user();
        $user = $request->user();
 
        # Return the view, making the above userName available for use in the video
        return view('pages.welcome')->with([
             'userName' => $user->first_name ?? null,
         ]);
    }
}
