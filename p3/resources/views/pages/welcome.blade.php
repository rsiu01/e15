@extends('layouts.master')

@section('content')
    <h1>Welcome to Temperature and Humidity Monitor</h1>

@if(Auth::user())
    <h3>Hello {{ $userName }}!</h3>
@endif

@endsection