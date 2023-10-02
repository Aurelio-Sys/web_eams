@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-4">
      <h1 class="m-0 text-dark">Spare Part Stock Report</h1>
    </div>
  </div><!-- /.row -->
  <div class="col-md-12">
    <hr>
  </div>
</div><!-- /.container-fluid -->
@endsection
@section('content')

<!-- Bagian Searching -->
<form action="/spstockbrowse" method="GET">
  <div class="row mb-2">

    <div class="col-md-3">
      <input type="text" class="form-control" placeholder="Cari data..." aria-label="Cari data..." id="searchInput" name="s_search">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-block btn-primary" id="btnsearch" style="float:right" />Search</button>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary" id='btnrefresh'><i class="fas fa-sync-alt"></i></button>
    </div>
  </div>
</form>
<form action="/loadspstock" method="post" id="submit">
  <div class="row mb-2">
    <div class="col-md-4">

      {{ method_field('post') }}
      {{ csrf_field() }}

      <input type="submit" class="btn btn-primary" id="btnload" value="Load Data" />
      <button type="button" class="btn btn-info" id="s_btnloading" style="display:none;">
        <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
      </button>
    </div>
  </div>
</form>


<div class="table-responsive col-12">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th width="25%">Sparepart</th>
        <th width="10%">Site</th>
        <th width="30%">Location</th>
        <th width="10%">Lot</th>
        <th width="15%">Quantity in QAD</th>
      </tr>
    </thead>
    <tbody>
      <!-- untuk isi table -->
      @include('report.table-spstock')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="dept_code" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>


@endsection

@section('scripts')
<script>
  $("#submit").submit(function(e) {
    document.getElementById('btnload').style.display = 'none';
    document.getElementById('s_btnloading').style.display = '';
  });

  function resetSearch() {
    $('#s_search').val('');

  }

  $(document).on('click', '#btnrefresh', function() {
    resetSearch();
  });
</script>

@endsection