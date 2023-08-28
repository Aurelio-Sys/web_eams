@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Generate PM Planning for Meter</h1>
            <br>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="container">
    <form class="form-group" id="generate_submit" method="post" action="{{route('pmmetergen')}}">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <div class="form-group row">
        <label for="t_code" class="col-md-1 col-form-label text-md-right">Asset</label>
        <div class="col-md-6">
            <select class="form-control" name="asset" id="asset">
                <option value="">-- Select Data --</option>
                @foreach ($dataasset as $da)
                    <option value={{$da->asset_code}}>{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
         <input type="submit" class="btn btn-info" id="btngenerate" value="Generate PM"/>
         <button type="button" class="btn btn-info" id="s_btnloading" style="display:none;width: 100%;">
             <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
         </button>
     </div>
    </div>
    {{--  <div class="form-group row">
        <div class="col-md-2">
            <label class="col-form-label text-md-right">Date From</label>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" value="{{\Carbon\Carbon::now()->toDateString()}}" readonly />
        </div>
        <div class="col-md-1">
            <label class="col-form-label text-md-right">Date To</label>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control datepicker" name="todate" id="todate" autocomplete="off" required/>
        </div>
       
    </div>  --}}
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

    $("#asset").select2({
        width : '100%',
        theme : 'bootstrap4',
     });

</script>
@endsection