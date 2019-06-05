@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
    @include('flash-message')
    <h2>Manage Drivers</h2>
    <a class="btn btn-info" href="{{route('users.create')}}"><i class="fa fa-plus"></i><span>Add New Supervisor</span></a><br><br>
    <table id="example" class="table table-striped">
        <thead>
            <th>Name</th>
            <th>Phone number</th>
            <th>Address</th>
            <th>Creation date</th>
            <th>Status</th>
            <th>Availability</th>
            <th>Car Type</th>
            <th>Car Number</th>
            <th> Rating</th>
            <th> Orders number</th>
            @role('admin')
            <th>Supervisor name</th>
            @endrole
            </tr>
        </thead>
    </table>


    @endsection
    @section('content_scripts')
    @role('admin')
    <script>
        var c_array = [{
                data: 'name'
            },
            {
                data: 'phone'
            },
            {
                data: 'address'
            },
            {
                data: 'created_at'
            },
            {
                data: 'status'
            },
            {
                data: 'availability'
            },
            {
                data: 'car_type'
            },
            {
                data: 'car_number'
            },
            {
                data: 'rating'
            },
            {
                data: 'count'
            },
            {
                data: 'supervisor_name'
            },
        ];
    </script>
    @endrole
    @role('supervisor')
    <script>
        var c_array = [{
                data: 'name'
            },
            {
                data: 'phone'
            },
            {
                data: 'address'
            },
            {
                data: 'created_at'
            },
            {
                data: 'status'
            },
            {
                data: 'availability'
            },
            {
                data: 'car_type'
            },
            {
                data: 'car_number'
            },
            {
                data: 'rating'
            },
            {
                data: 'count'
            },


        ];
        // console.log(c_array);
    </script>
    @endrole
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#example').DataTable({

            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('get.drivers')); ?>',
                dataType: 'json',
                type: 'get',
            },
            columns: c_array,

            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'paging': true,
        });
    </script>


</div>

@endsection
