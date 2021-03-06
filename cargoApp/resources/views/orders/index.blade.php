@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2 style="font-style: italic;">Manage Orders</h2>

<table id="example" class="table table-striped" >
        <thead >
                <th>Company name</th>
                <th>Shipment type</th>
                <th>Pick up date/time</th>
                <th>Status</th>
                <th>Estimated cost</th>
                <th>Final cost</th>
                <th>Driver name</th>
                <th>Driver phone</th>
                <th>Details</th>
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
                url: '/orders_list',
                dataType : 'json',
                type: 'get',
            },
            columns: [
                { data: 'comp_name',name: 'companies.comp_name'},
                { data: 'shipment_type' },
                { data: 'pickup_date' },
                {
                    mRender: function(data, type, row) {

                        if (row.status =='pending')
                            return '<span style="color:#0C9D2C; font-weight: bold;">Pending<span>'
                        else if (row.status =='accepted')
                            return '<span style="color:#B7C10E;  font-weight: bold;">Accepted<span>'
                        else if (row.status =='ongoing')
                            return '<span style="color:#FE9C23;  font-weight: bold;">Ongoing<span>'
                        else if (row.status =='delivered')
                            return '<span style="color:#F40104;  font-weight: bold;">Delivered<span>'
                         else if (row.status =='completed')
                            return '<span style="color:#367fa9;  font-weight: bold;">Completed<span>'

                    }
                },
                {
                    mRender: function(data, type, row) {
                            if (row.estimated_cost)
                               return '<span>' + row.estimated_cost + '</span>'
                            else
                            return '-'
                            }
                },
                {
                    mRender: function(data, type, row) {
                            if (row.status === 'completed')
                                return '<span>' + row.final_cost + '</span>'
                            else
                                return 'Not Deliverd yet'
                            }
                },
                {
                    mRender: function(data, type, row) {
                            if (row.name)
                               return '<span>' + row.name + '</span>'
                            else
                            return '-'
                            }
                },
                {
                    mRender: function(data, type, row) {
                            if (row.phone)
                               return '<span>' + row.phone + '</span>'
                            else
                            return '-'
                            }
                },
                {
                    mRender: function(data, type, row) {
                         return `
                            <button type="button" class="btn btn-primary dd" data-toggle="modal" data-target="#${row.id}">
                            Details
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="${row.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                <table class="table table-striped">
                                <tbody>
                                    <tr>
                                    <th>Length</th>
                                    <td>${row.length}</td>
                                    <tr>
                                    <th>Width</th>
                                    <td>${row. width}</td>
                                    <tr>
                                    <th>Height</th>
                                    <td>${row.height}</td>
                                    <tr>
                                    <th>Quantity</th>
                                    <td>${row. quantity}</td>
                                    <tr>
                                    <th>Weight</th>
                                    <td>${row.Weight}</td>
                                    <tr>
                                    <th>Value</th>
                                    <td>${row.value}</td>
                                    <tr>
                                    <th>Pickup location</th>
                                    <td>${row.pickup_location}</td>
                                    <tr>
                                    <th>Drop off location</th>
                                    <td>${row.drop_off_location}</td>
                                    <tr>
                                    <th>Time to deliver</th>
                                    <td>${row.time_to_deliver}</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>`
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
