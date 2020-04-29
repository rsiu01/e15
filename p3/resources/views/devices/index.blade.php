@extends('layouts.master')

@section('title')
    All Devices
@endsection

@section('head')
    {{--<link href='/css/books/index.css' rel='stylesheet'>--}}
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
    @if(count($devices) == 0) 
        No devices have been added yet...
    @else
    <div id='devices'>
        @foreach($devices as $device)
        <a class='device' href='/devices/{{ $device->slug }}'>
            <h3>{{ $device->slug }}</h3>
        </a>
        @endforeach
    </div>
    @endif

@endsection