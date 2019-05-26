@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
    <table id="example" class="table table-striped" >
        <thead >
                <th>Supervisor name</th>
                <th>Phone number</th>
                <th>Email address</th>
                <th>Address</th>
                <th>Creation date</th>
                <th>Status</th>
                <th>Number of drivers</th>
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