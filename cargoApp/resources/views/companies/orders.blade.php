<!-- @extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2>{{$company->name}} orders</h2>

<table id="example" class="table table-striped" >
        <thead >
                <th>Shipment type</th>
                <th>Pick up date/time</th>
                <th>Status </th>
                <th>Estimated cost</th>
                <th>Final date</th>

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
                url: '/get_orders/{{$company->id}}',
                dataType : 'json',
                type: 'get',
            },
            columns: [
                { data: 'shipment_type' },
                { data: 'pickup_date' },
                { data: 'status' },
                { data: 'estimated_cost' },
                { data: 'final_cost' },

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

@endsection -->
