@extends('layouts.master')

@section('head')
    <link href='/css/pages/welcome.css' rel='stylesheet'>
@endsection

@section('content')

<div class='header'>
    <h1>Welcome to Temperature and Humidity Monitor</h1>
</div>

<div class='userHello'>
    @if(Auth::user())
        <h2>Hello {{ $userName }}!</h2>
    @endif
</div>

@endsection