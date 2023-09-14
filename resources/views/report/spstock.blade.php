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
<div class="row">
  <div class="col-md-4">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Cari data..." aria-label="Cari data..." onkeyup="searchFunction()" id="searchInput">
    </div>
  </div>
</div>

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
  function searchFunction() {
    var input, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      if (i == 0) {
        tr[i].style.display = "";
        continue;
      }
      td = tr[i].getElementsByTagName("td");
      var flag = false;
      for (j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(input.value.toUpperCase()) > -1) {
          flag = true;
          break;
        }
      }
      if (flag) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
</script>

@endsection