@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
<h2>Manage Supervisors</h2>
<a class="btn btn-info" href="{{route('users.create')}}"><i class="fa fa-plus"></i><span>Add New Supervisor</span></a><br><br>
    <table id="example" class="table table-striped" >
        <thead >
            <tr>
                <th>Id</th>
                <th>name</th>
                <th>Email</th>
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
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
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
