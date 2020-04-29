@extends('layouts.master')

@section('title')
    Add a device
@endsection

@section('content')

    <h1>Add a device</h1>


    <form method='POST' action='/devices'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='title'>* Slug URL</label>
        <div class='details'>The slug is a unique URL identifier for the device, containing only alphanumeric characters and dashes. 
        </div>
        <input type='text' name='slug' id='slug' value='{{ old('slug')}}'>
        @include('includes.error-field', ['fieldName' => 'slug'])

        <label for='description'>Description</label>
        <textarea name='description'>{{ old('description') }}</textarea>
        @include('includes.error-field', ['fieldName' => 'description'])

        <label for='location'>*  Location</label>
        <input type='text' name='location' id='location' value='{{ old('location') }}'>
        @include('includes.error-field', ['fieldName' => 'location'])

        <label for='low_temperature'>* Low Temperature</label>
        <input type='text' name='low_temperature' id='low_temperature' value='{{ old('low_temperature') }}'>
        @include('includes.error-field', ['fieldName' => 'low_temperature'])

        <label for='high_temperature'>* High Temperature</label>
        <input type='text' name='high_temperature' id='high_temperature' value='{{ old('high_temperature') }}'>
        @include('includes.error-field', ['fieldName' => 'high_temperature'])

        <label for='calibration_offset'>* Calibration Offset</label>
        <input type='text' name='calibration_offset' id='calibration_offset' value='{{ old('calibration_offset') }}'>
        @include('includes.error-field', ['fieldName' => 'calibration_offset'])

        


        <label>
            Report Alarms:
        </label>
        <input type='checkbox' name='alarm' id='alarm' value='TRUE' {{ (old('alarm') == 'TRUE') ? 'checked' : '' }}>
        <label for='alarm'>On</label>
        <BR>

        <input type='submit' class='btn btn-primary' value='Add'>

    </form>
 
   
@endsection