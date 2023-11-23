@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9">
      <h1 class="m-0 text-dark">Work Order Detail Browse</h1>
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

<form action="/rptdetwo" method="GET">
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
              @foreach($asset1 as $assetsearch)
                <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_dept" class="col-md-2 col-form-label text-md-right">{{ __('Departement') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_dept" class="form-control" style="color:black" name="s_dept" autofocus autocomplete="off">
              <option value="">--Select Departement--</option>
              @foreach($dept as $dd)
                <option value="{{$dd->dept_code}}" {{$dd->dept_code === $sdept ? "selected" : ""}}>{{$dd->dept_code}} -- {{$dd->dept_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_type" class="col-md-2 col-form-label text-md-right">{{ __('Type') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_type" class="form-control" style="color:black" name="s_type" autofocus autocomplete="off">
              <option value="">--</option>
              <option value="CM" {{$stype === "CM" ? "selected" : ""}}>CM</option>
              <option value="PM" {{$stype === "PM" ? "selected" : ""}}>PM</option>
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
          <label for="s_eng" class="col-md-6 col-form-label text-md-right">{{ __('') }}</label>
          {{--  belum bisa cari cara codin search eng nya
            <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('Engineer') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_eng" class="form-control" style="color:black" name="s_eng" autofocus autocomplete="off">
              <option value="">--Select Engineer--</option>
              @foreach($engine as $de)
                <option value="{{$de->eng_code}}" {{$de->eng_code === $seng ? "selected" : ""}}>{{$de->eng_code}} -- {{$de->eng_desc}}</option>
              @endforeach
            </select>
          </div>  --}}
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
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btnexcel" value="WO to Excel" style="float:right" />
          </div>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <input type="button" class="btn btn-block btn-primary" id="btndetail" value="Detail to Excel" style="float:right" />
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
        <th>WO Number</th>
        <th>SR Number</th>
        <th>Asset</th>
        <th>Desc</th>
        <th>Req By</th>
        <th>Type</th>
        <th>Create Date</th>
        <th>Sch Date</th>
        <th>Note</th>
        <th>Status</th>
        <th>Sparepart</th>
        <th>Desc</th>
        <th>Qty Req</th>
        <th>Qty Issued</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @include('report.table-rptdetwo')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>
<input type="hidden" id="counterfail">
<input type="hidden" id="counter">

<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="v_counter" value=0>
      <div class="modal-body">
        <div class="form-group row">
          <label for="v_nowo" class="col-md-2 col-form-label text-md-left">WO Number</label>
          <div class="col-md-4">
            <input id="v_nowo" type="text" class="form-control" name="v_nowo" autocomplete="off" readonly autofocus>
          </div>
          <label for="v_creator" class="col-md-2 col-form-label text-md-left">Requested By</label>
          <div class="col-md-4">
            <input id="v_creator" readonly class="form-control" name="v_creator" value="{{ old('v_creator') }}" autofocus>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_nosr" class="col-md-2 col-form-label text-md-left">SR Number</label>
          <div class="col-md-4">
            <input id="v_nosr" type="text" class="form-control" name="v_nosr" readonly autofocus>
          </div>
          <label for="v_dept" class="col-md-2 col-form-label text-md-left">Department</label>
          <div class="col-md-4">
            <input id="v_dept" readonly class="form-control" name="v_dept" value="{{ old('v_dept') }}" autofocus>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_srnote" class="col-md-2 col-form-label text-md-left">SR Note</label>
          <div class="col-md-4">
            <textarea id="v_srnote" readonly class="form-control" name="v_srnote" value="{{ old('v_srnote') }}" autofocus></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_wotype" class="col-md-2 col-form-label text-md-left">WO Type</label>
          <div class="col-md-4">
            <input id="v_wotype" readonly class="form-control" name="v_wotype" value="{{ old('v_wotype') }}" autofocus>
          </div>
          <label for="v_status" class="col-md-2 col-form-label text-md-left">WO Status</label>
          <div class="col-md-4">
            <input id="v_status" readonly class="form-control" name="v_status" value="{{ old('v_status') }}" autofocus>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_asset" class="col-md-2 col-form-label text-md-left">Asset Code</label>
          <div class="col-md-4">
            <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus>
          </div>
          <label for="v_loc" class="col-md-2 col-form-label text-md-left">Location</label>
          <div class="col-md-4">
            <input id="v_loc" type="text" class="form-control" name="v_loc" value="{{ old('v_loc') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_assetdesc" class="col-md-2 col-form-label text-md-left">Asset Desc</label>
          <div class="col-md-4">
            <input type="text" readonly id="v_assetdesc" type="text" class="form-control v_assetdesc" name="v_assetdesc" autofocus>
          </div>
          <label for="v_wottype" class="col-md-2 col-form-label text-md-left">Failure Type</label>
          <div class="col-md-4">
            <input id="v_wottype" type="text" class="form-control" name="v_wottype" value="{{ old('v_wottype') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_note" class="col-md-2 col-form-label text-md-left">Note</label>
          <div class="col-md-4">
            <textarea id="v_note" readonly class="form-control" name="v_note" value="{{ old('v_note') }}" autofocus></textarea>
          </div>
          <label for="v_fclist" class="col-md-2 col-form-label text-md-left">Failure Code</label>
          <div class="col-md-4">
            <textarea id="v_fclist" class="form-control" name="v_fclist" value="{{ old('v_fclist') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_engineerl" class="col-md-2 col-form-label text-md-left">Engineer List</label>
          <div class="col-md-4">
            <textarea id="v_engineerl" class="form-control v_engineerl" name="v_engineerl" autofocus readonly></textarea>
          </div>
          <label for="v_impact" class="col-md-2 col-form-label text-md-left">Impact</label>
          <div class="col-md-4">
            <textarea id="v_impact" class="form-control" name="v_impact" value="{{ old('v_impact') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
            <label for="v_startdate" class="col-md-2 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-4">
              <input id="v_startdate" readonly type="text" class="form-control" name="v_startdate" value="{{ old('v_startdate') }}" autofocus>
            </div>
            <label for="v_wostart" class="col-md-2 col-form-label text-md-left">Start Date</label>
            <div class="col-md-4">
              <input id="v_wostart" type="text" class="form-control" name="v_wostart" value="{{ old('v_wostart') }}" autofocus readonly>
            </div>
        </div>
        <div class="form-group row">
          <label for="v_duedate" class="col-md-2 col-form-label text-md-left">Due Date</label>
          <div class="col-md-4">
            <input id="v_duedate" type="text" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}" autofocus readonly>
          </div>
          <label for="v_wofinish" class="col-md-2 col-form-label text-md-left">Finish Date</label>
          <div class="col-md-4">
            <input id="v_wofinish" readonly type="text" class="form-control" name="v_wofinish" value="{{ old('v_wofinish') }}" autofocus>
          </div>
      </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-left">SR Uploaded File</label>
          <div class="col-md-4" style="overflow-x: auto;">
            <!-- <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="munculgambar_view_sr">
            </table> -->
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="munculgambar_view_sr">

                </tbody>
              </table>  
          </div>
          <label class="col-md-2 col-form-label text-md-left">WO Uploaded File</label>
          <div class="col-md-4" style="overflow-x: auto;">
            <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="munculgambar_view">
            </table>  
          </div>
        </div>
        <div class="form-group row">
            <label for="v_rejectreason" class="col-md-2 col-form-label text-md-left">User Acceptance Note</label>
            <div class="col-md-4">
              <textarea id="v_rejectreason" readonly type="text" class="form-control" name="v_rejectreason" value="{{ old('v_rejectreason') }}" rows="2" autofocus></textarea>
            </div>
            <label class="col-md-2 col-form-label text-md-left">WO Reporting File</label>
            <div class="col-md-4" style="overflow-x: auto;">
              <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="fileupload_reporting">
              </table>  
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- modal image -->

<div class="modal fade" id="imageModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Photo(s) Uploaded</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div id="munculgambar">

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
  $('#s_dept').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
  $('#s_loc').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
  $('#s_eng').select2({
    width: '100%',
    theme: 'bootstrap4',
  });

  $('#s_creator').select2({
    width: '100%',
    theme: 'bootstrap4',
  });

  $(document).on('click', '.viewwo', function() {
    $('#viewModal').modal('show');
    var wonbr = $(this).data('wonbr');
    var srnumber = $(this).data('srnumber');
    {{--  var btnendel1 = document.getElementById("btndeleteen1");
    var btnendel2 = document.getElementById("btndeleteen2");
    var btnendel3 = document.getElementById("btndeleteen3");
    var btnendel4 = document.getElementById("btndeleteen4");
    var btnendel5 = document.getElementById("btndeleteen5");
    var counter = document.getElementById('counter').value;
    var counterfail = document.getElementById('counterfail').value;  --}}
    $.ajax({
      url: '/womaint/getwoinfo',
      method: 'GET',
      data: {
          wonumber: wonbr,
      },
      success: function(vamp) {

        // console.log(vamp);
        
        var wonumber = wonbr;
        var srnumber = vamp.wo_master.wo_sr_number;
        var assetcode = vamp.wo_master.wo_asset_code;
        var srnote = vamp.sr_note;
        var assetdesc = vamp.asset.asset_desc;
        var assetloc = vamp.asset.asset_loc;
        var assetloc_desc = vamp.asset.asloc_desc;
        var failuretype_code = vamp.wo_master.wo_failure_type !== null ? vamp.wo_master.wo_failure_type : '';
        var failuretype_desc = vamp.failure_type.wotyp_desc ? vamp.failure_type.wotyp_desc : '';
        var note = vamp.wo_master.wo_note;
        var startdate = vamp.wo_master.wo_start_date;
        startdate = new Date(startdate).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        var duedate = vamp.wo_master.wo_due_date;
        duedate = new Date(duedate).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        var createdby = vamp.wo_master.wo_createdby;
        var department = vamp.wo_master.wo_department ? vamp.wo_master.wo_department : '';
        var rejectreason = vamp.sr_acceptance_note ? vamp.sr_acceptance_note : '';
        var status = vamp.wo_master.wo_status;
        var wotype = vamp.wo_master.wo_type;
        var wostart = vamp.wo_master.wo_job_startdate ? new Date(vamp.wo_master.wo_job_startdate).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '';
        var wofinish = vamp.wo_master.wo_job_finishdate ? new Date(vamp.wo_master.wo_job_finishdate).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '';

        let combineFailure = [];

        vamp.failurecode.forEach(function(failure) {
          combineFailure.push(failure.fn_code + " - " + failure.fn_desc);
        });

        let combineImpact = [];

        vamp.impact.forEach(function(impact){
          combineImpact.push(impact.imp_code + " - " + impact.imp_desc);
        });

        let combineEngineer = [];

        vamp.engineer.forEach(function(engineer){
          combineEngineer.push(engineer.eng_code + ' - ' + engineer.eng_desc);
        });


        document.getElementById('v_nowo').value = wonumber;
        document.getElementById('v_asset').value = assetcode;
        document.getElementById('v_assetdesc').value = assetdesc;
        document.getElementById('v_loc').value = assetloc + ' - ' + assetloc_desc;
        document.getElementById('v_wottype').value = failuretype_code + ' - ' + failuretype_desc;
        document.getElementById('v_fclist').value = combineFailure.join('\n');
        document.getElementById('v_impact').value = combineImpact.join('\n');
        document.getElementById('v_engineerl').value = combineEngineer.join('\n');
        document.getElementById('v_note').value = note;
        document.getElementById('v_nosr').value = srnumber;
        document.getElementById('v_startdate').value = startdate;
        document.getElementById('v_duedate').value = duedate;
        document.getElementById('v_creator').value = createdby;
        document.getElementById('v_dept').value = department;
        document.getElementById('v_srnote').value = srnote;
        document.getElementById('v_rejectreason').value = rejectreason;
        document.getElementById('v_status').value = status;
        document.getElementById('v_wotype').value = wotype;
        document.getElementById('v_wostart').value = wostart;
        document.getElementById('v_wofinish').value = wofinish;
        

      },complete: function(vamp) {
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));

        {{--  setTimeout(function() {
          $('#loadingtable').modal('hide');
        }, 500);

        setTimeout(function() {
          $('#viewModal').modal('show');
        }, 1000);  --}}

      }
    })

    $.ajax({
      url: "/imageviewonly_woimaint",
      data: {
        wonumber: wonbr,
      },
      success: function(data) {

        $('#munculgambar_view').html('').append(data);
      }
    })

    $.ajax({
      url: "/imageview_nodelete",
      data: {
        wonumber: wonbr,
      },
      success: function(data) {

        $('#fileupload_reporting').html('').append(data);
      }
    })

    $.ajax({
        url: "/listuploadview/" + srnumber,
        success: function(data) {
          // console.log(data);
          $('#munculgambar_view_sr').html('').append(data);
        }
      })
  });
  // flag tunggu semua menu  --}}

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function resetSearch() {
    $('#s_nomorwo').val('');
    $('#s_asset').val('');
    $('#s_per1').val('');
    $('#s_per2').val('');
    $('#s_dept').val('');
    $('#s_loc').val('');
    $('#s_eng').val('');
    $('#s_type').val('');
  }

  $(document).on('click', '#btnrefresh', function() {
    document.getElementById('s_per1').required = false;
    document.getElementById('s_per2').required = false;

    resetSearch();
  });

  $(document).on('click', '#btnexcel', function() {
    var swo = $('#s_nomorwo').val();
    var sasset = $('#s_asset').val();
    var per1 = $('#s_per1').val();
    var per2 = $('#s_per2').val();
    var dept = $('#s_dept').val();
    var loc = $('#s_loc').val();
    var eng = $('#s_eng').val();
    var type = $('#s_type').val();
    
    window.open("/exceldetwo?dexcel=excel&swo=" + swo + "&sasset=" + sasset + "&per1=" + per1 + "&per2=" + per2 +
        "&sdept=" + dept + "&sloc=" + loc + "&seng=" + eng + "&stype=" + type , '_blank');
  });

  $(document).on('click', '#btndetail', function() {
    var swo = $('#s_nomorwo').val();
    var sasset = $('#s_asset').val();
    var per1 = $('#s_per1').val();
    var per2 = $('#s_per2').val();
    var dept = $('#s_dept').val();
    var loc = $('#s_loc').val();
    var eng = $('#s_eng').val();
    var type = $('#s_type').val();
    
    window.open("/exceldetwo?dexcel=detail&swo=" + swo + "&sasset=" + sasset + "&per1=" + per1 + "&per2=" + per2 +
        "&sdept=" + dept + "&sloc=" + loc + "&seng=" + eng + "&stype=" + type , '_blank');
  });

  $(document).on('click', '.imageview', function() {
    $('#imageModal').modal('show');
    var wonumber = $(this).data('wonbr');

    $.ajax({
      url: "/imageview",
      data: {
        wonumber: wonumber,
      },
      success: function(data) {
        console.log(data);

        var totalgambar = data.length;

        console.log(totalgambar);

        var url_gambar = [];
        var test = [];
        for (var i = 0; i < totalgambar; i++) {
          url_gambar.push(data[i].file_url);
          var pisah = url_gambar[i];

          var pisah2 = pisah.split("/");

          var gabungurl = pisah2[2] + '/' + pisah2[3];

          // alert(src);
          test += '<a target="_blank" href="' + gabungurl + '"><img class="gambar" src="' + gabungurl + '" width="200" height="200"></a>';

        }

        $('#munculgambar').html('').append(test);
      }
    })
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