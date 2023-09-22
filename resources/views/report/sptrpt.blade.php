@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9">
      <h1 class="m-0 text-dark">Sparepart Report</h1>
    </div><!-- /.col -->
    <div class="col-sm-3">

    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
  div #munculgambar .gambar {
    margin: 5px;
    border: 2px solid grey;
    border-radius: 5px;
  }

  div #munculgambar .gambar:hover {
    /* margin: 5px; */
    border: 2px solid red;
    border-radius: 5px;
  }
</style>

<form action="/sptrpt" method="GET">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-block bg-black rounded-0" data-toggle="collapse" data-target="#collapseExample">Click Here To Search</button>
    </div>  
  </div>
  <!-- Element div yang akan collapse atau expand -->
  <div class="collapse" id="collapseExample">
      <!-- Isi element div dengan konten yang ingin ditampilkan saat collapse diaktifkan -->
      <div class="card card-body bg-black rounded-0">
        <div class="col-12 form-group row">
          <!--FORM Search Disini-->
          <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
              <option value="">--Select Asset--</option>
              @foreach($asset1 as $assetsearch)
                <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_type" class="col-md-2 col-form-label text-md-right" style="display: none;">{{ __('Type') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group" style="display: none;">
            <select id="s_type" class="form-control" style="color:black" name="s_type" autofocus autocomplete="off">
              <option value="">--</option>
              <option value="CM" {{$stype === "CM" ? "selected" : ""}}>CM</option>
              <option value="PM" {{$stype === "PM" ? "selected" : ""}}>PM</option>
            </select>
          </div>
          <label for="s_site" class="col-md-2 col-form-label text-md-right">{{ __('Site') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_site" class="form-control" style="color:black" name="s_site" autofocus autocomplete="off">
              <option value="">--Select Site--</option>
              @foreach($datasite as $ds)
                <option value="{{$ds->assite_code}}" {{$ds->assite_code === $sloc ? "selected" : ""}}>{{$ds->assite_code}} -- {{$ds->assite_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_loc" class="col-md-2 col-form-label text-md-right">{{ __('Location') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_loc" class="form-control" style="color:black" name="s_loc" autofocus autocomplete="off">
              <option value="">--Select Location--</option>
              @foreach($dataloc as $dl)
                <option value="{{$dl->asloc_code}}" {{$dl->asloc_code === $sloc ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_per1" class="col-md-6 col-form-label text-md-right">{{ __('') }}</label>
          <label for="s_per1" class="col-md-2 col-form-label text-md-right">{{ __('Period') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <input type="date" name="s_per1" id="s_per1" class="form-control" value="{{$sper1}}">
          </div>
          <label for="s_per2" class="col-md-2 col-form-label text-md-right">{{ __('s/d') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <input type="date" name="s_per2" id="s_per2" class="form-control" value="{{$sper2}}">
          </div>
          <label for="s_per1" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
          </div>
          <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
          </div>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnexcel" value="Export to Excel" style="float:right" />
          </div>
        </div>
      </div>
  </div>
</form>

<input type="hidden" id="tmpwo" value="" />
<input type="hidden" id="tmpasset" value="" />
<input type="hidden" id="tmpstatus" value="" />
<input type="hidden" id="tmppriority" value="" />
<input type="hidden" id="tmpengineer" value="" />
<input type="hidden" id="tmpcreator" value="" />

<div class="table-responsive col-12 mt-0 pt-0 align-top" style="overflow-x: auto; display: block;white-space: nowrap;">
  <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
    <thead>
      <tr style="text-align: center;">
        <th>Sparepart</th>
        <th>Desc</th>
        <th>Location From</th>
        <th>Location Desc From</th>
        <th>Lot From</th>
        <th>Location To</th>
        <th>Location Desc To</th>
        <th>Date</th>
        <th>Type</th>
        <th>Trans No.</th>
        <th>Qty</th>
      </tr>
    </thead>
    <tbody>
      @include('report.table-sptrpt')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>
<input type="hidden" id="counterfail">
<input type="hidden" id="counter">

<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $('#s_asset').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
  $('#s_loc').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
  $('#s_site').select2({
   width: '100%',
   theme: 'bootstrap4',
 });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function resetSearch() {
    $('#s_asset').val('');
    $('#s_per1').val('');
    $('#s_per2').val('');
    $('#s_loc').val('');
    $('#s_site').val('');
    $('#s_type').val('');
  }

  $(document).on('click', '#btnrefresh', function() {
    document.getElementById('s_per1').required = false;
    document.getElementById('s_per2').required = false;

    resetSearch();
  });

  $(document).on('click', '#btnexcel', function() {
    var sasset = $('#s_asset').val();
    var per1 = $('#s_per1').val();
    var per2 = $('#s_per2').val();
    var loc = $('#s_loc').val();
    var site = $('#s_site').val();
    
    window.open("/exceldownrpt?dexcel=excel&s_asset=" + sasset + "&s_per1=" + per1 + "&s_per2=" + per2 +
        "&s_loc=" + loc + "&s_site=" + site , '_blank');
  });

  $(document).on('change', '#s_per1', function() {
    var per = $('#s_per1').val();

    document.getElementById('s_per2').required = true;
    document.getElementById('s_per2').min = per1;
  });

  $(document).on('change', '#s_per2', function() {
    var per = $('#s_per2').val();

    document.getElementById('s_per1').required = true;
    document.getElementById('s_per1').max = per;
  });

</script>
@endsection