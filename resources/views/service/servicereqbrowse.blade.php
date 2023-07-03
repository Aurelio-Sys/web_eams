@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">Service Request Maintenance</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan view detail maupun status approval, edit, dan cancel pada Service Request</p>
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

    /* .modal-dialog {
      overflow-x: initial !important
    } */

    /* .modal-body {
      height: calc(100vh - 5em);
      overflow-x: auto;
    } */
  }
</style>
<!-- Daftar Perubahan 
  A211015 : Merubah view SR 
-->
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
        </div>
        <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Asset Description') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <!-- <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
                  <option value="">--Select Asset--</option>
                  @foreach($asset as $show)
                  <option value="{{$show->asset_desc}}">{{$show->asset_code}} -- {{$show->asset_desc}}</option>
                  @endforeach
                </select> -->
          <input id="s_asset" type="text" class="form-control" name="s_asset" value="" autofocus autocomplete="off" placeholder="Search Asset Desc">
        </div>
      </div>
      <div class="col-12 form-group row">
        <label for="s_status" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Status') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_status" name="s_status" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Status--</option>
            @if($fromhome == 'open')
            <option value="Open" selected>Open</option>
            @else
            <option value="Open">Open</option>
            @endif
            <option value="Revise">Revise</option>
            <option value="Inprocess">Inprocess</option>
            <option value="Canceled">Canceled</option>
            <option value="Acceptance">Acceptance</option>
            <option value="Closed">Closed</option>
          </select>
        </div>
        <!-- <label for="s_priority" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Priority') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_priority" name="s_priority" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Priority--</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div> -->
        <!-- <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('SR Period') }}</label>
              <div class="col-md-3 col-sm-4 mb-2 input-group">
                <select id="s_period" name="s_period" class="form-control" value="" autofocus autocomplete="off">
                  <option value="">--Select Period--</option>
                  <option value="1"> < 3 days </option>
                  <option value="2"> 3-5 days </option>
                  <option value="3"> > 5 days </option>
                </select>
              </div> -->
        <label for="s_user" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Requested by') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_user" name="s_user" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select User--</option>
            @foreach($users as $usershow)
            <option value="{{$usershow->username}}">{{$usershow->username}} - {{$usershow->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-12 form-group row">
        <label for="s_datefrom" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Date from') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <input type="text" id="s_datefrom" class="form-control" name='s_datefrom' placeholder="YYYY-MM-DD" required autofocus autocomplete="off">
        </div>
        <!-- <label for="s_priority" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Priority') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_priority" name="s_priority" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Priority--</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div> -->
        <!-- <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('SR Period') }}</label>
              <div class="col-md-3 col-sm-4 mb-2 input-group">
                <select id="s_period" name="s_period" class="form-control" value="" autofocus autocomplete="off">
                  <option value="">--Select Period--</option>
                  <option value="1"> < 3 days </option>
                  <option value="2"> 3-5 days </option>
                  <option value="3"> > 5 days </option>
                </select>
              </div> -->
        <label for="s_dateto" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Date to') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <input type="text" id="s_dateto" class="form-control" name='s_dateto' placeholder="YYYY-MM-DD" required autofocus autocomplete="off">
        </div>
      </div>
      <div class="col-12 form-group row">
        <!-- <label for="s_status" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Status') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_status" name="s_status" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Status--</option>
            @if($fromhome == 'open')
            <option value="1" selected>Open</option>
            @else
            <option value="1">Open</option>
            @endif
            <option value="2">Assigned</option>
            <option value="3">Started</option>
            <option value="4">Finish</option>
            <option value="5">Closed</option>
            <option value="6">Incomplete</option>
            <option value="7">Completed</option>
            <option value="8">Reprocess</option>
          </select>
        </div> -->
        <div class="col-md-6 col-sm-4 mb-2 input-group">
          <input type="button" class="btn btn-primary col-md-3" id="btnsearch" value="Search" style="float:right" />
          &nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-primary col-md-2" id="btnrefresh"><i class="fas fa-redo-alt"></i></button>
          &nbsp;&nbsp;&nbsp;
          <input type="button" class="btn btn-primary col-md-4" id="btnexcel" value="Export to Excel" style="float:right" />
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="tmpsrnumber" />
<input type="hidden" id="tmpasset" />
<input type="hidden" id="tmppriority" />
<input type="hidden" id="tmpperiod" />
<input type="hidden" id="tmpuser" />
<input type="hidden" id="tmpdatefrom" />
<input type="hidden" id="tmpdateto" />
@if($fromhome == 'open')
<input type="hidden" id="tmpstatus" value="Open" />
@else
<input type="hidden" id="tmpstatus" />
@endif

<!-- table SR -->
<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th>SR Number</th>
        <!-- <th>WO Number</th> -->
        <th>Asset</th>
        <th>Asset Description</th>
        <!-- <th>Location</th> -->
        <th>Status</th>
        <!-- <th>Priority</th> -->
        <!-- <th>Department</th> -->
        <th>Req by</th>
        <th>Req Date</th>
        <th>Req Time</th>
        <th>Action</th>
        <th>Approval</th>
        <!-- <th>Cancel</th> -->
      </tr>
    </thead>
    <tbody>
      @include('service.table-srbrowse')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!--Modal Edit-->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="statusedit">
      <form class="form-horizontal" id="newedit" method="post" action="editsr" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="counter" value=0>
        <input type="hidden" id="counterfail" value=0>
        <input type="hidden" id="repairtypeedit">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="e_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
              <input id="e_nosr" type="text" class="form-control" name="e_nosr" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" style="display: none;">
            <label for="e_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="e_nowo" type="text" class="form-control" name="e_nowo" autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_req" class="col-md-5 col-form-label text-md-left">Request By</label>
            <div class="col-md-7">
              <input id="e_req" type="text" class="form-control" name="e_req" autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input id="e_dept" type="text" class="form-control" name="e_dept" autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_status" class="col-md-5 col-form-label text-md-left">Status</label>
            <div class="col-md-7">
              <input id="e_status" type="text" class="form-control" name="e_status" autocomplete="off" maxlength="6" readonly style="color:green;font-weight:bold">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_reason" class="col-md-5 col-form-label text-md-left">Approval Reason</label>
            <div class="col-md-7">
              <textarea id="e_reason" type="text" class="form-control" name="e_reason" autocomplete="off" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <!-- <input id="e_asset" type="text" class="form-control e_asset"> -->
              <input id="e_assethid" type="hidden" class="form-control e_asset" name="e_asset" readonly>
              <input id="e_asset" type="text" class="form-control" name="e_asset" autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_wottype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
            <div class="col-md-7">
              <!-- <input id="e_wottype" type="text" class="form-control" name="e_wottype" autocomplete="off" maxlength="6" readonly> -->
              <select id="e_wottype" name="e_wottype" class="form-control e_wottype">
                <option value="">-- Select Failure Type --</option>
                @foreach($wotype as $show)
                <option value="{{$show->wotyp_code}}">{{$show->wotyp_code}} -- {{$show->wotyp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_failurecode" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7 col-sm-12">
              <select class="form-control" id="e_failurecode" name="e_failurecode[]" multiple="multiple">
                <option></option>
                @foreach($fcode as $fcshow)
                <option value="{{$fcshow->fn_code}}">{{$fcshow->fn_code}} -- {{$fcshow->fn_desc}} -- {{$fcshow->fn_impact}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center e_impactdiv" id="e_impactdiv">
            <label for="e_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <select id="e_impact" class="form-control e_impact" name="e_impact[]" multiple="multiple">
                @foreach($impact as $impactshow)
                <option value="{{$impactshow->imp_code}}">{{$impactshow->imp_code}} -- {{$impactshow->imp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <select id="e_priority" class="form-control" name="e_priority" autofocus>
                <option value="">-- Select Priority --</option>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_note" class="col-md-5 col-form-label text-md-left">SR Note</label>
            <div class="col-md-7">
              <!-- <input id="e_note" type="text" class="form-control" name="e_note" autocomplete="off" maxlength="6"> -->
              <textarea id="e_note" class="form-control e_note" name="e_note" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_date" class="col-md-5 col-form-label text-md-left">Request Date</label>
            <div class="col-md-7">
              <input type="date" class="form-control" id="e_date" name="e_date">
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_time" class="col-md-5 col-form-label text-md-left">Request Time</label>
            <div class="col-md-7">
              <input type="time" class="form-control" id="e_time" name="e_time">
            </div>
          </div>
          <div class="form-group row">
            <label for="file" class="col-md-5 col-form-label text-md-left">Current File</label>
            <div class="col-md-7">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="elistupload">

                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group row">
            <label for="file" class="col-md-5 col-form-label text-md-left">Upload New File</label>
            <div class="col-md-7 input-file-container">
              <input type="file" class="form-control" id="filename" name="filename[]" multiple>
            </div>
          </div>
          <div class="form-group row">
            <label for="e_approver" class="col-md-5 col-form-label text-md-left">Engineer Approver</label>
            <div class="col-md-7">
              <select id="e_approver" name="e_approver" class="form-control" required>
                <option value="">-- Select Eng Approver --</option>
                @foreach($dataapp as $da)
                <option value="{{$da->eng_dept}}">{{$da->eng_dept.' -- '.$da->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-danger bt-action mr-auto e_btnadd" id="e_addeng">Add Engineer</button>
          <button type="button" class="btn btn-warning bt-action mr-auto e_btnaddfai" id="e_addfai" style="display:none"><b>Add Failure Code</b></button> -->
          <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success bt-action" id="e_btnconf" disabled>Save</button>
          <button type="button" class="btn btn-block btn-info" id="e_btnloading" style="display:none">
            <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>

<!-- Modal Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Cancel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- <form id="close" class="form-horizontal" method="POST" action="#"> -->
      <input type="hidden" id="statuscancel">
      <form class="form-horizontal" id="newcancel" method="post" action="cancelsr" enctype="multipart/form-data">
        {{csrf_field()}}

        <div style="display: none;">
          <label for="c_srnumber" class="col-md-4 col-form-label text-md-right">{{ __('SR Number') }}</label>
          <div class="col-md-7">
            <input id="c_srnumber" type="text" class="form-control" name="c_srnumber" value="" readonly>
          </div>
        </div>

        <div class="modal-body">
          <span class="col-md-12"><b>Are you sure want to cancel <span id="srnbr"><b></b></span>
              ?</b></span>
          <!-- <div class="form-group row" id="divnotecancel"> -->
          <label class="col-md-12 col-form-label">If you are sure, please fill the cancelation reason <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
          <textarea class="form-control" id="c_reason" name="c_reason" autofocus maxlength="150" required></textarea>
          <!-- </div> -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="c_btnclose" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-success bt-action" id="c_btnconf">Yes</button>
          <button type="button" class="btn bt-action" id="c_btnloading" style="display: none;">
            <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;Loading
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Route -->
<div class="modal fade" id="routeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Approval Route Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group row">
            <label for="ppnumber" class="col-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-sm-center">{{
                            __('SR No.')
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
            <h6 style="margin-top: 10px;font-size: 18px;font-weight:bold">Department approval</h6>
            <table id='routetable' class='table table-bordered route-list' style="margin-bottom: 0px;">
              <thead class="thead-light">
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:5%">Department</th>
                  <th style="width:10%">Role</th>
                  <th style="width:15%">Reason</th>
                  <th style="width:15%">Status</th>
                  <th style="width:10%">Approved By</th>
                  <th style="width:15%">Timestamp</th>
                </tr>
              </thead>
              <tbody id='bodyroute'>

              </tbody>
            </table>
            <h6 style="margin-top: 20px;font-size: 18px;font-weight:bold">Engineer approval</h6>
            <table id='routetablex' class='table table-bordered route-list' style="margin-bottom: 0px;">
              <thead class="thead-light">
                <tr>
                  <th style="width:5%">No.</th>
                  <th style="width:5%">Department</th>
                  <th style="width:10%">Role</th>
                  <th style="width:15%">Reason</th>
                  <th style="width:15%">Status</th>
                  <th style="width:10%">Approved By</th>
                  <th style="width:15%">Timestamp</th>
                </tr>
              </thead>
              <tbody id='bodyroutex'>

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

<!-- Modal SR View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hiddenreq" name="hiddenreq" />
        <div class="form-group row">
          <label for="srnumber" class="col-md-2 col-form-label">SR Number</label>
          <div class="col-md-4">
            <input id="srnumber" type="text" class="form-control" name="srnumber" readonly />
          </div>
          <label for="assetcode" class="col-md-2 col-form-label">Asset Code</label>
          <div class="col-md-4">
            <input id="assetcode" type="text" class="form-control" name="assetcode" readonly />
          </div>
        </div>
        <div class="form-group row">
          <label for="wonumber" class="col-md-2 col-form-label">WO Number</label>
          <div class="col-md-4">
            <input id="wonumber" type="text" class="form-control" name="wonumber" readonly />
          </div>
          <label for="assetdesc" class="col-md-2 col-form-label">Asset Desc</label>
          <div class="col-md-4">
            <textarea id="assetdesc" type="text" class="form-control" name="assetdesc" rows="3" readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="dept" class="col-md-2 col-form-label">Department</label>
          <div class="col-md-4">
            <input id="dept" type="text" class="form-control" name="dept" readonly />
          </div>
          <label for="assetloc" class="col-md-2 col-form-label">Asset Location</label>
          <div class="col-md-4">
            <input id="assetloc" type="text" class="form-control" name="assetloc" readonly />
          </div>
        </div>
        <div class="form-group row">
          <label for="reqbyname" class="col-md-2 col-form-label">Requested by</label>
          <div class="col-md-4">
            <input id="reqbyname" name="reqbyname" type="text" class="form-control" readonly />
          </div>
          <label for="failtype" class="col-md-2 col-form-label">Failure Type</label>
          <div class="col-md-4">
            <input id="failtype" type="text" class="form-control" name="failtype" readonly />
          </div>
        </div>
        <div class="form-group row">
          <label for="srnote" class="col-md-2 col-form-label">SR Note</label>
          <div class="col-md-4">
            <textarea id="srnote" type="text" class="form-control" name="srnote" rows="3" readonly></textarea>
          </div>
          <label for="sr_failcode" class="col-md-2 col-form-label">Failure Code</label>
          <div class="col-md-4">
            <textarea id="sr_failcode" type="text" class="form-control" name="sr_failcode" rows="3" readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="wostatus" class="col-md-2 col-form-label">SR Status</label>
          <div class="col-md-4">
            <input id="wostatus" type="text" class="form-control" name="wostatus" style="font-weight: bold;" readonly />
          </div>
          <label for="sr_impact" class="col-md-2 col-form-label">Impact</label>
          <div class="col-md-4">
            <textarea id="sr_impact" type="text" class="form-control" name="sr_impact" autocomplete="off" rows="3" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="srreason" class="col-md-2 col-form-label">SR Approval Reason</label>
          <div class="col-md-4">
            <textarea id="srreason" type="text" class="form-control" name="srreason" rows="3" readonly></textarea>
          </div>

          <label for="priority" class="col-md-2 col-form-label">Priority</label>
          <div class="col-md-4">
            <input id="priority" type="text" class="form-control" name="priority" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="approver" class="col-md-2 col-form-label">Engineer Approver</label>
          <div class="col-md-4">
            <input id="approver" type="text" class="form-control" name="approver" readonly />
          </div>

          <label for="srdate" class="col-md-2 col-form-label">Request Date</label>
          <div class="col-md-4">
            <input id="srdate" type="text" class="form-control" name="srdate" autocomplete="off" readonly />
          </div>
        </div>
        <div class="form-group row">
          <label for="startwo" class="col-md-2 col-form-label">WO Start Date</label>
          <div class="col-md-4">
            <input id="startwo" readonly type="text" class="form-control" name="startwo">
          </div>

          <label for="srtime" class="col-md-2 col-form-label">Request Time</label>
          <div class="col-md-4">
            <input id="srtime" type="text" class="form-control" name="srtime" autocomplete="off" readonly />
          </div>
        </div>
        <div class="form-group row">
          <label for="endwo" class="col-md-2 col-form-label">WO Finish Date</label>
          <div class="col-md-4">
            <input id="endwo" type="text" class="form-control" name="endwo" readonly>
          </div>

          <label for="file" class="col-md-2 col-form-label">Current File</label>
          <div class="col-md-4">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>File Name</th>
                </tr>
              </thead>
              <tbody id="srlistupload">

              </tbody>
            </table>
          </div>
          <!-- <label for="rejectnote" class="col-md-2 col-form-label">Reject Note</label>
          <div class="col-md-4">
            <textarea id="rejectnote" type="text" class="form-control" name="rejectnote" readonly></textarea>
          </div> -->
        </div>
        <div class="form-group row">
          <label for="englist" class="col-md-2 col-form-label">Engineer List</label>
          <div class="col-md-4">
            <textarea id="englist" type="text" class="form-control" name="englist" rows="3" readonly></textarea>
          </div>

          <label for="wocancelnote" class="col-md-2 col-form-label">WO Cancel Note</label>
          <div class="col-md-4">
            <textarea id="wocancelnote" type="text" class="form-control" name="wocancelnote" rows="3" readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="srcancelnote" class="col-md-2 col-form-label">SR Cancel Note</label>
          <div class="col-md-4">
            <textarea id="srcancelnote" type="text" class="form-control" name="srcancelnote" rows="3" readonly></textarea>
          </div>
          <label for="accnote" class="col-md-2 col-form-label">User Acceptance Note</label>
          <div class="col-md-4">
            <textarea id="accnote" type="text" class="form-control" name="accnote" rows="3" readonly></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
          <!-- <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
                    <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button>  -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    /* $("#s_asset").select2({
      width: '100%',
      theme: 'bootstrap4',
    }); */

    $('#s_datefrom').datepicker({
      dateFormat: 'yy-mm-dd'
    });

    $('#s_dateto').datepicker({
      dateFormat: 'yy-mm-dd'
    });

    $("#s_user").select2({
      width: '100%',
      // placeholder : "Select User",
      theme: 'bootstrap4',
    });

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
      // theme : 'bootstrap4'
    });

    $("#e_wottype").select2({
      width: '100%',
      // theme : 'bootstrap4',
      allowClear: true,
      placeholder: 'Select Failure Type',

    });

    $("#e_approver").select2({
      width: '100%',
      // theme : 'bootstrap4',
      allowClear: true,
      placeholder: 'Select Approver',

    });

    $("#e_failurecode").select2({
      width: '100%',
      placeholder: "Select Failure Code",
      theme: "bootstrap4",
      allowClear: true,
      maximumSelectionLength: 3,
      closeOnSelect: false,
      allowClear: true,
      multiple: true,
    });

    $('#e_impact').select2({
      placeholder: "Select Impact",
      width: '100%',
      closeOnSelect: false,
      allowClear: true,
      theme: 'bootstrap4',
    });

    function fetch_data(page, srnumber, asset, /*priority /*period*/ status, requestby, datefrom, dateto) {
      $.ajax({
        url: "/srbrowse/searchsr?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + /*"&priority=" + priority + /* "&period=" + period + */ "&status=" + status + "&requestby=" + requestby + "&datefrom=" + datefrom + "&dateto=" + dateto,
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
      /*  var period = $('#s_period').val(); */
      var status = $('#s_status').val();
      var requestby = $('#s_user').val();
      var datefrom = $('#s_datefrom').val();
      var dateto = $('#s_dateto').val();
      // alert(1);
      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      // console.log(srnumber, asset);

      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      // document.getElementById('tmppriority').value = priority;
      /*document.getElementById('tmpperiod').value = period; */
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpuser').value = requestby;
      document.getElementById('tmpdatefrom').value = datefrom;
      document.getElementById('tmpdateto').value = dateto;

      fetch_data(page, srnumber, asset, /*priority*/ /*period*/ status, requestby, datefrom, dateto);

    });


    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var srnumber = $('#tmpsrnumber').val();
      var asset = $('#tmpasset').val();
      // var priority = $('#tmppriority').val();
      /*var period = $('#tmpperiod').val();*/
      var status = $('#tmpstatus').val();
      var requestby = $('#tmpuser').val();
      var datefrom = $('#s_datefrom').val();
      var dateto = $('#s_dateto').val();

      fetch_data(page, srnumber, asset, /*priority*/ /*period*/ status, requestby, datefrom, dateto);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber = '';
      var asset = '';
      var priority = '';
      /*var period = ''; */
      var status = '';
      var requestby = '';
      var datefrom = '';
      var dateto = '';
      var page = 1;

      // alert(1);
      document.getElementById('s_servicenbr').value = '';
      document.getElementById('s_asset').value = '';
      // document.getElementById('s_priority').value = '';
      /*document.getElementById('s_period').value = '';*/
      document.getElementById('s_status').value = '';
      document.getElementById('s_user').value = '';
      document.getElementById('s_datefrom').value = '';
      document.getElementById('s_dateto').value = '';
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;
      /*document.getElementById('tmpperiod').value = period;*/
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpuser').value = requestby;
      document.getElementById('tmpdatefrom').value = datefrom;
      document.getElementById('tmpdateto').value = dateto;

      fetch_data(page, srnumber, asset /*priority*/ /*period*/ , status, requestby, datefrom, dateto);

      // $("#s_asset").select2({
      //   width: '100%',
      //   // placeholder : "Select Asset",
      //   theme: 'bootstrap4',
      //   asset,
      // });

      $("#s_user").select2({
        width: '100%',
        // placeholder : "Select User",
        theme: 'bootstrap4',
        requestby,
      });


    });

    $(document).on('click', '.view', function() {

      $('#viewModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var dept = $(this).data('dept');
      var assetloc = $(this).data('assetloc');
      var astype = $(this).data('astypedesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var rejectnote = $(this).data('rejectnote');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypedesc');
      var impact = $(this).data('impactcode');
      var wonumber = $(this).data('wonumber');
      var startwo = $(this).data('startwo');
      var endwo = $(this).data('endwo');
      var action = $(this).data('action');
      var wostatus = $(this).data('wostatus');
      var statusapproval = $(this).data('statusapproval');
      var failtype = $(this).data('failtype');
      var failcode = $(this).data('failcode');
      var approver = $(this).data('approver');
      var reason = $(this).data('reason');
      var engineer = $(this).data('engineer');
      var srcancelnote = $(this).data('srcancelnote');
      var wocancelnote = $(this).data('wocancelnote');
      var accnote = $(this).data('accnote');
      var reason = $(this).data('reason');

      var srdate = $(this).data('srdate');
      document.getElementById('srdate').value = srdate;
      var srtime = $(this).data('srtime');
      document.getElementById('srtime').value = srtime;

      var eng1 = $(this).data('eng1');
      var eng2 = $(this).data('eng2');
      var eng3 = $(this).data('eng3');
      var eng4 = $(this).data('eng4');
      var eng5 = $(this).data('eng5');

      var englist = eng1 + '\n' + eng2 + '\n' + eng3 + '\n' + eng4 + '\n' + eng5;

      var fail1 = $(this).data('faildesc1');
      var fail2 = $(this).data('faildesc2');
      var fail3 = $(this).data('faildesc3');

      var faildesclist = fail1 + '\n' + fail2 + '\n' + fail3;

      // console.log(englist);

      var eng = engineer.replaceAll(";", "\n");

      document.getElementById('englist').value = eng;
      document.getElementById('reqbyname').value = reqbyname;
      document.getElementById('srnote').value = srnote;
      document.getElementById('wonumber').value = wonumber;
      if (startwo != '01-01-1970') {
        document.getElementById('startwo').value = startwo;
      } else {
        document.getElementById('startwo').value = '';
      }
      if (endwo != '01-01-1970') {
        document.getElementById('endwo').value = endwo;
      } else {
        document.getElementById('endwo').value = '';
      }
      document.getElementById('wostatus').value = wostatus;
      document.getElementById('approver').value = approver;
      document.getElementById('srcancelnote').value = srcancelnote;
      document.getElementById('wocancelnote').value = wocancelnote;

      if (wostatus == 'Open') {
        document.getElementById("wostatus").style.color = 'green';
      } else if (wostatus == 'Inprocess') {
        document.getElementById("wostatus").style.color = 'orange';
      } else if (wostatus == 'Revise') {
        document.getElementById("wostatus").style.color = 'red';
      } else {
        document.getElementById("wostatus").style.color = 'black';
      }

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

          document.getElementById('sr_impact').value = results;
          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('sr_impact').value = "";
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

          document.getElementById('sr_failcode').value = results;

        },
        statusCode: {
          500: function() {
            document.getElementById('sr_failcode').value = "";
          }
        }
      })

      $.ajax({
        url: "/listuploadview/" + srnumber,
        success: function(data) {
          // console.log(data);
          $('#srlistupload').html('').append(data);
        }
      })

      $.ajax({
        url: "/searchfailtype",
        data: {
          failtype: failtype,
        },
        success: function(data) {

          document.getElementById('failtype').value = failtype + ' -- ' + data;
          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('failtype').value = "";
          }
        }
      })


      document.getElementById('srnumber').value = srnumber;
      document.getElementById('assetcode').value = assetcode;
      document.getElementById('assetdesc').value = assetdesc;
      document.getElementById('dept').value = dept;
      document.getElementById('assetloc').value = assetloc;
      document.getElementById('srreason').value = reason;
      document.getElementById('accnote').value = accnote;

      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('priority').value = priority;

    });

    $(document).on('click', '.editsr', function() {

      $('#editModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');
      var assetdesc = $(this).data('assetdesc');
      var dept = $(this).data('dept');
      var assetloc = $(this).data('assetloc');
      var astype = $(this).data('astypedesc');
      var srnote = $(this).data('srnote');
      var reqby = $(this).data('reqby');
      var priority = $(this).data('priority');
      var reqbyname = $(this).data('reqbyname');
      var wotype = $(this).data('wotypecode');
      var impact = $(this).data('impactcode');
      var wonumber = $(this).data('wonumber');
      var startwo = $(this).data('startwo');
      var endwo = $(this).data('endwo');
      var action = $(this).data('action');
      var wostatus = $(this).data('wostatus');
      var statusapproval = $(this).data('statusapproval');
      var failtype = $(this).data('failtype');
      var failcode = $(this).data('failcode');
      var approver = $(this).data('approver');
      var rejectnote = $(this).data('rejectnote');
      var reason = $(this).data('reason');
      var cfile = $(this).data('cfile');

      // document.getElementById('e_renote').value = rejectnote;

      if (wostatus == 'Open') {
        var srstat = 'Open';
        document.getElementById("e_status").style.color = 'green';
      } else if (wostatus == 'Inprocess') {
        var srstat = 'Inprocess';
        document.getElementById("e_status").style.color = 'green';
      } else {
        var srstat = 'Revise';
        document.getElementById("e_status").style.color = 'red';
      }

      var srdate = $(this).data('srdate');
      // var srdt = new Date(srdate).toISOString().slice(0, 10);
      document.getElementById('e_date').value = srdate;
      // console.log(rejectnote);
      // console.log(document.getElementById('e_rnote').value);

      var srtime = $(this).data('srtime');
      document.getElementById('e_time').value = srtime;

      var eng1 = $(this).data('eng1');
      var eng2 = $(this).data('eng2');
      var eng3 = $(this).data('eng3');
      var eng4 = $(this).data('eng4');
      var eng5 = $(this).data('eng5');

      var englist = eng1 + '\n' + eng2 + '\n' + eng3 + '\n' + eng4 + '\n' + eng5;

      // var fail1 = $(this).data('faildesc1');
      // var fail2 = $(this).data('faildesc2');
      // var fail3 = $(this).data('faildesc3');

      // var faildesclist = fail1 + '\n' + fail2 + '\n' + fail3;

      var failcode1 = $(this).data('fc1');
      var failcode2 = $(this).data('fc2');
      var failcode3 = $(this).data('fc3');

      // array failurecode
      var newarrfc = [];
      var desc = failcode.split(",");
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrfc.push(desc[i]);
          }
        }
      }

      //value multiple failcode
      document.getElementById('e_failurecode').selectedIndex = newarrfc;
      $('#e_failurecode').val(newarrfc);
      $('#e_failurecode').trigger('change');

      // array impact
      var newarrimp = [];
      var desc = impact.split(",");
      // console.log(desc);
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrimp.push(desc[i]);
          }
        }
      }

      //value multiple impact
      document.getElementById('e_impact').selectedIndex = newarrimp;
      $('#e_impact').val(newarrimp);
      $('#e_impact').trigger('change');

      document.getElementById('englist').value = englist;
      document.getElementById('e_req').value = reqbyname;
      document.getElementById('e_note').value = srnote;
      document.getElementById('e_nowo').value = wonumber;
      if (startwo != '01-01-1970') {
        document.getElementById('startwo').value = startwo;
      } else {
        document.getElementById('startwo').value = '';
      }
      if (endwo != '01-01-1970') {
        document.getElementById('endwo').value = endwo;
      } else {
        document.getElementById('endwo').value = '';
      }

      document.getElementById('e_status').value = srstat;

      $(document).on('click', '.deleterow', function(e) {
        var data = $(this).closest('tr').find('.rowval').val();

        Swal.fire({
          title: '',
          text: "This file will be deleted forever, are you sure ?",
          icon: '',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "/deleteuploadsr/" + data,
              success: function(data) {
                //supaya button save tidak disable
                e_btnconf.disabled = false;
                $('#elistupload').html('').append(data);
              }
            })
          }
        })


      });

      $.ajax({
        url: "/listupload/" + srnumber,
        success: function(data) {
          $('#elistupload').html('').append(data);
        }
      })

      document.getElementById('e_nosr').value = srnumber;
      document.getElementById('e_asset').value = assetcode + ' - ' + assetdesc;
      document.getElementById('assetdesc').value = assetdesc;
      document.getElementById('e_dept').value = dept;
      document.getElementById('assetloc').value = assetloc;
      document.getElementById('e_wottype').value = failtype;
      document.getElementById('e_approver').value = approver;
      document.getElementById('e_reason').value = reason;
      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('e_priority').value = priority;

      // Mengambil semua value default
      var inputDate = document.getElementById('e_date');
      var inputTime = document.getElementById('e_time');
      var inputFailType = $("#e_wottype");
      var inputPriority = $("#e_priority");
      var inputFailCode = $("#e_failurecode");
      var inputImpact = $("#e_impact");
      var inputNote = $("#e_note");
      var inputApprover = $("#e_approver");
      var inputFileName = document.getElementById('filename');
      // console.log(inputFileName);

      inputDate.addEventListener("input", function() {
        var valueDate = inputDate.value;
        if (srdate != valueDate) {
          e_btnconf.disabled = false;
        } else {
          e_btnconf.disabled = true;
        }
      })

      inputTime.addEventListener("input", function() {
        var valueTime = inputTime.value;
        var substrtime = srtime.substr(0,5);
        if (substrtime != valueTime) {
          e_btnconf.disabled = false;
        } else {
          e_btnconf.disabled = true;
        }
      })

      inputFailType.on("change", function() {
        var selectedValue = inputFailType.val();
         if (failtype != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputPriority.on("change", function() {
        var selectedValue = inputPriority.val();
         if (priority != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputFailCode.on("change", function() {
        var selectedValue = inputFailCode.val();
         if (failcode != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputImpact.on("change", function() {
        var selectedValue = inputImpact.val();
         if (impact != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputNote.on("input", function() {
        var selectedValue = inputNote.val();
         if (srnote != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputApprover.on("change", function() {
        var selectedValue = inputApprover.val();
         if (approver != selectedValue) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;
        }
      });

      inputFileName.addEventListener("change", function() {
        var valueFile = inputFileName.value;
        // console.log(cfile);
        var fileArray = [];
        if (valueFile != '') {
          var array = fileArray.push(valueFile);
        }else{
          var array = fileArray.pop();
        }

        if (array == undefined) {
          e_btnconf.disabled = true;
        } else if(cfile != array.length) {
          e_btnconf.disabled = false;
        }else{
          e_btnconf.disabled = true;

        }
      })

      $('#e_wottype').select2({
        theme: 'bootstrap4',
        width: '100%',
      });

      $('#e_approver').select2({
        theme: 'bootstrap4',
        width: '100%',
      });

      $('#e_failurecode').select2({
        placeholder: "Select Failure Code",
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        maximumSelectionLength: 3,
        maximumSelectionLength: 5,
        closeOnSelect: false,
        allowClear: true,
        multiple: true,
      });

      $('#e_impact').select2({
        placeholder: "Select Impact",
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        maximumSelectionLength: 3,
      });


    });

    $(document).on('click', '.cancelsr', function() {

      $('#cancelModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');

      document.getElementById('srnbr').innerHTML = srnumber;
      document.getElementById('c_srnumber').value = srnumber;

    });

    $(document).on('click', '.route', function() {
      $('#routeModal').modal('show');

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
      // alert(impact);
      var assetloc = $(this).data('assetloc');
      var hassetsite = $(this).data('hassetsite');
      var hassetloc = $(this).data('hassetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');
      var failcode = $(this).data('failcode');
      var id = $(this).data('id');
      var reason = $(this).data('reason');

      // alert(impactcode1);
      document.getElementById('m_route_ppnumber').value = srnumber;
      document.getElementById('m_route_requested_by').value = reqbyname;
      document.getElementById('m_route_asset').value = assetcode;

      $.ajax({
        type: "GET",
        url: "/routesr",
        data: {
          sr_number: srnumber
        },
        success: function(data) {
          $('#bodyroute').html(data);
        }
      });

      $.ajax({
        type: "GET",
        url: "/routesreng",
        data: {
          sr_number: srnumber
        },
        success: function(data) {
          $('#bodyroutex').html(data);
        }
      });

    });

    $(document).on('click', '#btnexcel', function() {
      var srnumber = $('#tmpsrnumber').val();
      var srasset = $('#tmpasset').val();
      var srstatus = $('#tmpstatus').val();
      var srreq = $('#tmpuser').val();
      var srdatefrom = $('#tmpdatefrom').val();
      var srdateto = $('#tmpdateto').val();

      // console.log(srnumber, srasset, srstatus, /*srpriority, srperiod,*/ srreq, srdatefrom, srdateto);

      window.open("/donlodsr?srnumber=" + srnumber + "&asset=" + srasset + "&status=" + srstatus + /*"&priority=" + srpriority + "&period=" + srperiod +*/ "&reqby=" + srreq + "&datefrom=" + srdatefrom + "&dateto=" + srdateto, '_blank');
    });
  });
</script>
@endsection