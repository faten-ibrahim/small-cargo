@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2>{{$company->name}} orders</h2>

<table class="table  table-striped table-bordered ">
  <thead class="thead-dark">
        <tr class="bg-primary">
                <th>Shipment type</th>
                <th>Pick up date/time</th>
                <th>Status </th>
                <th>Estimated cost</th>
                <th>Final date</th>
                <th>Driver Name</th>
                <th>Driver Phone</th>
                <th>Order details</th>
        </tr>
  </thead>
  <tbody>
  @foreach($orders as $order)
    <tr  class="bg-success">

      <td>{{ $order-> shipment_type }}</td>
      <td>{{ $order-> pickup_date }}</td>
      <td>{{ $order-> status }}</td>
      <td>{{ $order-> estimated_cost }}</td>
      @if( $order->status !== 'delivered') 
      <td>{{ $order-> final_cost }}</td>
      @else
      <td>Not delivered yet</td>
      @endif   
      <td>{{ $order-> name }}</td>
      <td>{{ $order-> phone }}</td>
      <td><!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $order-> id }}">
  Details
</button>

<!-- Modal -->
<div class="modal fade" id="{{ $order-> id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                @foreach($packages as $package)
                @if( $order->id === $package->order_id) 
                    <tr>
                    <th>Length</th>
                    <td>{{ $package -> length}}</td>
                    <tr>
                    <th>Width</th>
                    <td>{{ $package -> width}}</td>
                    <tr>
                    <th>Height</th>
                    <td>{{ $package -> height}}</td>
                    <tr>
                    <th>Quantity</th>
                    <td>{{ $package -> quantity}}</td>
                    <tr>
                    <th>Weight</th>
                    <td>{{ $package -> Weight}} {{ $package -> unit}}</td>
                    <tr>
                    <th>Value</th>
                    <td>{{ $package -> value}}</td>
                    <tr>
                    <th>Pickup location</th>
                    <td>{{ $package -> pickup_location}}</td>
                    <tr>
                    <th>Drop off location</th>
                    <td>{{ $package -> drop_off_location}}</td>
                    <tr>
                    <th>Time to deliver</th>
                    <td>{{ $package -> time_to_deliver}}</td>
                    </tr>
                  @endif   
                @endforeach
                </tbody>
                </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div></td>
    </tr>
   @endforeach
  </tbody>
</table>

{{ $orders->onEachSide(1)->links() }}

</div>

@endsection
