@extends('layouts.base')
@section('content')
<div class="container con">
    <h2>Add Driver</h2>

    <form action="{{route('drivers.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" />
        </div>

        <div class="form-group">
            <label>Car Type</label>
            <input name="car_type" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Car Number </label>
            <input name="car_number" type="text" class="form-control" />
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
