@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-9 mt-2">
      <h1 class="m-0 text-dark">Work Order Release Approval</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan approval setelah melakukan work order release</p>
    </div><!-- /.col -->
    <div class="col-sm-3">
      <!-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active">Work Order Approval</li>
      </ol> -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
  .swal-popup {
    font-size: 2rem !important;
  }
</style>
<!--Table Menu-->
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
        <label for="s_nomorwo" class="col-md-3 col-form-label text-md-left">{{ __('Work Order Number') }}</label>
        <div class="col-md-3 col-sm-12 mb-2 input-group">
          <input id="s_nomorwo" type="text" class="form-control" name="s_nomorwo" value="" autofocus autocomplete="off">
        </div>
        <label for="s_asset" class="col-md-3 col-form-label text-md-center">{{ __('Asset') }}</label>
        <div class="col-md-3 col-sm-12 mb-2 input-group">
          <!-- <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
            <option value="">--Select Asset--</option>
            @foreach($asset1 as $assetsearch)
            <option value="{{$assetsearch->asset_code}}">{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
            @endforeach
          </select> -->
          <input id="s_asset" type="text" class="form-control" name="s_asset" value="" autofocus autocomplete="off">
        </div>
      </div>
      <div class="col-12 form-group row">
        <label for="s_status" class="col-md-3 col-form-label text-md-left">{{ __('Status Approval') }}</label>
        <div class="col-md-3 col-sm-12 mb-2 input-group">
          <select id="s_status" type="text" class="form-control" name="s_status">
            <option value="">--Select Status Approval--</option>
            <option value="waiting for approval">Waiting for approval</option>
            <option value="approved">Approved</option>
            <option value="revision">Revision</option>
          </select>
        </div>
        <!-- <label for="" class="col-md-2 col-form-label text-md-left">{{ __('') }}</label> -->
        <label for="s_priority" class="col-md-3 col-form-label text-md-center">{{ __('Priority') }}</label>
        <div class="col-md-3 col-sm-12 mb-2 input-group">
          <select id="s_priority" type="text" class="form-control" name="s_priority">
            <option value="">--Select Priority--</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>
        <!-- <label for="" class="col-md-3 col-form-label text-md-right">{{ __('') }}</label> -->
        <div class="col-md-2 col-sm-12 mb-2 input-group">
          <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" style="float:right" />
        </div>
        <div class="col-md-2 col-sm-12 mb-2 input-group">
          <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'><i class="fas fa-sync-alt"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="tmpwo" value="" />
<input type="hidden" id="tmpasset" value="" />
<input type="hidden" id="tmpstatus" value="" />
<input type="hidden" id="tmppriority" value="" />
<input type="hidden" id="tmpperiod" value="" />

<div class="col-md-5">

</div>

<hr>

{{--
  Daftar Perubahan :
  A211027 : Jika tipe PM, cancel jobnya dihide
--}}
<div class="col-12 form-group row p-0 m-0">

  <div class="table-responsive col-12" style="overflow-x: auto; overflow-y: hidden; width: 100rem;">
    <table class="table table-bordered mini-table mt-4" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr style="text-align: center;">
          <th width="10%">WO Number</th>
          <th width="33%">Asset</th>
          <th width="12%">Status Approval</th>
          <th width="5%">Priority</th>
          <th width="10%">Released date</th>
          <th width="10%">Released time</th>
          <th width="10%">Released by</th>
          <th width="7%">Action</th>
        </tr>
      </thead>
      <tbody>
        @include('workorder.table-woreleaseapproval')
      </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
  </div>
  <input type="hidden" id="tmpwo" value="">
  <input type="hidden" id="tmpengineer" value="">
  <input type="hidden" id="tmpstatus" value="">

  <!--Modal view-->
  <div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Approval</h5>
          <button type="button" id="xclose" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" id="newedit" method="post" action="/approvewo">
          {{ csrf_field() }}
          <input type="hidden" id="v_counter">
          <input type="hidden" id="idwo" name="idwo">
          <input type="hidden" name="statuswo" id="statuswo">
          <div class="modal-body">
            <div class="form-group row justify-content-center">
              <label for="v_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
              <div class="col-md-7">
                <input id="v_nowo" type="text" class="form-control" name="v_nowo" autocomplete="off" readonly autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
              <div class="col-md-7">
                <input id="v_nosr" type="text" class="form-control" name="v_nosr" readonly autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_creator" class="col-md-5 col-form-label text-md-left">Requested By</label>
              <div class="col-md-7">
                <input id="v_creator" readonly class="form-control" name="v_creator" value="{{ old('v_creator') }}" autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
              <div class="col-md-7">
                <input id="v_dept" readonly class="form-control" name="v_note" value="{{ old('v_dept') }}" autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
              <div class="col-md-7">
                <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_assetdesc" class="col-md-5 col-form-label text-md-left">Asset Desc</label>
              <div class="col-md-7">
                <textarea type="text" readonly id="v_assetdesc" type="text" class="form-control v_assetdesc" name="v_assetdesc" rows="3"></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_loc" class="col-md-5 col-form-label text-md-left">Location</label>
              <div class="col-md-7">
                <input id="v_loc" type="text" class="form-control" name="v_loc" value="{{ old('v_loc') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_wottype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
              <div class="col-md-7">
                <input id="v_wottype" type="text" class="form-control" name="v_wottype" value="{{ old('v_wottype') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_fclist" class="col-md-5 col-form-label text-md-left">Failure Code</label>
              <div class="col-md-7">
                <textarea id="v_fclist" class="form-control" name="v_fclist" value="{{ old('v_fclist') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
              <div class="col-md-7">
                <textarea id="v_impact" class="form-control" name="v_impact" value="{{ old('v_impact') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
              <div class="col-md-7">
                <input id="v_priority" type="text" class="form-control" name="v_priority" value="{{ old('v_priority') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_note" class="col-md-5 col-form-label text-md-left">Note</label>
              <div class="col-md-7">
                <textarea id="v_note" readonly class="form-control" name="v_note" value="{{ old('v_note') }}" autofocus></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_mtcode" class="col-md-5 col-form-label text-md-left">Maintenance Code</label>
              <div class="col-md-7">
                <input id="v_mtcode" type="text" class="form-control" name="v_mtcode" value="{{ old('v_mtcode') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_inslist" class="col-md-5 col-form-label text-md-left">Instruction List</label>
              <div class="col-md-7">
                <input id="v_inslist" type="text" class="form-control" name="v_inslist" value="{{ old('v_inslist') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_splist" class="col-md-5 col-form-label text-md-left">Instruction Spare Part</label>
              <div class="col-md-7">
                <input id="v_splist" type="text" class="form-control" name="v_splist" value="{{ old('v_splist') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_qclist" class="col-md-5 col-form-label text-md-left">Instruction QC</label>
              <div class="col-md-7">
                <input id="v_qclist" type="text" class="form-control" name="v_qclist" value="{{ old('v_qclist') }}" autofocus readonly>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_engineerl" class="col-md-5 col-form-label text-md-left">Engineer List</label>
              <div class="col-md-7">
                <textarea id="v_engineerl" class="form-control v_engineerl" name="v_engineerl" autofocus readonly></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_startdate" class="col-md-5 col-form-label text-md-left">Start Date</label>
              <div class="col-md-7">
                <input id="v_startdate" readonly type="date" class="form-control" name="v_startdate" value="{{ old('v_startdate') }}" autofocus>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <label for="v_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
              <div class="col-md-7">
                <input id="v_duedate" readonly type="date" class="form-control" name="v_duedate" value="{{ old('e_duedate') }}" autofocus readonly>
              </div>
            </div>
            <div id="divstartdate" class="form-group row justify-content-center">
              <label for="v_jobstartdate" class="col-md-5 col-form-label text-md-left">Job Start Date</label>
              <div class="col-md-7">
                <input id="v_jobstartdate" type="date" class="form-control" name="v_jobstartdate" readonly>
              </div>
            </div>
            <div id="divstarttime" class="form-group row justify-content-center">
              <label for="v_jobstarttime" class="col-md-5 col-form-label text-md-left">Job Start Time</label>
              <div class="col-md-7">
                <input id="v_jobstarttime" type="time" class="form-control" name="v_jobstarttime" readonly>
              </div>
            </div>
            <div id="divreprocessreason" class="form-group row justify-content-center">
              <label for="v_reason" class="col-md-5 col-form-label text-md-left">Reason</label>
              <div class="col-md-7">
                <textarea id="v_reason" name="v_reason" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
              <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button>
              <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Modal route-->
  <div class="modal fade" id="routeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Route to Action</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-group row">
              <label for="ppnumber" class="col-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-sm-center">{{
                            __('WO No.')
                            }}</label>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="text" class="form-control" id="m_route_ppnumber" readonly>
              </div>
              <label for="requestedBy" class="col-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-sm-center">{{
                            __('Requested By')
                            }}</label>
              <div class="col-4 col-sm-4 col-md-4 col-lg-3">
                <input type="text" class="form-control" id="m_route_requested_by" readonly>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group row">
              <label for="site" class="col-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-sm-center">{{
                            __('Asset')
                            }}</label>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="text" class="form-control" id="m_route_asset" readonly>
              </div>
            </div>
          </div>
          <div class="form-group row" style="margin-bottom: 0px;">
            <div class="col-lg-12 col-md-12" style="overflow-x: auto; display: block;white-space: nowrap;">
              <table id='routetable' class='table route-list' style="margin-bottom: 0px;">
                <thead>
                  <tr>
                    <th style="width:10%">No.</th>
                    <th style="width:10%">Department</th>
                    <th style="width:10%">Role</th>
                    <!-- <th style="width:15%">Reason</th> -->
                    <th style="width:10%">Status</th>
                    <th style="width:10%">Approved By</th>
                    <th style="width:15%">Timestamp</th>
                  </tr>
                </thead>
                <tbody id='bodyroute'>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-info btn-outline-success" id="e_btnclose" data-dismiss="modal"><i
                        class="fas fa-undo"></i>&nbsp;Cancel</button> -->
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
    $("#newedit").submit(function() {
      document.getElementById('btnclose').style.display = 'none';
      document.getElementById('btnreject').style.display = 'none';
      document.getElementById('btnapprove').style.display = 'none';
      document.getElementById('btnloading').style.display = '';
    });


    function clear_icon() {
      $('#id_icon').html('');
      $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus, wopriority) {
      $.ajax({
        url: "/woreleaseapprovalsearch?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset + "&wostatus=" + wostatus + "&wopriority=" + wopriority,
        success: function(data) {
          // console.log(data);
          $('tbody').html('');
          $('tbody').html(data);
        }
      })
    }
    // $("#s_asset").select2({
    //   width: '100%',

    //   closeOnSelect: true,
    //   theme: 'bootstrap4'
    // });
    $(document).on('click', '.jobview', function() {
      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      // $('#loadingtable').modal('hide');
      $('#loadingtable').modal('show');
      var counter = document.getElementById('v_counter');
      $.ajax({
        url: '/womaint/getwoinfo',
        method: 'GET',
        data: {
          wonumber: wonbr,
        },
        success: function(vamp) {
          var wonumber = wonbr;
          var id = vamp.wo_master.id;
          var srnumber = vamp.wo_master.wo_sr_number;
          var assetcode = vamp.wo_master.wo_asset_code;
          var assetdesc = vamp.asset.asset_desc;
          var assetloc = vamp.asset.asset_loc;
          var failuretype_code = vamp.wo_master.wo_failure_type !== null ? vamp.wo_master.wo_failure_type : '';
          var failuretype_desc = vamp.failure_type.wotyp_desc ? vamp.failure_type.wotyp_desc : '';
          var note = vamp.wo_master.wo_note;
          var startdate = vamp.wo_master.wo_start_date;
          var duedate = vamp.wo_master.wo_due_date;
          var jobstartdate = vamp.wo_master.wo_job_startdate;
          var jobstarttime = vamp.wo_master.wo_job_starttime;
          var createdby = vamp.wo_master.wo_createdby;
          var status = vamp.wo_master.wo_status;
          var wotype = vamp.wo_master.wo_type;
          var department = vamp.wo_master.wo_department ? vamp.wo_master.wo_department : '';
          var maintcode = vamp.wo_master.wo_mt_code ? vamp.wo_master.wo_mt_code : '';
          var maintcodedesc = vamp.mtcode ? vamp.mtcode.pmc_desc : '';
          var inscode = vamp.wo_master.wo_ins_code ? vamp.wo_master.wo_ins_code : '';
          var inscodedesc = vamp.inslist ? vamp.inslist.ins_desc : '';
          var spcode = vamp.wo_master.wo_sp_code ? vamp.wo_master.wo_sp_code : '';
          var spcodedesc = vamp.splist ? vamp.splist.spg_desc : '';
          var qccode = vamp.wo_master.wo_qcspec_code ? vamp.wo_master.wo_qcspec_code : '';
          var qccodedesc = vamp.qcslist ? vamp.qcslist.qcs_desc : '';
          // console.log(id);
          let combineFailure = [];

          vamp.failurecode.forEach(function(failure) {
            combineFailure.push(failure.fn_code + " - " + failure.fn_desc);
          });

          let combineImpact = [];

          vamp.impact.forEach(function(impact) {
            combineImpact.push(impact.imp_code + " - " + impact.imp_desc);
          });

          let combineEngineer = [];

          vamp.engineer.forEach(function(engineer) {
            combineEngineer.push(engineer.eng_code + ' - ' + engineer.eng_desc);
          });

          document.getElementById('v_nowo').value = wonumber;
          document.getElementById('idwo').value = id;
          document.getElementById('v_asset').value = assetcode;
          document.getElementById('v_assetdesc').value = assetdesc;
          document.getElementById('v_loc').value = assetloc;
          document.getElementById('v_wottype').value = failuretype_code + ' - ' + failuretype_desc;
          document.getElementById('v_fclist').value = combineFailure.join('\n');
          document.getElementById('v_impact').value = combineImpact.join('\n');
          document.getElementById('v_engineerl').value = combineEngineer.join('\n');
          document.getElementById('v_note').value = note;
          document.getElementById('v_nosr').value = srnumber;
          document.getElementById('v_startdate').value = startdate;
          document.getElementById('v_duedate').value = duedate;
          document.getElementById('v_jobstartdate').value = jobstartdate;
          document.getElementById('v_jobstarttime').value = jobstarttime;
          document.getElementById('v_creator').value = createdby;
          document.getElementById('v_dept').value = department;
          document.getElementById('statuswo').value = status;
          document.getElementById('v_mtcode').value = maintcode + ' - ' + maintcodedesc;
          document.getElementById('v_inslist').value = inscode + ' - ' + inscodedesc;
          document.getElementById('v_splist').value = spcode + ' - ' + spcodedesc;
          document.getElementById('v_qclist').value = qccode + ' - ' + qccodedesc;
          // document.getElementById('v_mtcby').value       = mtcby;

          if ($('#loadingtable').hasClass('show')) {

            setTimeout(function() {
              $('#loadingtable').modal('hide');

            }, 500);


          }
          setTimeout(function() {

            $('#viewModal').modal('show');
          }, 1000);
        }
      })
    });


    $(document).on('click', '.route', function() {
      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      $('#routeModal').modal('show');

      $.ajax({
        url: '/womaint/getwoinfo',
        method: 'GET',
        data: {
          wonumber: wonbr,
        },
        success: function(vamp) {
          var wonumber = wonbr;
          var id = vamp.wo_master.id;
          var createdby = vamp.wo_master.wo_createdby;
          var assetcode = vamp.wo_master.wo_asset_code;

          document.getElementById('m_route_ppnumber').value = wonumber;
          document.getElementById('m_route_requested_by').value = createdby;
          document.getElementById('m_route_asset').value = assetcode;

          $.ajax({
            type: "GET",
            url: "/woreleaseapprovalroute",
            data: {
              wo_number: wonumber
            },
            success: function(data) {
              $('#bodyroute').html(data);
            }
          });

        }
      })

    });


    $(document).on('click', '#btnsearch', function() {
      var wonumber = $('#s_nomorwo').val();
      var woasset = $('#s_asset').val();
      var wostatus = $('#s_status').val();
      var wopriority = $('#s_priority').val();

      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpwo').value = wonumber;
      document.getElementById('tmpasset').value = woasset;
      document.getElementById('tmpstatus').value = wostatus;
      document.getElementById('tmppriority').value = wopriority;


      fetch_data(page, sort_type, column_name, wonumber, woasset, wostatus, wopriority);
    });


    $(document).on('click', '.sorting', function() {
      var column_name = $(this).data('column_name');
      var order_type = $(this).data('sorting_type');
      var reverse_order = '';
      if (order_type == 'asc') {
        $(this).data('sorting_type', 'desc');
        reverse_order = 'desc';
        clear_icon();
        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
      }
      if (order_type == 'desc') {
        $(this).data('sorting_type', 'asc');
        reverse_order = 'asc';
        clear_icon();
        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
      }
      $('#hidden_column_name').val(column_name);
      $('#hidden_sort_type').val(reverse_order);

      var page = $('#hidden_page').val();
      var wonumber = $('#tmpwo').val();
      var assert = $('#tmpasset').val();
      var status = $('#tmpstatus').val();
      var priority = $('#tmppriority').val();
      var period = $('#tmpperiod').val();
      fetch_data(page, reverse_order, column_name, username, divisi);
    });


    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var wonumber = $('#tmpwo').val();
      var asset = $('#tmpasset').val();
      var status = $('#tmpstatus').val();
      var priority = $('#tmppriority').val();
      fetch_data(page, sort_type, column_name, wonumber, asset, status, priority);
    });

    $(document).on('click', '#btnrefresh', function() {
      var wonumber = '';
      var asset = '';
      var status = '';

      var priority = '';
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('s_nomorwo').value = '';
      document.getElementById('s_asset').value = '';
      document.getElementById('s_status').value = '';

      document.getElementById('s_priority').value = '';
      document.getElementById('tmpwo').value = '';
      document.getElementById('tmpasset').value = '';
      document.getElementById('tmpstatus').value = '';
      document.getElementById('tmppriority').value = '';


      // $('#s_asset').select2({
      //   width: '100%',
      //   theme: 'bootstrap4',
      //   asset
      // })
      fetch_data(page, sort_type, column_name, wonumber, asset, status, priority);
    });
  </script>
  @endsection