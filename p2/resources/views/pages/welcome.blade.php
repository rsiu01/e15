@extends('layouts.master')

@section('head')

@endsection

@section('content')
    <h1>Welcome to Spoke Calculator...</h1>


<form method='GET' action='/calculate'>

    <h2>Calculate Spoke Lengths (measurments in mm)</h2>

    <fieldset>
        <label>
            Front or Rear Wheel:
        </label>

        <input 
            type='radio' 
            name='wheel' 
            id='front' 
            value='front'
            {{ (old('wheel') == 'front' or $wheel == 'front') ? 'checked' : '' }}
        >
        <label for='front'> Front</label>

        
        <input 
            type='radio' 
            name='wheel' 
            id='rear' 
            value='rear' 
            {{ (old('wheel') == 'rear' or $wheel == 'rear') ? 'checked' : '' }}
        >
        <label for='rear'> Rear</label>
    </fieldset>

    <fieldset>

        <label for='erd'>
            ERD (effective rim diameter):
            <input type='float' name='erd' value='{{ old('erd', $erd) }}'>
        </label>


        <label for='osb'>
            OSB (offset spoke bed):
            <input type='float' name='osb' value='{{ old('osb', $osb) }}'>
        </label>

        <label for='wl'>
            WL (width from center to left flange):
            <input type='float' name='wl'value='{{ old('wl', $wl) }}'>
        </label>

        <label for='wr'>
            WR (width from center to right flange):
            <input type='float' name='wr' value='{{ old('wr', $wr) }}'>
        </label>

        <label for='dl'>
            DL (left flange diameter):
            <input type='float' name='dl' value='{{ old('dl', $dl) }}'>
        </label>

        <label for='dr'>
            DR (right flange diameter):
            <input type='float' name='dr' value='{{ old('dr', $dr) }}'>
        </label>

        <label for='nspoke'>
            Total number of spokes:
            <input type='float' name='nspoke' value='{{ old('nspoke', $nspoke) }}'>
        </label>

        <label for='dspokehole'>
            Spoke hole diameter:
            <input type='float' name='dspokehole' value='{{ old('dspokehole', $dspokehole) }}'>
        </label>

        <label for='ncross'>
            Cross number:
            <!-- using select to create drop-down list of cross patterns
            setting the default to preserve sessioned data
            source: https://stackoverflow.com/questions/19611557/how-to-set-default-value-for-html-select -->
        
            <select id='ncross' input type='float' name ='ncross'>
                <option selected="selected">{{ old('ncross', $ncross) }}</option>
                <option value='0'>0 </option>
                <option value='1'>1 </option>
                <option value='2'>2 </option>
                <option value='3'>3 </option>
                <option value='4'>4 </option>
            </select>

            
            
        </label>

    

        
            

</fieldset>    

<input type='submit' class='btn btn-primary' value='Calculate'>



    @if(count($errors) > 0)
        <ul class='alert alert-danger error'>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</form>

@if(!is_null($spokeLengths))
    @if(count($spokeLengths) == 0)
        <div class='results alert alert-warning'>
            No calculation returned.
        </div>
    @else
        <div class='results alert alert-primary'>

            <ul>
                @foreach($spokeLengths as $spoke => $length)
                    @if($spoke=='leftSpoke')
                        <ul> Left Spoke: {{$length}} mm</ul>
                    @else
                        <ul> Right Spoke: {{$length}} mm</ul>
                    @endif
                @endforeach
        </div>

        <div class='results alert alert-primary'>

                @if ($wheel=='front')
                    <ul>Front wheel:</ul>
                    <ul>DS (drive side) flange is the left flange</ul>
                    <ul>NDS (non drive side) flange is the right flange</ul>
                @else
                    Rear wheel:
                    <ul>DS (drive side) flange is the right flange</ul>
                    <ul>NDS (non drive side) flange is the left flange</ul>
                @endif
            </ul>
        </div>
    @endif
@endif


@endsection