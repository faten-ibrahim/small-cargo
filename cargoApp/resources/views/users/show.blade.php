@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2 style="font-style: italic;"> {{ucfirst($supervisor_name)}} Drivers List</h2>
    <table id="example" class="table  table-striped table-bordered " >
        <thead class="thead-dark" >
            <tr class="bg-primary">
                <th>Driver name</th>
                <th>Phone number</th>
                <th>Address</th>
                <th>Creation date</th>
                <th>Status</th>
                <th>Availability</th>
                <th>Car Type</th>
                <th>Car Number</th>
                <th> Rating</th>
                <th> Number of orders</th>
                <!-- <th> Balance</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $driver)
            <tr>
                <td>{{$driver->name}}</td>
                <td>{{$driver->phone}}</td>
                <td>{{$driver->address}}</td>
                <td>{{$driver->created_at}}</td>
                <td>{{$driver->status_driver}}</td>
                <td>{{$driver->availability}}</td>
                <td>{{$driver->car_type}}</td>
                <td>{{$driver->car_number}}</td>
                <td>{{$driver->rating}}</td>
                <td>{{$driver->count}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
