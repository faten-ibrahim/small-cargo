@extends('layouts.app')
@section('content')
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="/"><b>Car</b>Go</a>
        <br>
        <div class="lockscreen-image">
            <img src="/bower_components/admin-lte/dist/img/emoji.png.jpeg" alt="emoji Image">
        </div>
    </div>
    <br>
    <br>

    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        <h3 style="color: black;">Sorry !</h3>
    </div>
    <div class="text-center">
        <h4>This Account is no longer active </h4>
        <h5>Please contact your dashboard adminstrator</h5>
    </div>
    <div class="text-center">
        <a class="btn btn-link" href="/login">Back</a>

    </div>
    <div class="lockscreen-footer text-center">
        Copyright &copy; 2018-2019 <b><a href="https://adminlte.io" class="text-black"></a></b><br>
        All rights reserved
    </div>
</div>

@endsection
