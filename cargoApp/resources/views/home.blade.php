@if(Auth::user()->status=='active')
@extends('layouts.base')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">CarGo</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>

                    <h5> Welcome to Admin Control Panal </h5>

                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
