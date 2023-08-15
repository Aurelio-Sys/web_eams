@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Cost Report</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<!--FORM Search Disini -->
<form action="/rptcost" method="GET">
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
            <input type="hidden" name="bulan" value="{{$bulan}}">
            <input type="hidden" name="stat" value="">
            <label for="s_type" class="col-md-2 col-form-label text-md-right">{{ __('Type') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
                <select id="s_type" class="form-control" style="color:black" name="s_type" autofocus autocomplete="off">
                <option value="">--</option>
                <option value="CM" {{$stype === "CM" ? "selected" : ""}}>CM (Correnctive Maintenance)</option>
                <option value="PM" {{$stype === "PM" ? "selected" : ""}}>PM (Preventive Maintenance)</option>
                </select>
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
            <label for="s_loc" class="col-md-2 col-form-label text-md-right">{{ __('Location') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_loc" class="form-control" style="color:black" name="s_loc" autofocus autocomplete="off">
                <option value="">--Select Location--</option>
                @foreach($dataloc as $dl)
                <option value="{{$dl->asloc_code}}" {{$dl->asloc_code === $sloc ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
                @endforeach
            </select>
            </div>
            <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('Engineer') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_eng" class="form-control" style="color:black" name="s_eng" autofocus autocomplete="off">
                <option value="">--Select Engineer--</option>
                @foreach($dataeng as $de)
                <option value="{{$de->eng_code}}" {{$de->eng_code === $seng ? "selected" : ""}}>{{$de->eng_code}} -- {{$de->eng_desc}}</option>
                @endforeach
            </select>
            </div>
            <label for="s_child" class="col-md-2 col-form-label text-md-right">{{ __('Include Child?') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
                <input type="checkbox" id="s_child" name="s_child" value="Yes" {{ $schild ? 'checked' : '' }}>
            </div>
            <label for="s_eng" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
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
    <a href="/rptcost?bulan={{$bulan}}&stat=mundur&s_asset={{$sasset}}&s_loc={{$sloc}}&s_type={{$stype}}&s_eng={{$seng}}" id="mundur"><i class="fas fa-angle-left"></i></a>
    &ensp;&ensp;<span>{{$bulan}}</span>&ensp;&ensp;
    <input type='hidden' name='bulan' id='bulan' value='{{ $bulan }}'>
    <a href="/rptcost?bulan={{$bulan}}&stat=maju&s_asset={{$sasset}}&s_loc={{$sloc}}&s_type={{$stype}}&s_eng={{$seng}}" id="maju" ><i class="fas fa-angle-right"></i></a>
</div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Asset</th>
                <th width="20%">Description</th>
                <th width="10%">Location</th>   
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
            @include('report.table-rptcost')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="dept_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal View -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center" id="exampleModalLabel">Detail Cost per Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
    	    </div>
         	<div class="panel-body">
              	<div class="modal-body">
                	<div class="form-group row col-md-12">
                        <label for="e_code" class="col-md-1 col-form-label text-md-left">{{ __('Asset') }}</label>
                        <div class="col-md-4">
                            <input id="e_code" type="text" class="form-control" name="e_code" readonly="true">
                        </div>
                        <label for="e_desc" class="col-md-1 col-form-label text-md-left">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input id="e_desc" type="text" class="form-control" name="e_desc" readonly="true">
                        </div>
                    </div>
                    <div class="form-group row col-md-12">
                        <label for="e_locdesc" class="col-md-1 col-form-label text-md-left">{{ __('Location') }}</label>
                        <div class="col-md-11">
                            <input id="e_locdesc" type="text" class="form-control" name="e_locdesc" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                            <thead>
                              <tr id='full'>
                                <th>WO Number</th>
                                <th>Note</th>
                                <th>Engineer</th>
                                <th>WO Create</th>
                                <th>WO Type</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Detail</th>
                              </tr>
                            </thead>
                            <tbody id='detailapp'>
                            </tbody>
                        </table>
                    </div> 
                    <div class="chart-pie pt-4 pb-2 col-12">
                       <canvas id="myexpitm" width="568" height="400"></canvas>
                  </div>      
              	</div>	              									
            </div>    

          	<div class="modal-footer">
    	        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
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

       $(document).on('click', '#editdata', function(e){
        $('#editModal').modal('show');

        var code         = $(this).data('code');
        var desc         = $(this).data('desc');
        var locdesc      = $(this).data('locdesc');
        var bln      = $(this).data('bln');
        var thn      = $(this).data('thn');
        var type      = $(this).data('type');
        var eng      = $(this).data('eng');
        var child      = $(this).data('child');
        
        document.getElementById('e_code').value         = code;
        document.getElementById('e_desc').value         = desc;
        document.getElementById('e_locdesc').value      = locdesc;

        $.ajax({
            url:"rptcostview?code="+code+"&bln="+bln+"&thn="+thn+"&type="+type+"&eng="+eng+"&child="+child,
            success: function(data) {
            // console.log(data);
            //alert(data);
            $('#detailapp').html('').append(data);
          }
        })
        
    });

        $(document).ready(function() {
            var cur_url = window.location.href;
    
            let paramString = cur_url.split('?')[1];
            let queryString = new URLSearchParams(paramString);
    
            {{--  let asset = queryString.get('s_asset');
            let priority = queryString.get('s_priority');
    
            $('#s_asset').val(asset).trigger('change');
            $('#s_priority').val(priority).trigger('change');  --}}
        });

        $(document).on('click', '#btnrefresh', function() {
            document.getElementById('s_asset').value  = '';
            document.getElementById('s_type').value  = '';
            document.getElementById('s_loc').value  = '';
            document.getElementById('s_eng').value  = '';
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
    
        $(document).on('click', '#btnexcel', function() {
            var asset = $('#s_asset').val();
            var type = $('#s_type').val();
            var loc = $('#s_loc').val();
            var eng = $('#s_eng').val();
            var bulan = $('#bulan').val();
      
            // console.log(srnumber, srasset, srstatus, /*srpriority, srperiod,*/ srreq, srdatefrom, srdateto);
      
            window.open("/donlodcost?asset=" + asset + "&type="+type+"&loc="+loc+"&eng="+eng+"&bulan="+bulan, '_blank');
          });
    
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection