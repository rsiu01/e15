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

     
       
    

    {!! $chart->container() !!}
   
    {{-- ChartScript --}}
    @if($chart)
    {!! $chart->script() !!}
         
    @else 
    No readings have been recorded yet...
    @endif

@endsection
