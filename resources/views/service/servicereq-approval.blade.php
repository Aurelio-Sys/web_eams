@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">Service Request Approval</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan approval department</p>
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
        </div>
        <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('Asset Description') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <!-- <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
                  <option value="">--Select Asset--</option>
                  @foreach($asset as $show)
                  <option value="{{$show->asset_desc}}">{{$show->asset_code}} -- {{$show->asset_desc}}</option>
                  @endforeach
                </select> -->
          <input id="s_asset" type="text" class="form-control" name="s_asset" value="" autofocus autocomplete="off" placeholder="Search Asset Desc">
        </div>
        <!-- <label for="s_servicenbr" class="col-md-3 col-sm-2 col-form-label text-md-left">{{ __('Service Request Number') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <input id="s_servic/enbr" type="text" class="form-control" name="s_servicenbr" value="" autofocus autocomplete="off">
          <select id="s_servicenbr" name="s_servicenbr" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select SR Number--</option>
            @foreach($datasrnbr as $srnbr)
            <option value="{{$srnbr->sr_number}}">{{$srnbr->sr_number}}</option>
            @endforeach
          </select>
        </div>
        <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('Asset Code') }}</label>
        <div class="col-md-3 col-sm-4 mb-2 input-group">
          <select id="s_asset" name="s_asset" class="form-control" value="" autofocus autocomplete="off">
            <option value="">--Select Asset--</option>
            @foreach($asset as $show)
            <option value="{{$show->asset_desc}}">{{$show->asset_desc}}</option>
            @endforeach
          </select>
        </div> -->
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
        <label for="s_period" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label>
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
      @include('service.table-srapproval')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<div class="modal fade" id="approvalModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="approval" method="post" action="/approval" enctype="multipart/form-data">
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
              <textarea id="assetdesc" type="text" class="form-control" name="assetdesc" autocomplete="off" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="assetloc" class="col-md-5 col-form-label text-md-left">Asset Location</label>
            <div class="col-md-7">
              <input id="assetloc" type="text" class="form-control" name="assetloc" autocomplete="off" autofocus readonly />
              <input id="h_assetsite" type="hidden" name="h_assetsite" />
              <input id="h_assetloc" type="hidden" name="h_assetloc" />
            </div>
          </div>
          <!-- <div class="form-group row">
                        <label for="assettype" class="col-md-5 col-form-label text-md-left">Process / Technology</label>
                        <div class="col-md-7">
                            <input id="assettype" type="text" class="form-control" name="assettype" autocomplete="off" autofocus readonly/>
                        </div>
                    </div> -->
          <div class="form-group row col-md-12">
            <label for="srnote" class="col-md-5 col-form-label text-md-left">Note</label>
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
              <input id="wotype" type="text" class="form-control" name="wotype" autocomplete="off" readonly />
              <!-- <select class="form-control wotype" name="wotype" id="wotype">
                <option value="">Select Failure Type</option>
                @foreach($wotypes as $wotype)
                <option value="{{$wotype->wotyp_code}}">{{$wotype->wotyp_code}} - {{$wotype->wotyp_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="failcode" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7">
              <textarea id="failcode" type="text" class="form-control" name="failcode" rows="3" readonly></textarea>
              <!-- <select class="form-control fclist" name="fclist[]" id="fclist" multiple="multiple">
                <option value=""></option>
                @foreach($fcodes as $fcode)
                <option value="{{$fcode->fn_code}}">{{$fcode->fn_code}} - {{$fcode->fn_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <textarea id="impact" type="text" class="form-control" name="impact" autocomplete="off" rows="3" readonly></textarea>
              <!-- <select class="form-control impact" name="impact[]" id="impact" multiple="multiple">
                <option value=""></option>
                @foreach($impacts as $impact)
                <option value="{{$impact->imp_code}}">{{$impact->imp_code}} - {{$impact->imp_desc}}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="priority" type="text" name="priority" class="form-control" readonly>
              <!-- <select class="form-control priority" name="priority" id="priority">
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select> -->
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="reason" class="col-md-5 col-form-label text-md-left">Reason</label>
            <div class="col-md-7">
              <textarea id="reason" type="text" class="form-control" name="reason" maxlength="250" autocomplete="off" autofocus></textarea>
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

<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Service Request View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="view" method="post" action="/approval" enctype="multipart/form-data">
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
              <input id="v_reqbyname" type="text" class="form-control" autocomplete="off" autofocus readonly />
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_dept" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <input id="v_dept" type="text" class="form-control" name="v_dept" autocomplete="off" autofocus readonly />
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
              <textarea id="v_assetdesc" type="text" class="form-control" name="v_assetdesc" autocomplete="off" rows="3" readonly></textarea>
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
          <div class="form-group row col-md-12">
            <label for="v_srnote" class="col-md-5 col-form-label text-md-left">Note</label>
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
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_failcode" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7">
              <textarea id="v_failcode" type="text" class="form-control" name="v_failcode" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <textarea id="v_impact" type="text" class="form-control" name="v_impact" autocomplete="off" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
            <div class="col-md-7">
              <input id="v_priority" type="text" name="v_priority" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="v_reason" class="col-md-5 col-form-label text-md-left">Reason</label>
            <div class="col-md-7">
              <textarea id="v_reason" type="text" class="form-control" name="v_reason" maxlength="250" autocomplete="off" readonly></textarea>
              <!-- <span id="alert3" style="color: red; font-weight: 200;"></span> -->
            </div>
          </div>

          <input type="hidden" id="tmpfail1" name="tmpfail1" value="">
          <input type="hidden" id="v_impactcode1" name="v_impactcode1" value="">
          <input type="hidden" id="tmpfail2" name="tmpfail2" value="">
          <input type="hidden" id="tmpfail3" name="tmpfail3" value="">
          <input type="hidden" id="v_hiddendeptcode" name="v_hiddendeptcode" />
          <!-- <input type="hidden" id="hiddenreqby" name="hiddenreqby" /> -->

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <!-- <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
            <button type="submit" class="btn btn-warning" name="action" value="revise" id="btnrevise">Revisi</button>
            <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button> -->
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

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
            <table id='routetable' class='table route-list' style="margin-bottom: 0px;">
              <thead>
                <tr>
                  <th style="width:10%">No.</th>
                  <th style="width:10%">Department</th>
                  <th style="width:10%">Role</th>
                  <th style="width:15%">Reason</th>
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



@endsection


@section('scripts')
<script type="text/javascript">
  $("#approval").submit(function() {
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

    $("#repgroup").select2({
      width: '100%',
      placeholder: 'Select Repair Group',
      allowClear: true,
      // theme : 'bootstrap4',
    });

    // $('#impact').select2({
    //   placeholder: "Select Value",
    //   width: '100%',
    //   closeOnSelect: false,
    //   allowClear: true,
    //   theme: 'bootstrap4',
    // });

    // $("#fclist").select2({
    //   width: '100%',
    //   placeholder: "Select Failure Code",
    //   theme: "bootstrap4",
    //   allowClear: true,
    //   maximumSelectionLength: 3,
    //   closeOnSelect: false,
    //   allowClear: true,
    //   multiple: true,
    // });

    // $("#wotype").select2({
    //   width: '100%',
    //   // theme : 'bootstrap4',
    //   allowClear: true,
    //   placeholder: 'Select Failure Type',

    // });

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
    // $(document).on('keyup', '#reason', function(e) {
    //   var inputreject = document.getElementById('reason');
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
      var reason = document.getElementById('reason').value;
      var enjiners = document.getElementById('enjiners').value;
      var scheduledate = document.getElementById('scheduledate').value;
      var duedate = document.getElementById('duedate').value;
      // event.preventDefault();
      // $('#approval')
      // alert(1);

      if (reason == "") {
        // alert('masuk reject');
        $("#enjiners").attr('required', false);
        $("#scheduledate").attr('required', false);
        $("#duedate").attr('required', false);
        $("#repaircode").attr('required', false);
        $("#rad_repgroup1").attr('required', false);
        // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
        $("#reason").attr('required', true);
      } else {
        // alert('masuk sini');
        $("#enjiners").attr('required', false);
        $("#scheduledate").attr('required', false);
        $("#duedate").attr('required', false);
        $("#repaircode").attr('required', false);
        $("#rad_repgroup1").attr('required', false);
        // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
        // $("#reason").attr('required', true);

        $('#approval').submit();

      }

    });

    $(document).on('click', '#btnapprove', function(event) {
      var reason = document.getElementById('reason').value;
      var enjiners = document.getElementById('enjiners').value;
      var scheduledate = document.getElementById('scheduledate').value;
      var duedate = document.getElementById('duedate').value;
      var pilihgrup = document.getElementById('rad_repgroup1').checked;
      var pilihcode = document.getElementById('rad_repgroup2').checked;
      // event.preventDefault();
      // $('#approval')
      // alert(pilihgrup);
      // alert(pilihcode);

      if (enjiners == "" || scheduledate == "" || duedate == "" || (pilihgrup == false && pilihcode == false)) {
        // alert('ada yg kosong');
        $("#enjiners").attr('required', true);
        $("#scheduledate").attr('required', true);
        $("#duedate").attr('required', true);
        $("#rad_repgroup1").attr('required', true);
        // $("#repaircode").attr('required', true);
        // document.getElementById("alert3").innerHTML = 'Please fill out reason reject';
        // $("#reason").attr('required', false);
      } else {
        if (pilihgrup) {
          // alert('pilihgrup');
          $("#repgroup").attr('required', true);
          $("#repaircode").attr('required', false);
          // $('#approval').submit();
          // event.preventDefault();
        } else {
          // alert('pilihcode');
          $("#repaircode").attr('required', true);
          $("#repgroup").attr('required', false);
          // $('#approval').submit();
          // event.preventDefault();
        }
        // $("#rad_repgroup1").attr('required',true);

      }

    });


    function fetch_data(page, srnumber, asset, priority) {
      $.ajax({
        url: "/srapproval/searchapproval?page=" + page + "&srnumber=" + srnumber + "&asset=" + asset + "&priority=" + priority,
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
      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;

      fetch_data(page, srnumber, asset, priority);
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

      fetch_data(page, srnumber, asset, priority);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber = '';
      var asset = '';
      var priority = '';
      var page = 1;

      document.getElementById('s_servicenbr').value = '';
      document.getElementById('s_asset').value = '';
      document.getElementById('s_priority').value = '';
      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmppriority').value = priority;

      fetch_data(page, srnumber, asset, priority);

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

    $(document).on('click', '.approval', function() {
      $('#approvalModal').modal('show');

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
      // alert(priority);
      var assetloc = $(this).data('assetloc');
      var hassetsite = $(this).data('hassetsite');
      var hassetloc = $(this).data('hassetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');
      var failcode = $(this).data('failcode');
      var id = $(this).data('id');

      // var fail1 = $(this).data('failcode1');
      // var fail2 = $(this).data('failcode2');
      // var fail3 = $(this).data('failcode3');
      // console.log(reqby);

      var failcode1 = $(this).data('fc1');
      var failcode2 = $(this).data('fc2');
      var failcode3 = $(this).data('fc3');

      // var fail_list = fail1 + '\n' + fail2 + '\n' + fail3;

      // array failure code
      var newarrfc = [];
      if (failcode1 != '') {
        newarrfc.push(failcode1);
      }
      if (failcode2 != '') {
        newarrfc.push(failcode2);
      }
      if (failcode3 != '') {
        newarrfc.push(failcode3);
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
          
          document.getElementById('impact').value = results;

        },
        statusCode: {
          500: function() {
            document.getElementById('impact').value = "";
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
          
          document.getElementById('failcode').value = results;

        },
        statusCode: {
          500: function() {
            document.getElementById('failcode').value = "";
          }
        }
      })

      $.ajax({
        url: "/searchfailtype",
        data: {
          failtype: wotype,
        },
        success: function(data) {


          document.getElementById('wotype').value = wotype + ' -- ' + data;

          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('wotype').value = "";
          }
        }
      })


      // alert(impactcode1);
      document.getElementById('srnumber').value = srnumber;
      document.getElementById('idsr').value = id;
      document.getElementById('srdate').value = srdate;
      document.getElementById('assetcode').value = assetcode;
      document.getElementById('assetdesc').value = assetdesc;
      document.getElementById('reqbyname').value = reqby;
      // console.log(document.getElementById('reqbyname').value);
      {
        {
          // --document.getElementById('assettype').value = astype;
          // --
        }
      }
      document.getElementById('impactcode1').value = impactcode1;
      document.getElementById('assetloc').value = assetloc;
      document.getElementById('h_assetsite').value = hassetsite;
      document.getElementById('h_assetloc').value = hassetloc;

      document.getElementById('srnote').value = srnote;
      document.getElementById('hiddenreq').value = reqby;
      document.getElementById('priority').value = priority;
      document.getElementById('dept').value = dept;
      document.getElementById('hiddendeptcode').value = deptcode;

      // $('#wotype').select2({
      //   theme: 'bootstrap4',
      //   width: '100%',
      //   // wotype,
      // });

      // $('#fclist').select2({
      //   placeholder: "Select Failure Code",
      //   width: '100%',
      //   closeOnSelect: false,
      //   allowClear: true,
      //   maximumSelectionLength: 3,
      // });

      // $('#impact').select2({
      //   placeholder: "Select Value",
      //   width: '100%',
      //   closeOnSelect: false,
      //   allowClear: true,
      // });

    });

    $(document).on('click', '.view', function() {
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
      var assetloc = $(this).data('assetloc');
      var hassetsite = $(this).data('hassetsite');
      var hassetloc = $(this).data('hassetloc');
      var astype = $(this).data('astypedesc');
      var impactcode1 = $(this).data('impactcode');
      var failcode = $(this).data('failcode');
      var id = $(this).data('id');
      var reason = $(this).data('reason');

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

      // array failcode
      var newarrfc = [];
      var desc = failcode.split(",");
      if (desc != null) {
        for (var i = 0; i <= (desc.length - 1); i++) {
          if (desc[i] != '') {
            newarrfc.push(desc[i]);
          }
        }
      }

      $.ajax({
        url: "/listuploadview/" + srnumber,
        success: function(data) {
          // console.log(data);
          $('#v_listupload').html('').append(data);
        }
      })

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
          
          document.getElementById('v_failcode').value = results;
          // }

        },
        statusCode: {
          500: function() {
            document.getElementById('v_failcode').value = "";
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


      // alert(impactcode1);
      document.getElementById('v_srnumber').value = srnumber;
      document.getElementById('idsr').value = id;
      document.getElementById('v_srdate').value = srdate;
      document.getElementById('v_assetcode').value = assetcode;
      document.getElementById('v_assetdesc').value = assetdesc;
      document.getElementById('v_reason').value = reason;
      document.getElementById('v_reqbyname').value = reqby;
      document.getElementById('v_wotype').value = wotype;
      document.getElementById('v_impactcode1').value = impactcode1;
      document.getElementById('v_assetloc').value = assetloc;
      document.getElementById('v_h_assetsite').value = hassetsite;
      document.getElementById('v_h_assetloc').value = hassetloc;
      document.getElementById('v_srnote').value = srnote;
      document.getElementById('v_hiddenreq').value = reqby;
      document.getElementById('v_priority').value = priority;
      document.getElementById('v_dept').value = dept;
      document.getElementById('v_hiddendeptcode').value = deptcode;

    });

    $(document).on('click', '.route', function() {
      $('#routeModal').modal('show');

      var srnumber = $(this).data('srnumber');
      var assetcode = $(this).data('assetcode');
      var reqbyname = $(this).data('reqbyname');

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

    });


    function ambilenjiner() {
      // alert('ketrigger');
      $.ajax({
        url: "/engineersearch",
        success: function(data) {

          console.log(data);
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