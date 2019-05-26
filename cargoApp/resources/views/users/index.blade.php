@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
<h2>Manage Supervisors</h2>
<a class="btn btn-info" href="{{route('users.create')}}"><i class="fa fa-plus"></i><span>Add New Supervisor</span></a><br><br>
    <table id="example" class="table table-striped" >
        <thead >
                <th>Supervisor name</th>
                <th>Phone number</th>
                <th>Email address</th>
                <th>Address</th>
                <th>Creation date</th>
                <th>Status</th>
                <th>No of Drivers</th>
                <th>Actions</th>
                <th>Active/InActive</th>
            </tr>
        </thead>
    </table>

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#example').DataTable( {

            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/supervisors_list',
                dataType : 'json',
                type: 'get',
            },
            columns: [
                { data: 'name' },
                { data: 'phone' },
                { data: 'email' },
                { data: 'address' },
                { data: 'created_at' },
                { data: 'status' },
                { data: 'drivers_count' },
                {
                    mRender: function(data, type, row) {
                            return '<a href="/companies/' + row.id + '/edit" class=" btn btn-success btn-sm" data-id="' + row.id + '" style="margin-left:10px;"><i class="fa fa-edit"></i><span>Edit</span></a>' +
                            '<a href="/companies/' + row.id + '/edit" class=" btn btn-success btn-sm" data-id="' + row.id + '" style="margin-left:10px;"><i class="fa fa-delete"></i><span>Delete</span></a>' 
                            }
                },
                {
                    mRender: function(data, type, row) {
                            return '<a href="/companies/' + row.id + '/unban" class=" btn btn-warning btn-sm" data-id="' + row.id + '" style="margin-left:10px;"><i class="fa fa-close"></i><span>Inactive</span></a>'
                            }
                },

            ],

            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'paging'      : true,
        } );

    </script>


</div>

@endsection
