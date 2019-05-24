@extends('layouts.base')
@section('content')
<div class="container">
    <h2 class="box-title">Companies</h2><br>

    <table id="example" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>status</th>
                <th>Orders Number</th>
            </tr>
        </thead>
        <tbody>

            @foreach($companies as $i=>$company)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$company->name}}</td>
                    <td>{{$company->email}}</td>
                    <td>{{$company->phone}}</td>
                    <td>{{$company->address}}</td>
                    <td>{{$company->status}}</td>
                    <td>{{$company->orders_count}}</td>
                </tr>
            @endforeach

        </tbody>
    </table>


@endsection
