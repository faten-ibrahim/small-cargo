@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2> {{ucfirst($company->name)}} Conatct List</h2>
    <table id="example" class="table table-hover" >
        <thead >
            <tr>
                <th>Receiver Name</th>
                <th>Conatct Name</th>
                <th>Contact Phone</th>
                <th>Address</th>
                <th>Latitude </th>
                <th>Longitude</th>
                <th>Created At</th>

            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->receiver_name}}</td>
                <td>{{$contact->conatct_name}}</td>
                <td>{{$contact->contact_phone}}</td>
                <td>{{$contact->address_address}}</td>
                <td>{{$contact->address_latitude}}</td>
                <td>{{$contact->address_longitude}}</td>
                <td>{{$contact->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
