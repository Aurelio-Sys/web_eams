@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Generate Sparepart Demand</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="{{route('generateSO')}}" method="post" id="genso">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <div class="row mb-4">
        <label for="site_genso" class="col-form-label col-md-1 text-md-left">Site</label>
        <div class="col-md-3">
            <select class="form-control" id="site_genso" name="site_genso" required>
                    <option></option>
                @foreach ( $datasite as $site )
                    <option value="{{$site->site_code}}">{{$site->site_code}} -- {{$site->site_desc}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" id="btngenso" class="btn btn-primary">Generate SO</button>
            <button type="button" class="btn btn-info" id="btnloading" style="display:none;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </div>
</form>
<!--FORM Search Disini -->
<form action="/needsp" method="GET">
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
            <label for="s_nomorwo" class="col-md-2 col-form-label text-md-right">{{ __('Work Order Number') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <input id="s_nomorwo" type="text" class="form-control" name="s_nomorwo" value="{{$swo}}" autofocus autocomplete="off">
            </div>
            <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
                <option value="">--Select Asset--</option>
                @foreach($dataasset as $assetsearch)
                  <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
                @endforeach
              </select>
            </div>
            <label for="s_sp" class="col-md-2 col-form-label text-md-right">{{ __('Sparepart') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <select id="s_sp" class="form-control" style="color:black" name="s_sp" autofocus autocomplete="off">
                <option value="">--Select Sparepart--</option>
                @foreach($datasp as $ds)
                  <option value="{{$ds->spm_code}}" {{$ds->spm_code === $ssp ? "selected" : ""}}>{{$ds->spm_code}} -- {{$ds->spm_desc}}</option>
                @endforeach
              </select>
            </div>
            <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
            </div>
            <label for="s_per1" class="col-md-2 col-form-label text-md-right">{{ __('WO Date') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <input type="date" name="s_per1" id="s_per1" class="form-control" value="{{$sper1}}">
            </div>
            <label for="s_per2" class="col-md-2 col-form-label text-md-right">{{ __('s/d') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <input type="date" name="s_per2" id="s_per2" class="form-control" value="{{$sper2}}">
            </div>
            <div class="col-md-2 col-sm-12 mb-2 input-group">
              <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
            </div>
            <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
              <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
            </div>
          </div>
        </div>
    </div>
</form>

<!-- Bagian Searching -->
<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
              <th width="15%">Sch Date</th>
              <th width="25%">Sparepart</th>
              <th width="40%">Desc</th>  
              <th width="10%">Qty Req</th>  
              <th width="10%">Detail</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('report.table-needsp')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="dept_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>


<!-- Modal View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-left" id="exampleModalLabel">
          Detail Work Order
          <br>
          Sparepart : <span id="v_code"></span> --  <span id="v_codedesc"></span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
              <tr>
                <th width="20%">Wo Number</th>
                <th width="15%">Wo Date</th>
                <th width="15%">WO Status</th>  
                <th width="15%">Qty Required</th>  
                <th width="20%">Qty Transfered</th>  
                <th width="15%">Qty Issued</th>  
              </tr>
          </thead>
          <tbody id='detailapp'>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#genso').submit(function(event) {
                // alert('aa');
                document.getElementById('btngenso').style.display = 'none';
                document.getElementById('btnloading').style.display = '';
            });
        });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       $('#site_genso').select2({
            width:'100%',
            placeholder: 'Select Site',
            allowClear: true,
       });

       function resetSearch() {
            $('#s_nomorwo').val('');
            $('#s_asset').val('');
            $('#s_per1').val('');
            $('#s_per2').val('');
            $('#s_sp').val('');
        }
        
        $('#s_asset').select2({
            width: '100%',
            theme: 'bootstrap4',
        });
        $('#s_sp').select2({
            width: '100%',
            theme: 'bootstrap4',
        });

        $(document).on('click', '#btnrefresh', function() {
            document.getElementById('s_per1').required = false;
            document.getElementById('s_per2').required = false;
        
            resetSearch();
        });

        $(document).on('click', '.view', function() {
          
          $('#viewModal').modal('show');

          var code = $(this).data('sp');
          var codedesc = $(this).data('spdesc');
          var sch = $(this).data('sch'); 

          document.getElementById('v_code').innerHTML = code;
          document.getElementById('v_codedesc').innerHTML = codedesc;

          $.ajax({
            url:"needspdetail?code="+code+"&sch="+sch,
            success: function(data) {
              console.log(data);
              //alert(data);
              $('#detailapp').html('').append(data);
            }
          })
        });
      
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection