<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Reading;

class DeviceController extends Controller
{
    
    # Get all the devices
    public function index()
    {
        $devices = Device::orderBy('id')->get();
        
        $newDevices = $devices->sortByDesc('created_at')->take(3);
        
        return view('devices.index')->with([
            'devices' => $devices,
            'newDevices' => $newDevices
        ]);
    }

    # Add a device
    public function create(Request $request)
    {
        # Get location data for devices in alphabetical order
        $devices = Device::orderby('id');
        return view('devices.create');
    }

    # Store a device
    public function store(Request $request)
    {
        
        # Validate the request data
        # The `$request->validate` method takes an array of data
        # where the keys are form inputs
        # and the values are validation rules to apply to those inputs
        $request->validate([
            'slug' => 'required|unique:devices,slug|alpha_dash',
            'low_temperature' => 'required|numeric',
            'high_temperature' => 'required|numeric',
            'calibration_offset' => 'required|numeric',
            'location' => 'required|string'
          
        ]);
        
       

        # Note: If validation fails, it will automatically redirect the visitor back to the form page
        # and none of the code that follows will execute.

        # Add the device to the database
        $newDevice = new Device();
        $newDevice->slug = $request->slug;
        $newDevice->low_temperature = $request->low_temperature;
        $newDevice->high_temperature = $request->high_temperature;
        $newDevice->calibration_offset = $request->calibration_offset;
        $newDevice->location = $request->location;
        if ($request->alarm == 'TRUE') {
            $newDevice->alarm = true;
        } else {
            $newDevice->alarm = false;
        }

        $newDevice->save();

        return redirect('/devices/create')->with([
            'flash-alert' => 'Your device "/'.$newDevice->slug.'" was added.'
        ]);
    }

    # Read database for device
    public function show($slug)
    {
        $device = Device::where('slug', '=', $slug)->first();
    
        return view('devices.show')->with([
                'device' => $device,
                'slug' => $slug,
            ]);
    }

    public function edit(Request $request, $slug)
    {
        $device = Device::where('slug', '=', $slug)->first();

        return view('devices.edit')->with([
            'device' => $device
            
        ]);
    }

    # Updates database for a device
    public function update(Request $request, $slug)
    {
        $device = Device::where('slug', '=', $slug)->first();

        $request->validate([
            'slug' => 'required|alpha_dash',
            'low_temperature' => 'required|numeric',
            'high_temperature' => 'required|numeric',
            'calibration_offset' => 'required|numeric',
            'location' => 'required|string'
          
        ]);

        $device->slug = $request->slug;
        $device->low_temperature = $request->low_temperature;
        $device->high_temperature = $request->high_temperature;
        $device->calibration_offset = $request->calibration_offset;
        $device->location = $request->location;
        if ($request->alarm == 'TRUE') {
            $device->alarm = true;
        } else {
            $device->alarm = false;
        }
        $device->save();

        

        return redirect('/devices/'.$slug.'/edit')->with([
            'flash-alert' => 'Your changes were saved.'
        ]);
    }

    # delete device
    public function delete($slug)
    {
        $device = Device::findBySlug($slug);

        if (!$device) {
            return redirect('/devices')->with([
                'flash-alert' => 'Device not found'
            ]);
        }

        return view('devices.delete')->with([
            'device' => $device,
        ]);
    }

    public function destroy($slug)
    {
        $device = Device::findBySlug($slug);

        # delete all readings associated with device_id before deleting device
        $reading = Reading::findByDevice($slug);

        $reading->delete();

        $device->delete();

        return redirect('/devices')->with([
            'flash-alert' => '“' . $device->slug . '” was removed.',
            'device' => $device
        ]);
    }
}
