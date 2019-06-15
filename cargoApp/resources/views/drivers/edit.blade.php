@extends('layouts.base')
@section('content')
<div class="container con">

    <form action="{{route('drivers.edit')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <!-- <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" />
        </div> -->

        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address" class="form-control map-input" value="{{$driver->address}}">  
            <input type="hidden" name="address_latitude" id="address-latitude" value="{{$driver->address_latitude}}" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="{{$driver->address_longitude}}" />
        </div>

        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" value="{{$driver->phone}}"/>
        </div>

        <div class="form-group">
            <label>Car Type</label>
            <input name="car_type" type="text" class="form-control" value="{{$driver->car_type}}"/>
        </div>

        <div class="form-group">
            <label>Car Number </label>
            <input name="car_number" type="text" class="form-control" value="{{$driver->car_number}}" />
        </div>

        @role('admin')
        <div class="form-group">
            <label for="exampleInputPassword1">Supervisor</label>
            <select class="form-control" name="user_id">
                <option> - - select - - </option>
                @foreach($supervisors as $supervisor)
                <option value="{{$supervisor->id}}">{{$supervisor->name}}</option>
                @endforeach
            </select>
        </div>
        @endrole
        <button type="submit" class="btn btn-primary">Submit</button>
        <br>
        <br>
        @if ($errors->any())
        <br>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>

@endsection

@section('content_scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
@stop
