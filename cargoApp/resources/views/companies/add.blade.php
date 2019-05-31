@extends('layouts.base')
@section('content')

<div class="container con">
    <h2>Add Contact</h2>

    <form action="{{route('companies.store_list')}}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="company_id" value="{{$company->id}}">
        <div class="form-group">
            <label>Receiver Name</label>
            <input name="receiver_name" type="text" class="form-control" />
        </div>
        <div class="form-group">
            <label>Contact Name</label>
            <input name="conatct_name" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Contact Phone</label>
            <input name="contact_phone" type="phone" class="form-control" />
        </div>

        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address_address" class="form-control map-input">
            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
        </div>

        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>

        <br>
        <br>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</div>

@endsection


@section('content_scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
@stop
