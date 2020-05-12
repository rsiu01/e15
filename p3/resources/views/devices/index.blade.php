@extends('layouts.master')

@section('title')
    All Devices
@endsection

@section('head')
    <link href='/css/devices/index.css' rel='stylesheet'>
@endsection

@section('content')

    <div id='newDevices'>
        <h2>Recently Added Devices</h2>
        <ul>
        @foreach($newDevices as $device) 
            <li><a href='/devices/{{ $device->slug }}'>{{ $device->slug }}</a></li>
            
        @endforeach
        </ul>
    </div>

    <h1>All Devices</h1>

<br>

    @if(count($devices) == 0) 
        No devices have been added yet...
    @else
        <div id='devicesBox'>
         
            @foreach($devices as $device)
                
                <a class='device' href='/devices/{{ $device->slug }}'>{{ $device->slug }}</a>
                    
                <a class='monitor' href='/readings/{{ $device->slug }}'><i class="fas fa-temperature-low"></i></a>
                
            @endforeach
         
        </div>
    @endif

@endsection