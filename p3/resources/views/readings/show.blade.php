@extends('layouts.master')

@section('title')
    All Readings
@endsection

@section('head')
    <link href='/css/readings/show.css' rel='stylesheet'>
@endsection
<head>
    
</head>
@section('content')


    <h1>Device: {{$slug}} Description: {{$device->description}} Location: {{$device->location}}</h1>


    <form class='paginateForm' method="POST" action="/readings/{{ $device->slug }}">
        @csrf
        {{-- Using a little bit of JavaScript to submit form when dropdown selection is changed --}}
        {{-- https://stackoverflow.com/questions/7231157/how-to-submit-form-on-change-of-dropdown-list --}}
        
        <label for="numberReadings">Readings per page:</label>
        <select dusk='numberReadings-dropdown' name="numberReadings" id="numberReadings" onchange="this.form.submit()">
            <option selected="selected">{{ old('numberReadings',$numberReadings) }}</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="500">500</option>
            <option value="1000">1000</option> {{-- 1000 max; more may hinder performance --}}
        </select>

        <label for="page">Page:</label>
        <select dusk='page-dropdown'name="page" id="page" onchange="this.form.submit()">
            <option selected="selected">{{ old('page' , $page) }}</option>
            @for($i = 1; $i <= $numberPages; $i++)
                <option value="{{ $i }}" >{{ $i }}</option>
            @endfor
        </select>      
    </form>

       
    
{{-- Chart Container --}}
<div dusk='chartContainer' class='chartContainer'>
    {!! $chart->container() !!}
</div>

{{-- ChartScript --}}
@if($chart)
    
    {!! $chart->script() !!}

         
@else 
    No readings have been recorded yet...
@endif

@endsection
