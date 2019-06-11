@extends('layouts.base')
@section('content')

<div class="container con">
    <h2>Add Company</h2>

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
            <input name="name" type="text" class="form-control"  value="{{$company->name}}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{$company->email}}"/>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" value="{{$company->phone}}"/>
        </div>

        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address" class="form-control map-input" value="{{$company->address}}">
            <input type="hidden" name="address_latitude" id="address-latitude" value="0" value="{{$company->address_latitude}}" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="0" value="{{$company->address_longitude}}"/>
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
