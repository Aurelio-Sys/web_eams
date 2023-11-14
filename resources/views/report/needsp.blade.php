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
            {{--  Lihat sparepart di WO di WO detail saja
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
            </div>--}}
            <label for="s_site" class="col-form-label col-md-1 text-md-left">Site</label>
            <div class="col-md-4">
                <select class="form-control" id="s_site" name="s_site" required>
                        <option></option>
                    @foreach ( $datasite as $site )
                        <option value="{{$site->site_code}}">{{$site->site_code}} -- {{$site->site_desc}}</option>
                    @endforeach
                </select>
            </div>
            <label for="s_eng" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
            <label for="s_sp" class="col-md-1 col-form-label text-md-left">{{ __('Sparepart') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <select id="s_sp" class="form-control" style="color:black" name="s_sp" autofocus autocomplete="off">
                <option value="">--Select Sparepart--</option>
                @foreach($datasp as $ds)
                  <option value="{{$ds->spm_code}}" {{$ds->spm_code === $ssp ? "selected" : ""}}>{{$ds->spm_code}} -- {{$ds->spm_desc}}</option>
                @endforeach
              </select>
            </div>
            <label for="s_eng" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
            <label for="s_per1" class="col-md-1 col-form-label text-md-left">{{ __('WO Date') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <input type="date" name="s_per1" id="s_per1" class="form-control" value="{{$sper1}}">
            </div>
            <label for="s_eng" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
            <label for="s_per2" class="col-md-1 col-form-label text-md-left">{{ __('s/d') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <input type="date" name="s_per2" id="s_per2" class="form-control" value="{{$sper2}}">
            </div>
            <div class="col-md-2 col-sm-12 mb-2 input-group">
              <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
            </div>
            <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
              <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
            </div>
            
          
            
            <label for="s_eng" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
              <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
            </div>
          </div>
        </div>
    </div>
</form>

<div class="col-md-12"><hr></div>

<!--FORM Generate SO -->
<form action="{{route('generateSO')}}" method="post" id="genso">
  {{ method_field('post') }}
  {{ csrf_field() }}
  <div class="row mb-4">
      <label for="t_cust" class="col-form-label col-md-1 text-md-left">Customer</label>
      <div class="col-md-3">
          <input type="text" class="form-control" id="t_cust" name="t_cust" value="eams" required> 
          <input type="hidden" class="form-control" id="site_genso" name="site_genso"> 
      </div>

      <input type="hidden" id="hs_per1" name="hs_per1" >
      <input type="hidden" id="hs_per2" name="hs_per2" >
      <input type="hidden" id="hs_sp" name="hs_sp">
      <div class="col-md-2 col-sm-12 mb-2 input-group">
        <button type="submit" id="btngenso" class="btn btn-primary btn-block" style="float:right">Generate SO</button>
      </div>
      <div class="col-md-2">
        
          <button type="button" class="btn btn-info" id="btnloading" style="display:none;">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
      </div>
  </div>
</form>

<!-- Bagian Searching -->
<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
              <th width="10%">Site</th>
              <th width="25%">Sparepart</th>
              <th width="35%">Desc</th>  
              <th width="10%">Sch Date</th>
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
  <div class="modal-dialog modal-xl" role="document">
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
                <th width="10%">Wo Date</th>
                <th width="30%">Asset</th>
                <th width="10%">WO Status</th>  
                <th width="10%">Qty Required</th>  
                <th width="10%">Qty Transfered</th>  
                <th width="10%">Qty Issued</th>  
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

            /* Kirim data search ke form Generasl SO */
            var urlParams = new URLSearchParams(window.location.search);


            var s_sp = urlParams.get('s_sp');
            var s_site = urlParams.get('s_site');
            var s_per1 = urlParams.get('s_per1');
            var s_per2 = urlParams.get('s_per2');
            
            document.getElementById('s_site').required = false;

            document.getElementById('hs_sp').value = s_sp;
            document.getElementById('site_genso').value =s_site;
            document.getElementById('hs_per1').value =s_per1;
            document.getElementById('hs_per2').value =s_per2;
        });

      

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       $('#s_site').select2({
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

        /* Menampung variabel ke Form Generate */
        $(document).on('change', '#s_site', function() {
          var site = document.getElementById('s_site').value;

          document.getElementById('site_genso').value = site;
        });

    
        $(document).on('change', '#s_per1', function() {
          var per1 = document.getElementById('s_per1').value;

          document.getElementById('hs_per1').value = per1;
        });
        $(document).on('change', '#s_per2', function() {
          var per2 = document.getElementById('s_per2').value;

          document.getElementById('hs_per2').value = per2;
        });

        $(document).on('click', '#btnrefresh', function() {
            document.getElementById('s_per1').required = false;
            document.getElementById('s_per2').required = false;
            document.getElementById('s_site').required = false;
        
            resetSearch();
        });

        $(document).on('click', '#btngenso', function() {
          document.getElementById('s_site').required = true;
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