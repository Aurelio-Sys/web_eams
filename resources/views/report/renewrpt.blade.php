@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Renewal Report</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<!--FORM Search Disini -->
<form action="/renewrpt" method="GET">
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
            <input type="hidden" name="bulan" id="bulan" value="{{$bulan}}">
            <input type="hidden" name="stat" value="">
            <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
                <option value="">--Select Asset--</option>
                @foreach($datasearchasset as $assetsearch)
                <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
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

<!-- Bagian Searching -->
<div class="col-md-12"><hr></div>

<div class="col-md-12" style="color:black; font-size:2rem; text-align:end">
    <a href="/renewrpt?bulan={{$bulan}}&stat=mundur&s_asset={{$sasset}}&s_loc={{$sloc}}" id="mundur"><i class="fas fa-angle-left"></i></a>
    &ensp;&ensp;<span>{{$bulan}}</span>&ensp;&ensp;
    <input type='hidden' name='bulan' id='bulan' value='{{ $bulan }}'>
    <a href="/renewrpt?bulan={{$bulan}}&stat=maju&s_asset={{$sasset}}&s_loc={{$sloc}}" id="maju" ><i class="fas fa-angle-right"></i></a>
</div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Asset</th>
                <th width="15%">Description</th>
                <th width="15%">Location</th>
                <th width="5%" style="text-align: center">Jan</th>  
                <th width="5%" style="text-align: center">Feb</th>  
                <th width="5%" style="text-align: center">Mar</th>  
                <th width="5%" style="text-align: center">Apr</th>  
                <th width="5%" style="text-align: center">May</th>  
                <th width="5%" style="text-align: center">Jun</th>  
                <th width="5%" style="text-align: center">Jul</th>  
                <th width="5%" style="text-align: center">Aug</th>  
                <th width="5%" style="text-align: center">Sep</th>  
                <th width="5%" style="text-align: center">Oct</th>  
                <th width="5%" style="text-align: center">Nov</th>  
                <th width="5%" style="text-align: center">Dec</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('report.table-renewrpt')
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
          Asset : <span id="v_code"></span> --  <span id="v_codedesc"></span>
          {{--  Location : <span id="v_code"></span> --  <span id="v_codedesc"></span>  --}}
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
                <th width="20%">Wo Date</th>
                <th width="20%">WO Status</th>  
                <th width="40%">Engineer</th>  
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
       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       $(document).on('click', '#btnrefresh', function() {
            document.getElementById('s_asset').value  = '';
            document.getElementById('s_loc').value  = '';
            document.getElementById('bulan').value  = null;
        }); 

        $("#s_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
        });
        $("#s_asset").select2({
            width : '100%',
            theme : 'bootstrap4',
        });
        $("#s_eng").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        $(document).on('click', '.view', function() {
          
            $('#viewModal').modal('show');
  
            var code = $(this).data('code');
            var codedesc = $(this).data('codedesc');
            var sch = $(this).data('sch'); 
  
            document.getElementById('v_code').innerHTML = code;
            document.getElementById('v_codedesc').innerHTML = codedesc;
  
            $.ajax({
              url:"assetyeardetail?code="+code+"&sch="+sch,
              success: function(data) {
                console.log(data);
                //alert(data);
                $('#detailapp').html('').append(data);
              }
            })
          });

      $(document).on('click', '#btnexcel', function() {
         var sasset = $('#s_asset').val();
         var loc = $('#s_loc').val();
         
         window.open("/excelrenewrpt?dexcel=excel&s_asset=" + sasset + "&s_loc=" + loc, '_blank');
      });
    
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection