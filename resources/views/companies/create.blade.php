@extends('layouts.base')



    @section('content')
    <!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

    <br>
    <br>

    <div class="container con">
        <h2>Add Company</h2>

    <form action="{{route('companies.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Company Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control"/>
        </div>


        <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone"  type="phone" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('companies.index')}}" class="btn btn-danger">Back</a>
    </form>
 </div>
 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
