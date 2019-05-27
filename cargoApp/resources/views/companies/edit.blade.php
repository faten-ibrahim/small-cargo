@extends('layouts.base')
@section('content')

<div class="container con">

    <form  method="POST" action="/companies/{{$company->id}}" >
    {{ csrf_field() }}
    {{ method_field('patch') }}
    
        @if ($errors->any())
        <br>
        <br>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @csrf

        <div class="form-group">
            <label>Company Name</label>
            <input name="name" type="text" class="form-control" value="{{$company->name}}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{$company->email}}"/>
        </div>


        <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" value="{{$company->address}}"/>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" value="{{$company->phone}}"/>
        </div>
     <br>
        <h3>Contact List</h3>
        <hr style="border: 1px solid #7d747a1f">
        <br>

        <div class="form-group">
            <label>Receiver Name:</label>
            <input name="receiver_name" type="text" class="form-control" value="{{$contact_list->receiver_name}}" />
        </div>
        <div class="form-group">
            <label>Contact Name:</label>
            <input name="conatct_name" type="text" class="form-control" value="{{$contact_list->conatct_name}}"/>
        </div>

        <div class="form-group">
            <label>Contact Phone:</label>
            <input name="contact_phone" type="phone" class="form-control" value="{{$contact_list->contact_phone}}" />
        </div>

        <div class="form-group">
            <label for="address_address">Address:</label>
            <input type="text" id="address-input" name="address_address" class="form-control map-input" value="{{$contact_list->address_address}}">
            <input type="hidden" name="address_latitude" id="address-latitude" value="{{$contact_list->address_latitude}}" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="{{$contact_list->address_longitude}}" />
        </div>

        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>

        <br>
        <br>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('companies.index')}}" class="btn btn-danger">Back</a>

    </form>
</div>

@endsection


@section('content_scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
@stop
