@extends('layouts.master')

@section('title')
    All Readings
@endsection

@section('head')
    {{--<link href='/css/books/index.css' rel='stylesheet'>--}}
@endsection
<head>
    
</head>
@section('content')


    <h1>Device: {{$slug}} Description: {{$device->description}} Location: {{$device->location}}</h1>

<form method="POST" action="/readings/{{ $device->slug }}">
    @csrf
    {{-- Using a little bit of JavaScript to submit form when dropdown selection is changed --}}
    {{-- https://stackoverflow.com/questions/7231157/how-to-submit-form-on-change-of-dropdown-list --}}
    <select name="number_readings" id="number_readings" onchange="this.form.submit()">
        <option selected="selected">{{ old('number_readings',$number_readings) }}</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="1000">1000</option>
        <option value="10000">10000</option>
        <option value="100000">100000</option>
        <option value="1000000">1000000</option>
    </select>
    
</form>
     
       
    

    {!! $chart->container() !!}
   
    {{-- ChartScript --}}
    @if($chart)
    {!! $chart->script() !!}
         
    @else 
    No readings have been recorded yet...
    @endif

@endsection
