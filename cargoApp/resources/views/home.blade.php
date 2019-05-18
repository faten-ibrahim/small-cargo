@if(Auth::user()->status=='active')
@extends('layouts.base')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>

                    <h5> You are logged in to control panel !</h5>


                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
