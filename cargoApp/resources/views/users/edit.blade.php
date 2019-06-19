@extends('layouts.base')
@section('content')


<div class="container con">
    <h2>Add Supervisor</h2>
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

    <form method="post" action="/users/{{$user->id}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}

        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" class="form-control" value="{{$user->name}}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{$user->email}}"/>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" value="{{$user->phone}}" />
        </div>

        <br>
        <br>

        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address" class="form-control map-input" value="{{$user->address}}">
            <input type="hidden" name="address_latitude" id="address-latitude" value="{{$user->address_latitude}}" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="{{$user->address_longitude}}" />
        </div>

        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
        <br>
        <br>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" value="{{$user->status}}">
                <option value='active' <?php   if($user->status=="active") echo "selected='selected'";?> >Active</option>
                <option value='inactive' <?php   if($user->status=="inactive") echo "selected='selected'";?> >InActive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('users.index')}}" class="btn btn-danger">Back</a>

        <br>
        <br>
    
    </form>
</div>

@endsection
@section('content_scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
@stop
