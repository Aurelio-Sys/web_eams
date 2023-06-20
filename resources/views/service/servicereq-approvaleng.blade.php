@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">Service Request Approval Engineer</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan approval supervisor engineer</p>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
<!-- <hr> -->
@endsection

@section('content')
<style type="text/css">
  @media screen and (max-width: 992px) {

    .mini-table {
      border: 0;
    }

    .mini-table thead {
      display: none;
    }

    .mini-table tr {
      margin-bottom: 10px;
      display: block;
      border-bottom: 2px solid #ddd;
    }

    .mini-table td {
      display: block;
      text-align: right;
      font-size: 13px;
      border-bottom: 1px dotted #ccc;
    }

    .mini-table td:last-child {
      border-bottom: 0;
    }

    .mini-table td:before {
      content: attr(data-label);
      float: left;
      text-transform: uppercase;
      font-weight: bold;
    }

    .select2-results__option--disabled {
      color: grey !important;
    }

  }
</style>
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
        <label for="s_servicenbr" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Service Request Number') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <input id="s_servicenbr" type="text" class="form-control" name="s_servicenbr" value="" autofocus autocomplete="off" placeholder="Search SR Number">
          <!-- <select id="s_servicenbr" name="s_servicenbr" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select SR Number--</option>
            @foreach($datasrnbr as $srnbr)
            <option value="{{$srnbr->sr_number}}">{{$srnbr->sr_number}}</option>
            @endforeach
          </select> -->
        </div>
        <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('Asset Description') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <!-- <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Asset--</option>
            @foreach($asset as $show)
            <option value="{{$show->asset_desc}}">{{$show->asset_desc}}</option>
            @endforeach
          </select> -->
          <input id="s_asset" type="text" class="form-control" name="s_asset" value="" autofocus autocomplete="off" placeholder="Search Asset Description">
        </div>
      </div>
      <div class="col-12 form-group row">
        <!--FORM Search Disini-->
        <label for="s_priority" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Priority') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_priority" name="s_priority" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Priority--</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>
        <!-- <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label> -->
        <label for="s_status" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('Status') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_status" name="s_status" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Status--</option>
            <option value="Waiting for engineer approval">Waiting for approval</option>
            <option value="Approved">Approved</option>
            <option value="Revision from engineer approval">Rejected</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <input type="button" class="btn btn-primary" id="btnsearch" value="Search" style="float:right" />
          <button type="button" class="btn btn-primary ml-2" id="btnrefresh"><i class="fas fa-redo-alt"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="tmpsrnumber" />
<input type="hidden" id="tmpasset" />
<input type="hidden" id="tmppriority" />
<input type="hidden" id="tmpperiod" />
<input type="hidden" id="tmpstatus" />

<!-- table picklist -->
<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <!-- <th width="10%">SR Number</th>
        <th width="25%">Asset</th>
        <th width="10%">Location</th>
        <th width="7%">Priority</th>
        <th width="10%">Req by</th>
        <th width="7%">Req Date</th>
        <th width="15%">Note</th>
        <th width="7%">Action</th> -->
        <th>SR Number</th>
        <th>Asset</th>
        <th>Asset Description</th>
        <th>Status Approval</th>
        <!-- <th>Location</th> -->
        <!-- <th>Status</th> -->
        <th>Priority</th>
        <!-- <th>Department</th> -->
        <th>Req by</th>
        <th>Req Date</th>
        <th>Req Time</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @include('service.table-srapprovaleng')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Approval -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Approval Engineer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="approvaleng" method="post" action="/approvaleng" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <input type="hidden" id="hiddenreq" name="hiddenreq" />
          <input type="hidden" id="idsr" name="idsr" />
          <div class="form-group row col-md-12">
            <label for="srnumber" class="col-md-5 col-form-label text-md-left">Service Request Number</label>
            <div class="col-md-7">
              <input id="srnumber" type="text" class="form-control" name="srnumber" readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="srdate" class="col-md-5 col-form-label text-md-left">Service Request Date</label>
            <div class="col-md-7">
              <input id="srdate" type="text" class="form-control" name="srdate" readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="reqbyname" class="col-md-5 col-form-label text-md-left">Requested by</label>
            <div class="col-md-7">
              <input id="reqbyname" type="text" class="form-control" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input id="dept" type="text" class="form-control" name="dept" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="assetcode" class="col-md-5 col-form-label text-md-left">Asset Code</label>
            <div class="col-md-7">
              <input id="assetcode" type="text" class="form-control" name="assetcode" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="assetdesc" class="col-md-5 col-form-label text-md-left">Asset Description</label>
            <div class="col-md-7">
              <textarea id="assetdesc" type="text" class="form-control" name="assetdesc" rows="3" autocomplete="off" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="assetloc" class="col-md-5 col-form-label text-md-left">Location</label>
            <div class="col-md-7">
              <input id="assetloc" type="text" class="form-control" name="assetloc" autocomplete="off" autofocus readonly />
              <input id="h_assetsite" type="hidden" name="h_assetsite" />
              <input id="h_assetloc" type="hidden" name="h_assetloc" />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="srnote" class="col-md-5 col-form-label text-md-left">SR Note</label>
            <div class="col-md-7">
              <textarea id="srnote" type="text" class="form-control" name="srnote" maxlength="250" autocomplete="off" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="file" class="col-md-5 col-form-label text-md-left">Current File</label>
            <div class="col-md-7">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="listupload">

                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="wotype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
            <div class="col-md-7">
              <!-- <input id="wotype" type="text" class="form-control" name="wotype" autocomplete="off" /> -->
              <select class="form-control wotype" name="wotype" id="wotype">
                <option value="">Select Failure Type</option>
                @foreach($wotypes as $wotype)
                <option value="{{$wotype->wotyp_code}}">{{$wotype->wotyp_code}} - {{$wotype->wotyp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="fclist" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7">
              <!-- <textarea id="fclist" type="text" class="form-control" name="fclist" rows="3"></textarea> -->
              <select class="form-control fclist" name="fclist[]" id="fclist" multiple="multiple">
                <option></option>
                @foreach($fcodes as $fcshow)
                <option value="{{$fcshow->fn_code}}">{{$fcshow->fn_code}} -- {{$fcshow->fn_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <input type="hidden" id="hide_editassetgroup" />
          <div class="form-group row col-md-12">
            <label for="impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <!-- <textarea id="impact" type="text" class="form-control" name="impact" autocomplete="off" rows="3"></textarea> -->
              <select class="form-control impact" name="impact[]" id="impact" multiple="multiple">
                <option value=""></option>
                @foreach($impacts as $impact)
                <option value="{{$impact->imp_code}}">{{$impact->imp_code}} -- {{$impact->imp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <!-- <input id="priority" type="text" name="priority" class="form-control"> -->
              <select class="form-control priority" name="priority" id="priority" required>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="enjiners" class="col-md-5 col-form-label text-md-left">Engineer (Max. 5) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="enjiners" name="enjiners[]" class="form-control" multiple="multiple" required>
                <option value="">--Select Engineer--</option>
              </select>
            </div>
          </div>

          <!-- <div class="form-group row justify-content-center">
            <label for="selectrep" class="col-md-5 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7 my-auto">
              <input type="radio" id="rad_repgroup1" class="d-inline" name="rad_repgroup" value="group" required>
              <label for="rad_repgroup1" class="form-check-label">Repair Group</label>

              <input type="radio" id="rad_repgroup2" class="d-inline ml-2" name="rad_repgroup" value="code">
              <label for="rad_repgroup2" class="form-check-label">Repair Code</label>
            </div>
          </div> -->
          <!-- 
          <div class="form-group row" id="tampilanrepgroup" style="display: none;">
            <label for="repaircode" class="col-md-5 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="repgroup" name="repgroup" class="form-control">
                <option>--Select Repair Group--</option>
                @foreach($repgroup as $repgroupshow)
                <option value="{{$repgroupshow->xxrepgroup_nbr}}">{{$repgroupshow->xxrepgroup_nbr}} -- {{$repgroupshow->xxrepgroup_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row" id="tampilanrepcode" style="display: none;">
            <label for="repaircode" class="col-md-5 col-form-label text-md-left">Repair Code (Max. 3) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="repaircode" name="repaircode[]" class="form-control" multiple="multiple">
                <option>--Select Repair Code--</option>
                @foreach($repaircode as $repairshow)
                <option value="{{$repairshow->repm_code}}">{{$repairshow->repm_code}} -- {{$repairshow->repm_desc}}</option>
                @endforeach
              </select>
            </div>
          </div> -->
          <!-- Engineer ENDDDDD -->
          <!-- <div class="row" id="inialert1" style="display: none; margin-bottom: 1rem;">
                        <label class="col-md-4"></label>
                        <span id="alert1" style="font-weight: 400; color: red;"></span>
                    </div> -->
          <div class="form-group row col-md-12">
            <label for="scheduledate" class="col-md-5 col-form-label text-md-left">Start Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              {{-- <input id="scheduledate" type="date" class="form-control" name="scheduledate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('scheduledate') }}"> --}}
              <input id="scheduledate" type="date" class="form-control" name="scheduledate" placeholder="yy-mm-dd" autocomplete="off" autofocus required value="{{ old('scheduledate') }}">
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              {{-- <input id="duedate" type="date" class="form-control" name="duedate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('duedate') }}"> --}}
              <input id="duedate" type="date" class="form-control" name="duedate" placeholder="yy-mm-dd" autocomplete="off" autofocus required value="{{ old('duedate') }}">
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="wonote" class="col-md-5 col-form-label text-md-left">Note for Work Order</label>
            <div class="col-md-7">
              <textarea id="wonote" type="text" class="form-control" name="wonote" maxlength="250" autocomplete="off" autofocus></textarea>
              <span id="alert3" style="color: red; font-weight: 200;"></span>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_mtcode" class="col-md-5 col-form-label text-md-left">Maintenance Code</label>
            <div class="col-md-7">
              <select id="c_mtcode" name="c_mtcode" class="form-control">
                <option></option>
                @foreach($maintenancelist as $mt)
                <option value="{{$mt->pmc_code}}">{{$mt->pmc_code}} -- {{$mt->pmc_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_inslist" class="col-md-5 col-form-label text-md-left">Instruction List</label>
            <div class="col-md-7">
              <select id="c_inslist" name="c_inslist" class="form-control">
                <option></option>
                @foreach ($inslist as $ins)
                <option value="{{$ins->ins_code}}">{{$ins->ins_code}} -- {{$ins->ins_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_splist" class="col-md-5 col-form-label text-md-left">Instruction Spare Part</label>
            <div class="col-md-7">
              <select id="c_splist" name="c_splist" class="form-control">
                <option></option>
                @foreach ($splist as $sp)
                <option value="{{$sp->spg_code}}">{{$sp->spg_code}} -- {{$sp->spg_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_qclist" class="col-md-5 col-form-label text-md-left">Instruction QC</label>
            <div class="col-md-7">
              <select id="c_qclist" name="c_qclist" class="form-control">
                <option></option>
                @foreach ($qclist as $qc)
                <option value="{{$qc->qcs_code}}">{{$qc->qcs_code}} -- {{$qc->qcs_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="rejectreason" class="col-md-5 col-form-label text-md-left">Reason</label>
            <div class="col-md-7">
              <textarea id="rejectreason" type="text" class="form-control" name="rejectreason" maxlength="250" autocomplete="off" autofocus></textarea>
              <span id="alert3" style="color: red; font-weight: 200;"></span>
            </div>
          </div>

          <input type="hidden" id="tmpfail1" name="tmpfail1" value="">
          <input type="hidden" id="impactcode1" name="impactcode1" value="">
          <input type="hidden" id="tmpfail2" name="tmpfail2" value="">
          <input type="hidden" id="tmpfail3" name="tmpfail3" value="">
          <input type="hidden" id="hiddendeptcode" name="hiddendeptcode" />
          <!-- <input type="hidden" id="hiddenreqby" name="hiddenreqby" /> -->

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
            <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewApprModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Approval Engineer View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="approvaleng" method="post" action="/approvaleng" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <input type="hidden" id="v_hiddenreq" name="v_hiddenreq" />
          <input type="hidden" id="v_idsr" name="v_idsr" />
          <div class="form-group row col-md-12">
            <label for="v_srnumber" class="col-md-5 col-form-label text-md-left">Service Request Number</label>
            <div class="col-md-7">
              <input id="v_srnumber" type="text" class="form-control" name="v_srnumber" readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_srdate" class="col-md-5 col-form-label text-md-left">Service Request Date</label>
            <div class="col-md-7">
              <input id="v_srdate" type="text" class="form-control" name="v_srdate" readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_reqbyname" class="col-md-5 col-form-label text-md-left">Requested by</label>
            <div class="col-md-7">
              <input id="v_reqbyname" type="text" class="form-control" name="v_reqbyname" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input id="v_dept" type="text" class="form-control" name="v_dept" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_status" class="col-md-5 col-form-label text-md-left">Approval Status</label>
            <div class="col-md-7">
              <input id="v_status" type="text" class="form-control" name="v_status" autocomplete="off" maxlength="6" readonly style="color:green;font-weight:bold">
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_reason" class="col-md-5 col-form-label text-md-left">Approval Reason</label>
            <div class="col-md-7">
              <textarea id="v_reason" type="text" class="form-control" name="v_reason" autocomplete="off" rows="2" readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_assetcode" class="col-md-5 col-form-label text-md-left">Asset Code</label>
            <div class="col-md-7">
              <input id="v_assetcode" type="text" class="form-control" name="v_assetcode" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_assetdesc" class="col-md-5 col-form-label text-md-left">Asset Description</label>
            <div class="col-md-7">
              <textarea id="v_assetdesc" type="text" class="form-control" name="v_assetdesc" rows="3" autocomplete="off" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_assetloc" class="col-md-5 col-form-label text-md-left">Asset Location</label>
            <div class="col-md-7">
              <input id="v_assetloc" type="text" class="form-control" name="v_assetloc" autocomplete="off" autofocus readonly />
              <input id="v_h_assetsite" type="hidden" name="v_h_assetsite" />
              <input id="v_h_assetloc" type="hidden" name="v_h_assetloc" />
            </div>
          </div>
          <!-- <div class="form-group row">
                        <label for="assettype" class="col-md-5 col-form-label text-md-left">Process / Technology</label>
                        <div class="col-md-7">
                            <input id="assettype" type="text" class="form-control" name="assettype" autocomplete="off" autofocus readonly/>
                        </div>
                    </div> -->
          <div class="form-group row col-md-12">
            <label for="v_srnote" class="col-md-5 col-form-label text-md-left">SR Note</label>
            <div class="col-md-7">
              <textarea id="v_srnote" type="text" class="form-control" name="v_srnote" maxlength="250" autocomplete="off" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="file" class="col-md-5 col-form-label text-md-left">Current File</label>
            <div class="col-md-7">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="v_listupload">

                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_wotype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
            <div class="col-md-7">
              <input id="v_wotype" type="text" class="form-control" name="v_wotype" autocomplete="off" readonly />
              <!-- <select class="form-control wotype" name="v_wotype" id="v_wotype">
                <option value="">Select Failure Type</option>
                @foreach($wotypes as $wotype)
                <option value="{{$wotype->wotyp_code}}">{{$wotype->wotyp_code}} - {{$wotype->wotyp_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_fclist" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7">
              <textarea id="v_fclist" type="text" class="form-control" name="v_fclist" rows="3" readonly></textarea>
              <!-- <select class="form-control fclist" name="v_fclist[]" id="v_fclist" multiple="multiple">
              </select> -->
            </div>
          </div>

          <input type="hidden" id="hide_editassetgroup" />
          <div class="form-group row col-md-12">
            <label for="v_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <textarea id="v_impact" type="text" class="form-control" name="v_impact" autocomplete="off" rows="3" readonly></textarea>
              <!-- <select class="form-control v_impact" name="v_impact[]" id="v_impact" multiple="multiple">
                <option value=""></option>
                @foreach($impacts as $impact)
                <option value="{{$impact->imp_code}}">{{$impact->imp_code}} - {{$impact->imp_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="v_priority" type="text" name="v_priority" class="form-control" readonly>
              <!-- <select class="form-control v_priority" name="v_priority" id="v_priority">
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_enjiners" class="col-md-5 col-form-label text-md-left">Engineer (Max. 5) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <textarea id="v_enjiners" type="text" class="form-control" name="v_enjiners" autocomplete="off" rows="3" readonly></textarea>
              <!-- <select id="v_enjiners" name="v_enjiners[]" class="form-control" multiple="multiple" required>
                <option value="">--Select Engineer--</option>
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_scheduledate" class="col-md-5 col-form-label text-md-left">Start Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              {{-- <input id="scheduledate" type="date" class="form-control" name="scheduledate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('scheduledate') }}"> --}}
              <input id="v_scheduledate" type="date" class="form-control" name="v_scheduledate" placeholder="yy-mm-dd" autocomplete="off" autofocus required value="{{ old('scheduledate') }}" readonly>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              {{-- <input id="duedate" type="date" class="form-control" name="duedate" placeholder="yy-mm-dd"  autocomplete="off" min="{{Carbon\Carbon::now()->format("Y-m-d")}}" autofocus required value="{{ old('duedate') }}"> --}}
              <input id="v_duedate" type="date" class="form-control" name="v_duedate" placeholder="yy-mm-dd" autocomplete="off" autofocus required value="{{ old('duedate') }}" readonly>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_wonote" class="col-md-5 col-form-label text-md-left">Note for Work Order</label>
            <div class="col-md-7">
              <textarea id="v_wonote" type="text" class="form-control" name="v_wonote" maxlength="250" autocomplete="off" readonly></textarea>
              <!-- <span id="alert3" style="color: red; font-weight: 200;"></span> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_mtcode" class="col-md-5 col-form-label text-md-left">Maintenance Code</label>
            <div class="col-md-7">
              <input id="v_mtcode" type="text" name="v_mtcode" class="form-control" readonly>
              <!-- <select id="v_mtcode" name="v_mtcode" class="form-control">
                <option></option>
                @foreach($maintenancelist as $mt)
                <option value="{{$mt->pmc_code}}">{{$mt->pmc_code}} -- {{$mt->pmc_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_inslist" class="col-md-5 col-form-label text-md-left">Instruction List</label>
            <div class="col-md-7">
              <input id="v_inslist" type="text" name="v_inslist" class="form-control" readonly>
              <!-- <select id="v_inslist" name="v_inslist" class="form-control">
                <option></option>
                @foreach ($inslist as $ins)
                <option value="{{$ins->ins_code}}">{{$ins->ins_code}} -- {{$ins->ins_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_splist" class="col-md-5 col-form-label text-md-left">Instruction Spare Part</label>
            <div class="col-md-7">
              <input id="v_splist" type="text" name="v_splist" class="form-control" readonly>
              <!-- <select id="v_splist" name="v_splist" class="form-control">
                <option></option>
                @foreach ($splist as $sp)
                <option value="{{$sp->spg_code}}">{{$sp->spg_code}} -- {{$sp->spg_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_qclist" class="col-md-5 col-form-label text-md-left">Instruction QC</label>
            <div class="col-md-7">
              <input id="v_qclist" type="text" name="v_qclist" class="form-control" readonly>
              <!-- <select id="v_qclist" name="v_qclist" class="form-control">
                <option></option>
                @foreach ($qclist as $qc)
                <option value="{{$qc->qcs_code}}">{{$qc->qcs_code}} -- {{$qc->qcs_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <!-- <div class="form-group row col-md-12">
            <label for="v_rejectreason" class="col-md-5 col-form-label text-md-left">Reason</label>
            <div class="col-md-7">
              <textarea id="v_rejectreason" type="text" class="form-control" name="v_rejectreason" maxlength="250" autocomplete="off" autofocus readonly></textarea>
              <span id="alert3" style="color: red; font-weight: 200;"></span>
            </div>
          </div> -->

          <!-- <input type="hidden" id="tmpfail1" name="tmpfail1" value="">
          <input type="hidden" id="impactcode1" name="impactcode1" value="">
          <input type="hidden" id="tmpfail2" name="tmpfail2" value="">
          <input type="hidden" id="tmpfail3" name="tmpfail3" value="">
          <input type="hidden" id="hiddendeptcode" name="hiddendeptcode" /> -->
          <!-- <input type="hidden" id="hiddenreqby" name="hiddenreqby" /> -->

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <!-- <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
            <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button> -->
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">
  $("#approvaleng").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });

  $(document).ready(function() {
    $("#enjiner1").select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    $("#enjiner2").select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    $("#enjiner3").select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    // $("#s_asset").select2({
    //   width: '100%',
    //   // placeholder : "Select Asset",
    //   theme: 'bootstrap4',
    // });

    // $("#s_servicenbr").select2({
    //   width: '100%',
    //   // placeholder : "Select Asset",
    //   theme: 'bootstrap4',
    // });

    $(".select2bs4").select2({
      width: '100%',
      theme: 'bootstrap4',
    });


    $("#enjiners").select2({
      width: '100%',
      placeholder: "Select Engineer",
      maximumSelectionLength: 5,
      closeOnSelect: false,
      allowClear: true,
      multiple: true,
      // theme : 'bootstrap4'
    });

    $("#repaircode").select2({
      width: '100%',
      placeholder: "Select Repair Code",
      maximumSelectionLength: 3,
      closeOnSelect: false,
      allowClear: true,
      // theme : 'bootstrap4'
    });

    $("#c_mtcode").select2({
      width: '100%',
      placeholder: "Select Maintenance Code",
      allowClear: true,
    });

    $("#c_inslist").select2({
      width: '100%',
      placeholder: "Select Instruction List Code",
      allowClear: true,
    });

    $("#c_splist").select2({
      width: '100%',
      placeholder: "Select Spare Part List Code",
      allowClear: true,
    });

    $("#c_qclist").select2({
      width: '100%',
      placeholder: "Select QC List Code",
      allowClear: true,
    });

    $("#repgroup").select2({
      width: '100%',
      placeholder: 'Select Repair Group',
      allowClear: true,
      // theme : 'bootstrap4',
    });

    $('#impact').select2({
      width: '100%',
      placeholder: "Select Value",
      theme: "bootstrap4",
      allowClear: true,
      closeOnSelect: false,
      allowClear: true,
      multiple: true,
    });

    $("#fclist").select2({
      width: '100%',
      placeholder: "Select Failure Code",
      theme: "bootstrap4",
      allowClear: true,
      maximumSelectionLength: 5,
      closeOnSelect: false,
      allowClear: true,
      multiple: true,
    });

    $("#wotype").select2({
      width: '100%',
      // theme : 'bootstrap4',
      allowClear: true,
      placeholder: 'Select Failure Type',

    });

    $(document).on('change', '#rad_repgroup1', function(e) {
      document.getElementById('tampilanrepgroup').style.display = '';
      document.getElementById('repgroup').value = null;
      document.getElementById('tampilanrepcode').style.display = 'none';
      document.getElementById('repaircode').value = null;
    });
    $(document).on('change', '#rad_repgroup2', function(e) {
      document.getElementById('tampilanrepcode').style.display = '';
      document.getElementById('repaircode').value = null;
      document.getElementById('tampilanrepgroup').style.display = 'none';
      document.getElementById('repgroup').value = null;
    });

    // DISABLE BUTTON APPROVE
    // $(document).on('keyup', '#rejectreason', function(e) {
    //   var inputreject = document.getElementById('rejectreason');
    //   var btnreject = document.getElementById('btnreject');
    //   var btnapprove = document.getElementById('btnapprove');
    //   // console.log(inputreject.value.length);
    //   if (inputreject.value.length > 0) {
    //     btnreject.disabled = false;
    //     btnapprove.disabled = true;
    //   } else {
    //     btnreject.disabled = true;
    //     btnapprove.disabled = false;
    //   }
    // })

    $(document).on('click', '#btnreject', function(event) {
      var rejectreason = document.getElementById('rejectreason').value;

      if (rejectreason == "") {
        // alert('masuk reject');
        $("#priority").attr('required', false);
        $("#enjiners").attr('required', false);
        $("#scheduledate").attr('required', false);
        $("#duedate").attr('required', false);
        $("#rejectreason").attr('required', true);
      }

    });

    $(document).on('click', '#btnapprove', function(event) {
      var priority = document.getElementById('priority').value;
      var enjiners = document.getElementById('enjiners').value;
      var scheduledate = document.getElementById('scheduledate').value;
      var duedate = document.getElementById('duedate').value;

      if (priority == "" || enjiners == "" || scheduledate == "" || duedate == "") {
        $("#priority").attr('required', true);
        $("#enjiners").attr('required', true);
        $("#scheduledate").attr('required', true);
        $("#duedate").attr('required', true);
        $("#rejectreason").attr('required', false);
      }

    });


    function fetch_data(page, srnumber, asset, priority, status) {
      $.ajax({
        url: "/srapproval/searchapprovaleng?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + "&priority=" + priority + "&status=" + status,
        success: function(data) {
          // console.log(data);
          $('tbody').html('');
          $('tbody').html(data);
        }
      })
    }


    $(document).on('click', '#btnsearch', function() {
      var srnumber = $('#s_servicenbr').val();
      var asset = $('#s_asset').val();
      var priority = $('#s_priority').val();
      var status = $('#s_status').val();
      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      document.getElementById('tmpstatus').value = status;

      fetch_data(page, srnumber, asset, priority, status);
    });


    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var srnumber = $('#tmpsrnumber').val();
      var asset = $('#tmpasset').val();
      var priority = $('#tmppriority').val();
      var status = $('#tmpstatus').val();

      fetch_data(page, srnumber, asset, priority, status);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber = '';
      var asset = '';
      var priority = '';
      var status = '';
      var page = 1;

      document.getElementById('s_servicenbr').value = '';
      document.getElementById('s_asset').value = '';
      document.getElementById('s_priority').value = '';
      document.getElementById('s_status').value = '';
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      document.getElementById('tmpstatus').value = status;

      fetch_data(page, srnumber, asset, priority, status);

      // $("#s_asset").select2({
      //   width: '100%',
      //   // placeholder : "Select Asset",
      //   theme: 'bootstrap4',
      //   asset,
      // });

      // $("#s_servicenbr").select2({
      //   width: '100%',
      //   // placeholder : "Select Asset",
      //   theme: 'bootstrap4',
      //   asset,
      // });
    });

    $(document).on('click', '.approvaleng', function() {
      $('#viewModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var srdate = $(this).data('srdate');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var dept = $(this).data('deptdesc');
      var deptcode = $(this).data('deptcode');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypedescx');
      var impact = $(this).data('impactcode');
      var failcode = $(this).data('failcode');
      // alert(impact);
      var assetloc = $(this).data('assetloc');
      var hassetsite = $(this).data('hassetsite');
      var hassetloc = $(this).data('hassetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');
      var id = $(this).data('idsr');

      // array failurecode
      var newarrfc = [];
      var desc = failcode.split(",");
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrfc.push(desc[i]);
            // console.log(newarrfc);
          }
        }
      }

      // array impact
      var newarrimp = [];
      var desc = impact.split(",");
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrimp.push(desc[i]);
          }
        }
      }

      $.ajax({
        url: "/listuploadview/" + srnumber,
        success: function(data) {
          // console.log(data);
          $('#listupload').html('').append(data);
        }
      })

      // alert(impactcode1);
      document.getElementById('idsr').value = id;
      document.getElementById('srnumber').value = srnumber;
      document.getElementById('srdate').value = srdate;
      document.getElementById('assetcode').value = assetcode;
      document.getElementById('assetdesc').value = assetdesc;
      // console.log(document.getElementById('idsr').value);
      {
        {
          // --document.getElementById('assettype').value = astype;
          // --
        }
      }
      document.getElementById('wotype').value = wotype;
      document.getElementById('impactcode1').value = impactcode1;
      document.getElementById('assetloc').value = assetloc;
      document.getElementById('h_assetsite').value = hassetsite;
      document.getElementById('h_assetloc').value = hassetloc;
      document.getElementById('srnote').value = srnote;
      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('priority').value = priority;
      document.getElementById('dept').value = dept;
      document.getElementById('hiddendeptcode').value = deptcode;
      document.getElementById('reqbyname').value = reqbyname;

      //value multiple failurecode
      document.getElementById('fclist').selectedIndex = newarrfc;
      $('#fclist').val(newarrfc);
      $('#fclist').trigger('change');

      //value multiple impact
      document.getElementById('impact').selectedIndex = newarrimp;
      $('#impact').val(newarrimp);
      $('#impact').trigger('change');

      // document.getElementById('tmpfail1').value = failcode1;
      // document.getElementById('tmpfail2').value = failcode2;
      // document.getElementById('tmpfail3').value = failcode3;

      $(document).on('change', '#wotype', function() {
        // console.log('masuk');
        var getAssetG = document.getElementById('hide_editassetgroup').value;
        var getType = $(this).val();

        // console.log(getAssetG);
        // console.log(getType);
        $.ajax({
          url: "/srcheckfailurecodetype",
          data: {
            group: getAssetG,
            type: getType,

          },
          success: function(data) {
            var code = data.optionfailcode;

            // console.log(code);

            var selectthis = document.getElementById('fclist');

            // Hapus semua option yang ada
            selectthis.innerHTML = '';

            // Tambahkan option baru
            code.forEach(data => {
              const option = document.createElement('option');
              option.value = data.fn_code;
              option.text = data.fn_code + ' - ' + data.fn_desc;
              selectthis.add(option);
            });
          }
        })
      });

      $('#c_mtcode').on('change', function() {
        // alert('ganti');
        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchic',
          method: 'GET',
          data: {
            pmc_code: selectedValue
          },
          success: function(response) {
            // Manipulasi data di sini
            // console.log(response);

            //jika response tidak kosong
            if (response && Object.keys(response).length) {
              let inslistval = response.pmc_ins;
              let spglistval = response.pmc_spg;
              let qcslistval = response.pmc_qcs;

              $('#c_inslist option[value !="' + inslistval + '"]').prop('disabled', true);
              $('#c_inslist option[value="' + inslistval + '"]').prop('disabled', false);
              $('#c_inslist').val(inslistval).trigger('change');

              $('#c_splist option[value !="' + spglistval + '"]').prop('disabled', true);
              $('#c_splist option[value="' + spglistval + '"]').prop('disabled', false);
              $('#c_splist').val(spglistval).trigger('change');

              $('#c_qclist option[value !="' + qcslistval + '"]').prop('disabled', true);
              $('#c_qclist option[value="' + qcslistval + '"]').prop('disabled', false);
              $('#c_qclist').val(qcslistval).trigger('change');

              $("#c_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: false,
              });

              $("#c_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: false,
              });

              $("#c_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: false,
              });

            } else { //jika response kosong karena user click tanda "x" di field select maintenance code
              $('#c_inslist option[value!=""]').prop('disabled', false);
              $('#c_inslist').val('').trigger('change');

              $('#c_splist option').prop('disabled', false);
              $('#c_splist').val('').trigger('change');

              $('#c_qclist option').prop('disabled', false);
              $('#c_qclist').val('').trigger('change');

              $("#c_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: true,
              });

              $("#c_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: true,
              });

              $("#c_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: true,
              });
            }

          },
          error: function(xhr, status, error) {
            // console.error(error);
          }
        });
      });

      $("#scheduledate").change(function() {
        var start_date = new Date($("#scheduledate").val());
        var due_date = new Date($("#duedate").val());
        var today = new Date();
        var min_date = start_date.toJSON().slice(0, 10);


        $("#duedate").prop("min", min_date);


        if (start_date > due_date) {
          $("#duedate").val($("#scheduledate").val());
        }
      });

      $('#wotype').select2({
        theme: 'bootstrap4',
        width: '100%',
        // wotype,
      });

      $('#fclist').select2({
        width: '100%',
        placeholder: "Select Failure Code",
        theme: "bootstrap4",
        allowClear: true,
        maximumSelectionLength: 5,
        closeOnSelect: false,
        allowClear: true,
        multiple: true,
      });

      $('#impact').select2({
        width: '100%',
        placeholder: "Select Value",
        theme: "bootstrap4",
        allowClear: true,
        closeOnSelect: false,
        allowClear: true,
        multiple: true,
      });

    });

    $(document).on('click', '.viewapprovaleng', function() {
      $('#viewApprModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var srdate = $(this).data('srdate');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var dept = $(this).data('deptdesc');
      var deptcode = $(this).data('deptcode');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypedescx');
      var impact = $(this).data('impactcode');
      var failcode = $(this).data('failcode');
      var assetloc = $(this).data('assetloc');
      var hassetsite = $(this).data('hassetsite');
      var hassetloc = $(this).data('hassetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');
      var id = $(this).data('idsr');
      var status = $(this).data('status');
      var reason = $(this).data('reason');
      var wonote = $(this).data('wonote');
      var engineer = $(this).data('engineer');
      var wostart = $(this).data('wostart');
      var wodue = $(this).data('wodue');
      var womtc = $(this).data('womtc');
      var woinsc = $(this).data('woinsc');
      var wospc = $(this).data('wospc');
      var woqcs = $(this).data('woqcs');

      $.ajax({
        url: "/searchimpactdesc",
        data: {
          impact: impact,
        },
        success: function(data) {
          // console.log(data);

          var imp_desc = data;
          var imp_code = impact;
          var delimiter = ",";

          var desc = imp_desc.split(delimiter);
          var coded = imp_code.split(delimiter);

          let results = "";

          for (let i = 0; i < Math.min(desc.length, coded.length); i++) {
            results += coded[i] + ' -- ' + desc[i] + '\n';
          }

          document.getElementById('v_impact').value = results;

          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('v_impact').value = "";
          }
        }
      })

      $.ajax({
        url: "/searchfailcode",
        data: {
          failcode: failcode,
        },
        success: function(data) {
          // console.log(data);

          var fail_desc = data;
          var fail_code = failcode;
          var delimiter = ",";

          var desc = fail_desc.split(delimiter);
          var coded = fail_code.split(delimiter);

          let results = "";

          for (let i = 0; i < Math.min(desc.length, coded.length); i++) {
            results += coded[i] + ' -- ' + desc[i] + '\n';
          }

          document.getElementById('v_fclist').value = results;

          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('v_fclist').value = "";
          }
        }
      })

      $.ajax({
        url: "/searchfailtype",
        data: {
          failtype: wotype,
        },
        success: function(data) {

          document.getElementById('v_wotype').value = wotype + ' -- ' + data;
          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('v_wotype').value = "";
          }
        }
      })

      $.ajax({
        url: "/listuploadview/" + srnumber,
        success: function(data) {
          // console.log(data);
          $('#v_listupload').html('').append(data);
        }
      })

      var newarrfc = [];
      var desc = engineer.split(";");
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrfc.push(desc[i]) + '\n';
          }
        }
      }

      if (wostart != '01-01-1970') {
        document.getElementById('v_scheduledate').value = wostart;
      } else {
        document.getElementById('v_scheduledate').value = '';
      }

      if (wodue != '01-01-1970') {
        document.getElementById('v_duedate').value = wodue;
      } else {
        document.getElementById('v_duedate').value = '';
      }

      document.getElementById('v_enjiners').value = newarrfc.join('\n');
      document.getElementById('v_idsr').value = id;
      document.getElementById('v_srnumber').value = srnumber;
      document.getElementById('v_srdate').value = srdate;
      document.getElementById('v_assetcode').value = assetcode;
      document.getElementById('v_assetdesc').value = assetdesc;
      // console.log(document.getElementById('idsr').value);
      {
        {
          // --document.getElementById('assettype').value = astype;
          // --
        }
      }
      document.getElementById('v_wotype').value = wotype;
      document.getElementById('impactcode1').value = impactcode1;
      document.getElementById('v_assetloc').value = assetloc;
      document.getElementById('v_h_assetsite').value = hassetsite;
      document.getElementById('v_h_assetloc').value = hassetloc;
      document.getElementById('v_srnote').value = srnote;
      document.getElementById('v_hiddenreq').value = reqby;
      document.getElementById('v_priority').value = priority;
      document.getElementById('v_dept').value = dept;
      // document.getElementById('v_hiddendeptcode').value = deptcode;
      document.getElementById('v_reqbyname').value = reqbyname;
      document.getElementById('v_status').value = status;
      document.getElementById('v_reason').value = reason;
      document.getElementById('v_wonote').value = wonote;
      document.getElementById('v_mtcode').value = womtc;
      document.getElementById('v_inslist').value = woinsc;
      document.getElementById('v_splist').value = wospc;
      document.getElementById('v_qclist').value = woqcs;

      if (status == 'Revision from engineer approval') {
        document.getElementById("v_status").style.color = 'red';
        document.getElementById("v_status").value = 'Rejected';
      } else if (status == 'Waiting for engineer approval') {
        document.getElementById("v_status").value = 'Waiting for approval';
      }else{
        document.getElementById("v_status").value = 'Approved';

      }

      $(document).on('change', '#wotype', function() {
        // console.log('masuk');
        var getAssetG = document.getElementById('hide_editassetgroup').value;
        var getType = $(this).val();

        // console.log(getAssetG);
        // console.log(getType);
        $.ajax({
          url: "/srcheckfailurecodetype",
          data: {
            group: getAssetG,
            type: getType,

          },
          success: function(data) {
            var code = data.optionfailcode;

            // console.log(code);

            var selectthis = document.getElementById('fclist');

            // Hapus semua option yang ada
            selectthis.innerHTML = '';

            // Tambahkan option baru
            code.forEach(data => {
              const option = document.createElement('option');
              option.value = data.fn_code;
              option.text = data.fn_code + ' - ' + data.fn_desc;
              selectthis.add(option);
            });
          }
        })
      });

      $('#c_mtcode').on('change', function() {
        // alert('ganti');
        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchic',
          method: 'GET',
          data: {
            pmc_code: selectedValue
          },
          success: function(response) {
            // Manipulasi data di sini
            // console.log(response);

            //jika response tidak kosong
            if (response && Object.keys(response).length) {
              let inslistval = response.pmc_ins;
              let spglistval = response.pmc_spg;
              let qcslistval = response.pmc_qcs;

              $('#c_inslist option[value !="' + inslistval + '"]').prop('disabled', true);
              $('#c_inslist option[value="' + inslistval + '"]').prop('disabled', false);
              $('#c_inslist').val(inslistval).trigger('change');

              $('#c_splist option[value !="' + spglistval + '"]').prop('disabled', true);
              $('#c_splist option[value="' + spglistval + '"]').prop('disabled', false);
              $('#c_splist').val(spglistval).trigger('change');

              $('#c_qclist option[value !="' + qcslistval + '"]').prop('disabled', true);
              $('#c_qclist option[value="' + qcslistval + '"]').prop('disabled', false);
              $('#c_qclist').val(qcslistval).trigger('change');

              $("#c_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: false,
              });

              $("#c_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: false,
              });

              $("#c_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: false,
              });

            } else { //jika response kosong karena user click tanda "x" di field select maintenance code
              $('#c_inslist option[value!=""]').prop('disabled', false);
              $('#c_inslist').val('').trigger('change');

              $('#c_splist option').prop('disabled', false);
              $('#c_splist').val('').trigger('change');

              $('#c_qclist option').prop('disabled', false);
              $('#c_qclist').val('').trigger('change');

              $("#c_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: true,
              });

              $("#c_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: true,
              });

              $("#c_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: true,
              });
            }

          },
          error: function(xhr, status, error) {
            // console.error(error);
          }
        });
      });

      $("#scheduledate").change(function() {
        var start_date = new Date($("#scheduledate").val());
        var due_date = new Date($("#duedate").val());
        var today = new Date();
        var min_date = start_date.toJSON().slice(0, 10);


        $("#duedate").prop("min", min_date);


        if (start_date > due_date) {
          $("#duedate").val($("#scheduledate").val());
        }
      });

      $('#wotype').select2({
        theme: 'bootstrap4',
        width: '100%',
        // wotype,
      });

      $('#fclist').select2({
        width: '100%',
        placeholder: "Select Failure Code",
        theme: "bootstrap4",
        allowClear: true,
        maximumSelectionLength: 5,
        closeOnSelect: false,
        allowClear: true,
        multiple: true,
      });

      $('#impact').select2({
        width: '100%',
        placeholder: "Select Value",
        theme: "bootstrap4",
        allowClear: true,
        closeOnSelect: false,
        allowClear: true,
        multiple: true,
      });

    });


    function ambilenjiner() {
      // alert('ketrigger');
      $.ajax({
        url: "/engineersearch",
        success: function(data) {

          // console.log(data);
          var jmldata = data.length;

          var eng_code = [];
          var eng_desc = [];
          var test = [];


          for (i = 0; i < jmldata; i++) {
            eng_code.push(data[i].eng_code);
            eng_desc.push(data[i].eng_desc);

            test += '<option value=' + eng_code[i] + '>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
          }

          // console.log(test);

          // $('#btnsubmit').prop('disabled', false);
          // document.getElementById('btnsubmit').style.display = '';

          // alert('row exists');
          // test();

          // $('#enjiner1').html('').append(test);
          // $('#enjiner2').html('').append(test);
          // $('#enjiner3').html('').append(test);
          // $('#enjiner4').html('').append(test);
          // $('#enjiner5').html('').append(test);
          $('#enjiners').html('').append(test);


          // console.log(globalasset);

        }

      })
    }

    ambilenjiner();



  });
</script>
@endsection