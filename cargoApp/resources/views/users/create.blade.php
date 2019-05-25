@extends('layouts.base')
@section('content')

<div class="container con">
    <h2>Add Supervisor</h2>

    <form action="{{route('users.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" />
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
            <label>Status</label>
            <select name="status" class="form-control">
                <option> - -  select  - - </option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('users.index')}}" class="btn btn-danger">Back</a>
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
