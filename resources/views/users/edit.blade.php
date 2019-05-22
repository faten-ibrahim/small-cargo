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
<form method="post" action="/users/{{$user->id}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}
    <label>Name:</label>
    <input type="text" name="name"  value="{{$user->name}}" /><br>
    <label>Email:</label>
    <input type="email" name="email"  value="{{$user->email}}" /><br>
    <label>Old Password:</label>
    <input type="password" name="old-password" placeholder="Insert old password here"/><br>
    <label>New Password:</label>
    <input type="password" name="new-password" placeholder="New password"/><br>
    <label>Confirm Password:</label>
    <input type="password" name="password-confirmation" placeholder="Confirm password"/><br>

    <button type="submit">Update</button>
</form>

@endsection