@extends('layouts.app')
@section('content')
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="../../index2.html"><b>Car</b>Go</a>
    </div>
    <!-- User name -->
    <!-- <div class="lockscreen-name text-center">{{ Auth::user()->name }}</div> -->

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <!-- <div class="lockscreen-image">
            <img src="/bower_components/admin-lte/dist/img/user1-128x128.jpg" alt="User Image">
        </div> -->
        <!-- /.lockscreen-image -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        <h3>Sorry {{ Auth::user()->name }} !</h3>
    </div>
    <div class="text-center">
        <h5>This Account is no longer active </h5>
        <h6>Please contact your dashboard adminstrator</h6>
    </div>
    <div class="lockscreen-footer text-center">
        Copyright &copy; 2014-2016 <b><a href="https://adminlte.io" class="text-black"></a></b><br>
        All rights reserved
    </div>
</div>

@endsection
