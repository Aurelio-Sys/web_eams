@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Generate Work Order</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="container">
    <form class="form-group" id="generate_submit" method="post" action="{{route('indexWoGenerate')}}">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <div class="form-group row">
        <div class="col-md-2">
            <label class="col-form-label text-md-right">Date From</label>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" value="{{\Carbon\Carbon::now()->toDateString()}}" readonly />
        </div>
        <div class="col-md-2">
            <label class="col-form-label">Date To</label>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control datepicker" name="todate" id="todate" autocomplete="off" />
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-info" id="btngenerate" value="Generate WO PM" />
            <button type="button" class="btn btn-info" id="s_btnloading" style="display:none;width: 100%;">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var date = new Date();
    $('.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        startDate: date,
        minDate: 0,
    });

    $('#generate_submit').submit(function(event) {
        // alert('aaa');
        document.getElementById('btngenerate').style.display = 'none';
        document.getElementById('s_btnloading').style.display = '';
    });

</script>
@endsection