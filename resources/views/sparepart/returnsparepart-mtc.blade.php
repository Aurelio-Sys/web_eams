@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Sparepart</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<style type="text/css">
    .bootstrap-select .dropdown-menu {
        width: 400px !important;
        min-width: 400px !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    /* body {
        background-image: url('images/site-down.jpg');
        background-repeat: no-repeat;
        background-size: cover;
    } */
</style>

<div class="container">
<img class="card-img" style="border-radius: 0px;" src="{{asset('images/site-down.jpg')}}" width="100" alt="Card image cap">
</div>

@endsection