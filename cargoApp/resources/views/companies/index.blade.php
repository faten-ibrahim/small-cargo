@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2>Manage Companies</h2>
<a class="btn btn-info" href="{{route('companies.create')}}"><i class="fa fa-plus"></i><span>Add New Company</span></a><br><br>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>status</th>
                <th>Orders Number</th>
                <th>Actions</th>
                <th>Active/InActive</th>
            </tr>
        </thead>
    </table>

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#example').DataTable({

            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('get.companies')}}',
                dataType: 'json',
                type: 'get',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'address'
                },
                {
                    data: 'status'
                },
                {
                    data: 'orders_count'
                },
                {
                    mRender: function(data, type, row) {
                         return '<a  style="margin-left:15px;" href="/companies/' + row.id + '/edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i><span>Edit</span></a>'+ 
                            '&ensp;<form method="POST" action="companies/'+row.id+'">@csrf {{ method_field('DELETE')}}<button  type="submit" onclick="return myFunction();" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>'+
                             '<a href="/companies/' + row.id + '/orders" class=" btn btn-xs btn-info" data-id="' + row.id + '" style="margin-left:10px;"><span>Show Orders</span></a>'+
                            '<a href="/companies/' + row.id + '/contacts" class=" btn btn-xs btn-success" data-id="' + row.id + '" style="margin-left:10px;"><span>Contact List</span></a>'
                            }
                },

            
                {
                    mRender: function(data, type, row) {
                         return '<a href="/companies/' + row.id + '/unban" class=" btn btn-warning" data-id="' + row.id + '" style="margin-left:10px;"><i class="fa fa-close"></i><span>Inactive</span></a>'
                            }
                },
            ],
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

