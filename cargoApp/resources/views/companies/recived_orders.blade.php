@extends('layouts.base')
@section('content')
<div class="container" style="width:100%;">
@include('flash-message')
<h2>{{$company->comp_name}} orders</h2>

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

      @foreach($drivers as $driver)
      @if( $driver->order_id === $order->id) 
      <td>{{ $driver -> name }}</td>
      <td>{{ $driver -> phone }}</td>
      @else
      <td>No driver accept order yet</td>
      <td>No driver accept order yet</td>
      @endif  
      @endforeach

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
                    <tr>
                    <th>Length</th>
                    <td>{{ $order -> length}}</td>
                    <tr>
                    <th>Width</th>
                    <td>{{ $order -> width}}</td>
                    <tr>
                    <th>Height</th>
                    <td>{{ $order -> height}}</td>
                    <tr>
                    <th>Quantity</th>
                    <td>{{ $order -> quantity}}</td>
                    <tr>
                    <th>Weight</th>
                    <td>{{ $order -> Weight}} {{ $order -> unit}}</td>
                    <tr>
                    <th>Value</th>
                    <td>{{ $order -> value}}</td>
                    <tr>
                    <th>Pickup location</th>
                    <td>{{ $order -> pickup_location}}</td>
                    <tr>
                    <th>Drop off location</th>
                    <td>{{ $order -> drop_off_location}}</td>
                    <tr>
                    <th>Time to deliver</th>
                    <td>{{ $order -> time_to_deliver}}</td>
                    </tr>
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
