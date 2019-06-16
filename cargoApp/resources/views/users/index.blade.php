@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2>Manage Supervisors</h2>
<a class="btn btn-info" href="{{route('users.create')}}"><i class="fa fa-plus"></i><span>Add New Supervisor</span></a><br><br>
<a class="btn btn-primary"href="{{route('supervisors.excel')}}"><i class="fa fa-download"></i><span>Export Supervisors</span></a><br><br>
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
                {
                    mRender: function(data, type, row) {
                        if (row.status =='Active')
                            return '<span style="color:#0C9D2C; font-weight: bold;">Active<span>'
                        else if (row.status =='Inactive')
                            return '<span style="color:red;  font-weight: bold;">InActive<span>'
                    }
                },
                // { data: 'drivers_count' },
                {
                    mRender: function(data, type, row) {
                         return '<span style="margin-left:5%;">'+row.drivers_count+'</>'+'<a href="/users/' + row.id + '" class="btn btn-link"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Show"></i><span>show</span></a>'
                            }
                },
                {
                    mRender: function(data, type, row) {
                         return '<a  style="margin-left:15px;" href="/users/' + row.id + '/edit" class="bttn btn btn-xs btn-success"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i><span>Edit</span></a>'+
                            '<form method="POST" action="users/'+row.id+'">@csrf {{ method_field('DELETE')}}<button  type="submit" onclick="return myFunction();" class="bttn btn btn-xs btn-danger "><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>'
                            }
                },
                {
                    mRender: function(data, type, row) {
                            if (!row.banned_at)
                                return '<a href="/users/' + row.id + '/ban" class="bttn btn btn-xs btn-warning " data-id="' + row.id + '" style="margin-left:10px;"><i class="fa fa-ban"></i><span>Deactive</span></a>'
                            else
                                return  '<a href="/users/' + row.id + '/unban" class="bttn btn btn-xs btn-success" data-id="' + row.id + '" ><i class="fa fa-check"></i><span>Active</span></a>'

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

                //confirm deleting
                function myFunction(){
                     var agree = confirm("Are you sure you want to delete this Supervisdor?");
                        if(agree == true){
                           return true
                           }
                           else{
                           return false;
                           }
                     }

    </script>


</div>

@endsection
