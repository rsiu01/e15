@extends('layouts.master')

@section('title')

    Edit - {{ old('slug', $device->slug) }}   
@endsection



@section('head')
    <link href='/css/devices/edit.css' rel='stylesheet'>
@endsection


@section('content')

    <h1>Edit Device {{ old('slug', $device->slug) }}</h1>
    

<div class='deviceEdit'>
    <form method='POST' action='/devices/{{ $device->slug }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        {{  method_field('put') }}

        <label for='title'>* Slug URL</label>
        <div class='details'>The slug is a unique URL identifier for the device, containing only alphanumeric characters and dashes. 
        </div>
        <input dusk='slug-input' type='text' name='slug' id='slug' value='{{ old('slug', $device->slug) }}'>
        @include('includes.error-field', ['fieldName' => 'slug'])

        <label for='description'>Description</label>
        <textarea dusk='description-input' name='description'>{{ old('description', $device->description) }}</textarea>
        @include('includes.error-field', ['fieldName' => 'description'])

        <label for='location'>*  Location</label>
        <input dusk='location-input' type='text' name='location' id='location' value='{{ old('location', $device->location) }}'>
        @include('includes.error-field', ['fieldName' => 'location'])

        <label for='low_temperature'>* Low Temperature</label>
        <input dusk='low_temperature-input' type='text' name='low_temperature' id='low_temperature' value='{{ old('low_temperature', $device->low_temperature) }}'>
        @include('includes.error-field', ['fieldName' => 'low_temperature'])

        <label for='high_temperature'>* High Temperature</label>
        <input dusk='high_temperature-input' type='text' name='high_temperature' id='high_temperature' value='{{ old('high_temperature', $device->high_temperature) }}'>
        @include('includes.error-field', ['fieldName' => 'high_temperature'])

        <label for='calibration_offset'>* Calibration Offset</label>
        <input dusk='calibration_offset-input' type='text' name='calibration_offset' id='calibration_offset' value='{{ old('calibration_offset', $device->calibration_offset) }}'>
        @include('includes.error-field', ['fieldName' => 'calibration_offset'])

        <label>
            Report Alarms:
        </label>
        <input dusk='alarm-box' type='checkbox' name='alarm' id='alarm' value='TRUE' {{ (old('alarm') == 'TRUE' or $device->alarm == 1) ? 'checked' : '' }}>
        <label for='alarm'>On</label>
        <BR>

        <input dusk='submit-button' type='submit' class='btn btn-primary' value='Update'>
    </form>
</div> 
   
@endsection