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
  <div class="container-fluid mb-2">
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
                  <label for="s_sp" class="col-md-2 col-form-label text-md-right">{{ __('Sparepart') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                      <select id="s_sp" class="form-control" style="color:black" name="s_sp" autofocus autocomplete="off">
                        <option value="">--Select--</option>
                        @foreach($datasp as $ds)
                        <option value="{{$ds->spm_code}}" {{$ds->spm_code === $ssp ? 'selected' : ''}}>{{$ds->spm_code}} -- {{$ds->spm_desc}}</option>
                        @endforeach
                      </select>
                  </div>
                  <label for="s_nomorrs" class="col-md-2 col-form-label text-md-right">{{ __('Transactions Number') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                      <input id="s_nomorrs" type="text" class="form-control" name="s_nomorrs" value="{{$snomorrs}}" autofocus autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <label for="s_reqby" class="col-md-2 col-form-label text-md-right">{{ __('Transactions By') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                      <select id="s_reqby" class="form-control" style="color:black" name="s_reqby" autofocus autocomplete="off">
                          <option value="">--Select--</option>
                          @foreach($requestby as $reqby)
                          <option value="{{$reqby->eng_code}}" {{$reqby->eng_code === $sreqby ? 'selected' : ''}}>{{$reqby->eng_code}} -- {{$reqby->eng_desc}}</option>
                          @endforeach
                      </select>
                  </div>
                  <label for="s_dept" class="col-md-2 col-form-label text-md-right">{{ __('Department') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                    <select id="s_dept" class="form-control" style="color:black" name="s_dept" autofocus autocomplete="off">
                      <option value="">--Select--</option>
                      @foreach($datadept as $dd)
                      <option value="{{$dd->dept_code}}" {{$dd->dept_code === $sdept ? 'selected' : ''}}>{{$dd->dept_code}} -- {{$dd->dept_desc}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-1"></div>
                  <label for="s_datefrom" class="col-md-2 col-form-label text-md-right">{{ __('Date From') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                      <input id="s_datefrom" type="date" class="form-control" name="s_datefrom" value="{{$sdatefrom}}" autofocus autocomplete="off">
                  </div>
                  <label for="s_daeto" class="col-md-2 col-form-label text-md-right">{{ __('Date To') }}</label>
                  <div class="col-md-3 col-sm-12 mb-2 input-group">
                      <input id="s_dateto" type="date" class="form-control" name="s_dateto" value="{{$sdateto}}" autofocus autocomplete="off">
                  </div>
                  <div class="col-md-1"></div>
                  <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
                  <div class="col-md-2 col-sm-12 mb-2 input-group">
                      <button class="btn btn-block btn-primary" id="btnsearch" style="float:right" />Search</button>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-2 input-group">
                      <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                  </div>
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
        <th>Trans By</th>
        <th>Name</th>
        <th>Department</th>
        <th>Dept Name</th>
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
  $('#s_reqby').select2({
    width: '100%',
    theme: 'bootstrap4',
  });

  $('#s_sp').select2({
    width: '100%',
    theme: 'bootstrap4',
  });

  $('#s_dept').select2({
    width: '100%',
    theme: 'bootstrap4',
  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function resetSearch() {
    $('#s_sp').val('');
    $('#s_nomorrs').val('');
    $('#s_reqby').val('');
    $('#s_dept').val('');
    $('#s_datefrom').val('');
    $('#s_dateto').val('');
  }

  $(document).on('click', '#btnrefresh', function() {
    {{--  document.getElementById('s_per1').required = false;
    document.getElementById('s_per2').required = false;  --}}

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