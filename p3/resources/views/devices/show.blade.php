@extends('layouts.master')

@section('title')
{{ $device ? $device->slug : 'Device not found' }}
@endsection

@section('head')
    <link href='/css/devices/show.css' rel='stylesheet'>
@endsection

@section('content')

@if(!$device) 
    Device not found. <a href='/devices'>Check out the other devices...</a>
@else


<h1 class='deviceHeader'>{{ $device->slug }}</h1>

<div class='deviceShow'>
    <table >
        <tr>
            <th>Description</th>
            <td>{{ $device->description }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $device->location }}</td>
        </tr>
        <tr>  
            {{-- https://www.w3schools.com/charsets/ref_utf_letterlike.asp degrees celcius: &#8451 --}}
            <th>Low Temperature &#8451</th>
            <td>{{ $device->low_temperature }}</td>
        </tr>
        <tr>
            <th>High Temperature &#8451</th>
            <td>{{ $device->high_temperature }}</td>
        </tr>
        <tr>
            <th>Calibration Offset &#8451</th>
            <td>{{ $device->calibration_offset }}</td>
        </tr>
    </table>
</div>

<div class='deviceActions'>    
    <a dusk='monitor-button' class='monitor-button' href='/readings/{{ $device->slug }}'><i class="fas fa-temperature-low"></i> Monitor</a>
    <a dusk='edit-button' class='edit-button' href='/devices/{{ $device->slug }}/edit'><i class="fa fa-edit"></i> Edit</a>
    <a dusk='delete-button' class='delete-button' href='/devices/{{ $device->slug }}/delete'><i class="fa fa-trash"></i> Delete</a>
</div>

@endif

@endsection