@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Sparepart Cost</h1>
        </div>
    </div><!-- /.row -->
    <div class="row">
    <div class="col-md-12">
        <hr>
    </div>
    </div>

    <form action="/loadspcost" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}
        <div class="row mb-2">
            <p class="pb-0 m-0">Inputkan periode PC Cost dengan format YYMM.</p>
        </div>
        <div class="row mb-0">
            <label for="t_cust" class="col-form-label col-md-1 text-md-left">Period</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="t_period" name="t_period" required autocomplete="off" maxlength="4"> 
            </div>
    
            <div class="col-md-2 col-sm-12 mb-2 input-group">
                <input type="submit" class="btn btn-block btn-primary" id="btnload" value="Load Data" />
            </div>
            <div class="col-md-2">
                
                <button type="button" class="btn btn-info" id="s_btnloading" style="display:none;">
                    <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
                </button>
            </div>
        </div>

    </form>

</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Bagian Searching -->
<form action="/spcost" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Spart Part Code</label>
                <div class="col-md-4 mb-2 input-group">
                  <select id="s_code" class="form-control" style="color:black" name="s_code">
                     <option value="">--Select Sparepart--</option>
                     @foreach($datasp as $ds)
                       <option value="{{$ds->spm_code}}" {{$ds->spm_code === $scode ? "selected" : ""}}>{{$ds->spm_code}} -- {{$ds->spm_desc}}</option>
                     @endforeach
                   </select>
                </div>
                <label for="s_costset" class="col-md-2 col-sm-2 col-form-label text-md-right">Cost Set</label>
                <div class="col-md-4 mb-2 input-group">
                  <select id="s_costset" class="form-control" style="color:black" name="s_costset">
                     <option value="">--Select Cost Set--</option>
                     @foreach($datacostset as $dc)
                       <option value="{{$dc->spc_costset}}" {{$dc->spc_costset === $scostset ? "selected" : ""}}>{{$dc->spc_costset}}</option>
                     @endforeach
                   </select>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-12 mb-2 input-group">
                  <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                </div>
                <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
                  <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<div class="col-md-12">
    <hr>
</div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="15%">Code</th>
                <th width="30%">Description</th>
                <th width="5%">UM</th>
                <th width="20%">Cost Set</th>
                <th width="20%">Price</th>
                <!--
                <th width="10%">Action</th>
                -->
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-spcost')
        </tbody>
    </table>
</div>

<div class="modal" id="loadingtable" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered d-flex align-items-center justify-content-center" role="document">
      <div class="spinner-grow text-danger">LOADING</div>
      <div class="spinner-grow text-warning" style="animation-delay:0.2s;"></div>
      <div class="spinner-grow text-success" style="animation-delay:0.45s;"></div>
      <div class="spinner-grow text-info"style="animation-delay:0.65s;"></div>
      <div class="spinner-grow text-primary"style="animation-delay:0.85s;"></div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    $(document).on('click', '#btnrefresh', function() {

        document.getElementById('s_code').value = '';
        document.getElementById('s_costset').value = '';

        $("#s_code").select2({
            width: '100%',
            theme: 'bootstrap4',

        });

        $("#s_costset").select2({
            width: '100%',
            theme: 'bootstrap4',

        });

    });


    $("#s_code").select2({
      width: '100%',
      theme: 'bootstrap4',

      });

      $("#s_costset").select2({
         width: '100%',
         theme: 'bootstrap4',

      });

    $("#submit").submit(function(e) {
        $('#loadingtable').modal('show');
    });
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script>
    // $('#t_groupidtype').select2({
    //     width: '100%'
    // });
    // $('#te_groupidtype').select2({
    //     width: '100%'
    // });
</script>
@endsection