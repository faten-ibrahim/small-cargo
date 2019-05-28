@extends('layouts.base')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="app">

@include('flash-message')

@yield('content')

</div>
<br>

<div class="container con">
<form method="post" action="/users/{{$user->id}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    @if($user->hasRole('admin'))

    <div class="form-group">
    <label>Name:</label>
    <input type="text" name="name"  value="{{$user->name}}" class="form-control"/>
    </div>

    <div class="form-group">
    <label>Email:</label>
    <input type="email" name="email"  value="{{$user->email}}" class="form-control"/>
    </div>

    <div class="form-group">
    <label>Old Password:</label>
    <input type="password" name="old-password" placeholder="Insert old password here" class="form-control"/>
    </div>

    <div class="form-group">
    <label>New Password:</label>
    <input type="password" name="new-password" placeholder="New password" class="form-control"/>
    </div>

    <div class="form-group">
    <label>Confirm Password:</label>
    <input type="password" name="password-confirmation" placeholder="Confirm password" class="form-control"/>
    </div>
    @endif


    @if($user->hasRole('supervisor'))

    <div class="form-group">
    <label>Name:</label>
    <input type="text" name="name"  value="{{$user->name}}"  class="form-control"/>
    <div>

    <div class="form-group">
    <label>Email:</label>
    <input type="email" name="email"  value="{{$user->email}}" class="form-control"/>
    </div>

    <div class="form-group">
    <label>Phone Number :</label>
    <input type="phone" name="phone"  value="{{$user->phone}}" class="form-control"/>
    </div>

    <div class="form-group">
    <label>Address:</label>
    <input type="text" name="address" value="{{$user->address}}" class="form-control"/>
    </div>

    <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" value="{{$user->status}}">
            <option value=" ">---  SELECT ---</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
        </div>

    @endif

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{route('users.index')}}" class="btn btn-danger">Back</a>
    </div>
</form>

@endsection
