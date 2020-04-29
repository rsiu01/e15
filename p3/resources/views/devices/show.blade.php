@extends('layouts.master')

@section('title')
{{ $device ? $device->slug : 'Device not found' }}
@endsection

@section('head')
{{--<link href='/css/books/show.css' rel='stylesheet'>--}}
@endsection

@section('content')

@if(!$device) 
    Device not found. <a href='/devices'>Check out the other devices...</a>
@else


<h1>{{ $device->slug }}</h1>

<table>
    <tr>
        <th>Description:</th>
        <td>{{ $device->description }}</td>
    </tr>
    <tr>
        <th>Location:</th>
        <td>{{ $device->location }}</td>
    </tr>
    <tr>  
        {{-- https://www.w3schools.com/charsets/ref_utf_letterlike.asp degrees celcius: &#8451 --}}
        <th>Low Temperature &#8451 :</th>
        <td>{{ $device->low_temperature }}</td>
    </tr>
    <tr>
        <th>High Temperature &#8451 :</th>
        <td>{{ $device->high_temperature }}</td>
    </tr>
    <tr>
        <th>Calibration Offset &#8451 :</th>
        <td>{{ $device->calibration_offset }}</td>
    </tr>
</table>



<ul class='deviceActions'>
    <li><a href='/devices/{{ $device->slug }}/edit'><i class="fa fa-edit"></i> Edit</a>
    <li><a href='/devices/{{ $device->slug }}/delete'><i class="fa fa-trash"></i> Delete</a>
</ul>
@endif

@endsection