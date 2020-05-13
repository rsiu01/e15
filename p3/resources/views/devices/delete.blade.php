@extends('layouts.master')

@section('head')
    
@endsection

@section('title')
    Confirm deletion: {{ $device->slug }}
@endsection

@section('content')

    <h1>Confirm deletion</h1>

    <p>Are you sure you want to delete <strong>{{ $device->slug }}</strong>?</p>

    <form method='POST' action='/devices/{{ $device->slug }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input dusk='confirm-delete-button' type='submit' value='Yes, delete it!' class='btn btn-danger btn-small'>
    </form>

    <p class='cancel'>
        <a href='/devices/{{ $device->slug }}'>No, I changed my mind.</a>
    </p>

@endsection