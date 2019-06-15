@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
    @include('flash-message')
    <h2>Manage Drivers</h2>
    <a class="btn btn-info" href="{{route('drivers.create')}}"><i class="fa fa-plus"></i><span>Add New Driver</span></a><br><br>
    <a class="btn btn-primary"href="{{route('drivers.excel')}}"><i class="fa fa-download"></i><span>Export Drivers</span></a><br><br>
    <table id="example" class="table table-striped" >
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
            <th>Actions</th>
            <th>Active/InActive</th>
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
                data: 'status_driver'
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
                data: 'status_driver'
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
        c_array.push(
            {
                    mRender: function (data, type, row) {
                        return '<a href="/drivers/' + row.id + '/edit" class="bttn btn btn-xs btn-success" ><i class="fa fa-edit"></i><span>Edit</span></a>'+
                        '<form style="display:inline" method="POST" action="drivers/'+row.id+'">@csrf   {{ method_field('DELETE')}}<button type="submit" onclick="return myFunction();" class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Delete</button></form>'

                    }
                },
            {
                    mRender: function (data, type, row) {
                        if (!row.banned_at && row.status_driver=='active')
                        return '<a href="/drivers/' + row.id + '/ban" class="bttn btn btn-xs btn-warning" data-id="' + row.id + '"><i class="fa fa-ban"></i><span>Deactive</span></a>'
                        else
                        return '<a href="/drivers/' + row.id + '/unban" class="bttn btn btn-xs btn-success" data-id="' + row.id + '" ><i class="fa fa-check"></i><span>Active</span></a>'

                    }
                },
         );
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

        function myFunction() {
            var agree = confirm("Are you sure you want to delete ?");
            if (agree == true) {
                return true
            } else {
                return false;
            }
        }
    </script>


</div>

@endsection
