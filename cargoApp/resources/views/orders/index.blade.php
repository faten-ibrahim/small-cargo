@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
    @include('flash-message')
    <h2>Manage Orders</h2>

    <a class="btn btn-primary" href="{{route('orders.excel')}}"><i class="fa fa-download"></i><span>Export Orders</span></a><br><br>
    <table id="example" class="table table-striped">
        <thead>
            <th>Company name</th>
            <th>Shipment type</th>
            <th>Pick up date/time</th>
            <th>Status</th>
            <th>Estimated cost</th>
            <th>Final cost</th>
            <th>Driver name</th>
            <th>Driver phone</th>
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
                url: '/orders_list',
                dataType: 'json',
                type: 'get',
            },
            columns: [{
                    data: 'comp_name'
                },
                {
                    data: 'shipment_type'
                },
                {
                    data: 'pickup_date'
                },
                {
                    data: 'status'
                },
                {
                    data: 'estimated_cost'
                },
                {
                    data: 'final_cost'
                },
                {
                    data: 'name'
                },
                {
                    data: 'phone'
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
