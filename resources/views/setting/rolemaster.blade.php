@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
			<h1 class="m-0 text-dark">Role Maintenance</h1>
		  </div>	
        </div><!-- /.row -->
        <div class="col-md-12">
		  <hr>
		</div>
        <div class="row">         		  
		  <div class="col-sm-2">	
			<button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createDivisi">Role Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
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
  }
</style>

<!--FORM Search Disini -->
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
              <label for="s_rolecode" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('Role Code') }}</label>
              <div class="col-md-4 mb-2 input-group">
                <input id="s_rolecode" type="text" class="form-control" name="s_rolecode" value="" autofocus autocomplete="off">
              </div>
              <label for="s_roledesc" class="col-md-2 col-sm-2 col-form-label text-md-right">{{ __('Role Description') }}</label>
              <div class="col-md-4 mb-2 input-group">
                <input id="s_roledesc" type="text" class="form-control" name="s_roledesc" value="" autofocus autocomplete="off" min="0">
              </div>
              <label for="s_roledesc" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label>
              <div class="col-md-2 mb-2 input-group">
                <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
              </div>
              <div class="col-md-2 col-sm-12 mb-2 input-group">
                <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
              </div>
        </div>
      </div>
  </div>
</div>

<div class="col-md-12">
  <hr>
</div>

<input type="hidden" id="tmprolecode" value=""/>
<input type="hidden" id="tmproledesc" value=""/>
<!--Table Menu-->
<div class="table-responsive col-lg-12 col-md-12">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th width=35% >Code</th>
        <th width=35% >Description</th>
        <th width=20% >Access As</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('setting.table-rolemaster')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="role_code" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!--Create Modal-->
<div class="modal fade createrole" id='createDivisi' tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Role Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" method="POST" id='new' action="/createrole" onkeydown="return event.key != 'Enter';">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group row col-md-12">
            <label for="role_code" class="col-md-5 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
            <div class="col-md-5 {{ $errors->has('uname') ? 'has-error' : '' }}">
              <input id="role_code" type="text" class="form-control role_code" name="role_code" value="{{ old('role_code') }}" autocomplete="off" maxlength="8" required autofocus>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="role_desc" class="col-md-5 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
            <div class="col-md-5">
              <input id="role_desc" type="text" class="form-control" name="role_desc" value="{{ old('role_desc') }}" autocomplete="off" maxlength="50" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
          <label for="t_acc" class="col-md-5 col-form-label text-md-right">Access As <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
            <div class="col-md-5">
                  <select id="t_acc" class="form-control" name="t_acc" required value="{{ old('t_acc') }}" required>
                      <option value="">--Select Data--</option>
                      <option value="User">User</option>
                      <option value="Engineer">Engineer</option>
                  </select>
              </div>
          </div>
          <div class="form-group">
            <h3>
              <center><strong>Role Permissions</strong></center>
            </h3>
            <br/>
            <!-- Service Request -->
            <h4>
            <center><strong>Service Request Menu</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Create') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRcreate">
                  <input type="checkbox" class="custom-control-input" id="cbSRcreate" name="cbSRcreate" value="SR01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRapprove">
                  <input type="checkbox" class="custom-control-input" id="cbSRapprove" name="cbSRapprove" value="SR02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRbrowse">
                  <input type="checkbox" class="custom-control-input" id="cbSRbrowse" name="cbSRbrowse" value="SR03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Approval Engineer') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRapprovaleng">
                  <input type="checkbox" class="custom-control-input" id="cbSRapprovaleng" name="cbSRapprovaleng" value="SR05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  Dua Kelinci status akhir di QC Approval
              <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Acceptance') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUA">
                  <input type="checkbox" class="custom-control-input" id="cbUA" name="cbUA" value="SR04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
              <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Acceptance') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUA">
                  <input type="checkbox" class="custom-control-input" id="cbUA" name="cbUA" value="SR04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>

            <h4>
            <center><strong>Work Order Menu</strong></center>
            </h4>
            <hr>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('WO Create Without Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoCreatedirect">
                  <input type="checkbox" class="custom-control-input" id="cbWoCreatedirect" name="cbWoCreatedirect" value="WO06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoMaint">
                  <input type="checkbox" class="custom-control-input" id="cbWoMaint" name="cbWoMaint" value="WO01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoBrowse">
                  <input type="checkbox" class="custom-control-input" id="cbWoBrowse" name="cbWoBrowse" value="WO05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <!-- <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Create') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoCreate">
                  <input type="checkbox" class="custom-control-input" id="cbWoCreate" name="cbWoCreate" value="WO04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> -->
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Release') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoRelease">
                  <input type="checkbox" class="custom-control-input" id="cbWoRelease" name="cbWoRelease" value="WO09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Warehouse Confirm') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoWhsConf">
                  <input type="checkbox" class="custom-control-input" id="cbWoWhsConf" name="cbWoWhsConf" value="WO07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Start') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoStart">
                  <input type="checkbox" class="custom-control-input" id="cbWoStart" name="cbWoStart" value="WO02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Finish') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoReport">
                  <input type="checkbox" class="custom-control-input" id="cbWoReport" name="cbWoReport" value="WO03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('WO Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="cbWoQc">
                  <input type="checkbox" class="custom-control-input" id="cbWoQc" name="cbWoQc" value="WO08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
			      
            <h4>
              <center><strong>Asset Usage</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset PM Calculate') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUSMT">
                  <input type="checkbox" class="custom-control-input" id="cbUSMT" name="cbUSMT" value="US01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Multi Batch') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUSmultiMT">
                  <input type="checkbox" class="custom-control-input" id="cbUSmultiMT" name="cbUSmultiMT" value="US02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Generator') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUSGen">
                  <input type="checkbox" class="custom-control-input" id="cbUSGen" name="cbUSGen" value="US03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Confirm') }}</label>
              <div class="col-6">
                <label class="switch" for="pmconf">
                  <input type="checkbox" class="custom-control-input" id="pmconf" name="pmconf" value="US05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Notif Message') }}</label>
              <div class="col-6">
                <label class="switch" for="pmmssg">
                  <input type="checkbox" class="custom-control-input" id="pmmssg" name="pmmssg" value="US06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart Planning') }}</label>
              <div class="col-6">
                <label class="switch" for="ksp">
                  <input type="checkbox" class="custom-control-input" id="ksp" name="ksp" value="US06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Usage Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="cbUSBrowse">
                  <input type="checkbox" class="custom-control-input" id="cbUSBrowse" name="cbUSBrowse" value="US04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>

			
            <!-- Booking -->
            <h4>
              <center><strong>Another Transactions</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Booking Asset') }}</label>
              <div class="col-6">
                <label class="switch" for="cbBoas">
                  <input type="checkbox" class="custom-control-input" id="cbBoas" name="cbBoas" value="BO01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('5 Why Transaction') }}</label>
              <div class="col-6">
                <label class="switch" for="whyhist">
                  <input type="checkbox" class="custom-control-input" id="whyhist" name="whyhist" value="BO02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Request Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="reqsp">
                  <input type="checkbox" class="custom-control-input" id="reqsp" name="reqsp" value="BO03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Transfer Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="trfsp">
                  <input type="checkbox" class="custom-control-input" id="trfsp" name="trfsp" value="BO04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Movement ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetMove">
                  <input type="checkbox" class="custom-control-input" id="SetMove" name="SetMove" value="MT30" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>

            <!-- Reports -->
            <h4>
            <center><strong>Report Menu</strong></center>
            </h4>
            <hr>
            <!-- <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('All Asset Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRcreate">
                  <input type="checkbox" class="custom-control-input" id="cbSRcreate" name="cbSRcreate" value="RT11" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> -->
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Detail WO Report') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRptDet">
                  <input type="checkbox" class="custom-control-input" id="cbRptDet" name="cbRptDet" value="RT08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Cost Report') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRptCost">
                  <input type="checkbox" class="custom-control-input" id="cbRptCost" name="cbRptCost" value="RT09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Report') }}</label>
              <div class="col-6">
                <label class="switch" for="cbAssetReport">
                  <input type="checkbox" class="custom-control-input" id="cbAssetReport" name="cbAssetReport" value="RT05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Report') }}</label>
              <div class="col-6">
                <label class="switch" for="cbEngReport">
                  <input type="checkbox" class="custom-control-input" id="cbEngReport" name="cbEngReport" value="RT04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Remaining Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRptRemsp">
                  <input type="checkbox" class="custom-control-input" id="cbRptRemsp" name="cbRptRemsp" value="RT10" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="cbAssetSchedule">
                  <input type="checkbox" class="custom-control-input" id="cbAssetSchedule" name="cbAssetSchedule" value="RT03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Schedule (Year)') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRptSchyear">
                  <input type="checkbox" class="custom-control-input" id="cbRptSchyear" name="cbRptSchyear" value="RT07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="cbEngSchedule">
                  <input type="checkbox" class="custom-control-input" id="cbEngSchedule" name="cbEngSchedule" value="RT01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart Needs') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRptSpneed">
                  <input type="checkbox" class="custom-control-input" id="cbRptSpneed" name="cbRptSpneed" value="RT06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Booking Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="cbBookSchedule">
                  <input type="checkbox" class="custom-control-input" id="cbBookSchedule" name="cbBookSchedule" value="RT02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            

            <!-- Setting -->
            <h4>
              <center><strong>Settings</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Department Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="dept">
                  <input type="checkbox" class="custom-control-input" id="dept" name="dept" value="MT21" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Skills Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Skill">
                  <input type="checkbox" class="custom-control-input" id="Skill" name="Skill" value="MT22" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Eng">
                  <input type="checkbox" class="custom-control-input" id="Eng" name="Eng" value="MT01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Role Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="RoleMaint">
                  <input type="checkbox" class="custom-control-input" id="RoleMaint" name="RoleMaint" value="MT02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Engineer Group Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="EngGroup">
                  <input type="checkbox" class="custom-control-input" id="EngGroup" name="EngGroup" value="MT38" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Running Number Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRunning">
                  <input type="checkbox" class="custom-control-input" id="cbRunning" name="cbRunning" value="MT99" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('WSA Qxtend Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="SetWsa">
                  <input type="checkbox" class="custom-control-input" id="SetWsa" name="SetWsa" value="MT20" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Failure Type Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetFntype">
                  <input type="checkbox" class="custom-control-input" id="SetFntype" name="SetFntype" value="MT32" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Failure Code Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="Fn">
                  <input type="checkbox" class="custom-control-input" id="Fn" name="Fn" value="MT33" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Impact Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetImp">
                  <input type="checkbox" class="custom-control-input" id="SetImp" name="SetImp" value="MT34" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Type Maintenance  ') }}</label>
              <div class="col-6">
                <label class="switch" for="Astype">
                  <input type="checkbox" class="custom-control-input" id="Astype" name="Astype" value="MT05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Group Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="Asgroup">
                  <input type="checkbox" class="custom-control-input" id="Asgroup" name="Asgroup" value="MT06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Supplier Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="Supp">
                  <input type="checkbox" class="custom-control-input" id="Supp" name="Supp" value="MT07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Asset Site Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetAssetsite">
                  <input type="checkbox" class="custom-control-input" id="SetAssetsite" name="SetAssetsite" value="MT26" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Location Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetAssetloc">
                  <input type="checkbox" class="custom-control-input" id="SetAssetloc" name="SetAssetloc" value="MT28" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('UM Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetUm">
                  <input type="checkbox" class="custom-control-input" id="SetUm" name="SetUm" value="MT36" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="Asset">
                  <input type="checkbox" class="custom-control-input" id="Asset" name="Asset" value="MT08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Hierarchy Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Aspar">
                  <input type="checkbox" class="custom-control-input" id="Aspar" name="Aspar" value="MT09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer For PM') }}</label>
              <div class="col-6">
                <label class="switch" for="SetEngpm">
                  <input type="checkbox" class="custom-control-input" id="SetEngpm" name="SetEngpm" value="MT31" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Mapping Asset - Failure') }}</label>
              <div class="col-6">
                <label class="switch" for="SetAsfn">
                  <input type="checkbox" class="custom-control-input" id="SetAsfn" name="SetAsfn" value="MT37" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Preventive Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="pmasset">
                  <input type="checkbox" class="custom-control-input" id="pmasset" name="pmasset" value="MT42" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Type ') }}</label>
              <div class="col-6">
                <label class="switch" for="Spt">
                  <input type="checkbox" class="custom-control-input" id="Spt" name="Spt" value="MT10" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Group ') }}</label>
              <div class="col-6">
                <label class="switch" for="Spg">
                  <input type="checkbox" class="custom-control-input" id="Spg" name="Spg" value="MT11" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Spare Part Site ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetSpsite">
                  <input type="checkbox" class="custom-control-input" id="SetSpsite" name="SetSpsite" value="MT27" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Location ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetSploc">
                  <input type="checkbox" class="custom-control-input" id="SetSploc" name="SetSploc" value="MT29" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Code ') }}</label>
              <div class="col-6">
                <label class="switch" for="Spm">
                  <input type="checkbox" class="custom-control-input" id="Spm" name="Spm" value="MT12" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Tools Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="Tool">
                  <input type="checkbox" class="custom-control-input" id="Tool" name="Tool" value="MT14" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Code ') }}</label>
              <div class="col-6">
                <label class="switch" for="Rep">
                  <input type="checkbox" class="custom-control-input" id="Rep" name="Rep" value="MT34" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Group ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetRepgroup">
                  <input type="checkbox" class="custom-control-input" id="SetRepgroup" name="SetRepgroup" value="MT15" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Instruction List ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetIns">
                  <input type="checkbox" class="custom-control-input" id="SetIns" name="SetIns" value="MT35" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart List ') }}</label>
              <div class="col-6">
                <label class="switch" for="SetSplist">
                  <input type="checkbox" class="custom-control-input" id="SetSplist" name="SetSplist" value="MT41" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('QC Specification') }}</label>
              <div class="col-6">
                <label class="switch" for="qcspec">
                  <input type="checkbox" class="custom-control-input" id="qcspec" name="qcspec" value="MT40" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Maintenance Code') }}</label>
              <div class="col-6">
                <label class="switch" for="SetPmcode">
                  <input type="checkbox" class="custom-control-input" id="SetPmcode" name="SetPmcode" value="MT39" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Routine Check Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="rcmmstr">
                  <input type="checkbox" class="custom-control-input" id="rcmmstr" name="rcmmstr" value="MT43" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Approval SR') }}</label>
              <div class="col-6">
                <label class="switch" for="appsr">
                  <input type="checkbox" class="custom-control-input" id="appsr" name="appsr" value="MT44" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Approval WO') }}</label>
              <div class="col-6">
                <label class="switch" for="appwo">
                  <input type="checkbox" class="custom-control-input" id="appwo" name="appwo" value="MT45" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Source') }}</label>
              <div class="col-6">
                <label class="switch" for="invso">
                  <input type="checkbox" class="custom-control-input" id="invso" name="invso" value="MT46" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Supply') }}</label>
              <div class="col-6">
                <label class="switch" for="invsu">
                  <input type="checkbox" class="custom-control-input" id="invsu" name="invsu" value="MT47" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Instruction Details Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Ins">
                  <input type="checkbox" class="custom-control-input" id="Ins" name="Ins" value="MT16" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Instruction Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Repins">
                  <input type="checkbox" class="custom-control-input" id="Repins" name="Repins" value="MT18" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Part Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Reppart">
                  <input type="checkbox" class="custom-control-input" id="Reppart" name="Reppart" value="MT17" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Details Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="cbRepdet">
                  <input type="checkbox" class="custom-control-input" id="cbRepdet" name="cbRepdet" value="MT23" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Data Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="Inv">
                  <input type="checkbox" class="custom-control-input" id="Inv" name="Inv" value="MT19" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            
            <div class="modal-footer">
              <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
              <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--Modal Edit-->
<div class="modal fade editModal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Role Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" method="post" id='newedit' action="/editrole" onkeydown="return event.key != 'Enter';">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group row col-md-12">
            <label for="e_acc" class="col-md-5 col-form-label text-md-right">Code</label>
            <div class="col-md-7">
              <input id="e_rolecode" type="text" class="form-control" name="e_rolecode" value="{{ old('e_rolecode') }}" autocomplete="off" maxlength="50" readonly autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="e_acc" class="col-md-5 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="e_roledesc" type="text" class="form-control" name="e_roledesc" value="{{ old('e_roledesc') }}" autocomplete="off" maxlength="50" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="e_acc" class="col-md-5 col-form-label text-md-right">Access As <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
            <div class="col-md-5">
                  <select id="e_acc" class="form-control" name="e_acc" required value="{{ old('e_acc') }}" required>
                      <option value="User">User</option>
                      <option value="Engineer">Engineer</option>
                  </select>
              </div>
          </div>
          <div class="form-group">
            <h3>
              <center><strong>Role Permissions</strong></center>
            </h3>
            <br>

            <h4>
            <center><strong>Service Request Menu</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Create') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbSRcreate">
                  <input type="checkbox" class="custom-control-input" id="e_cbSRcreate" name="e_cbSRcreate" value="SR01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbSRapprove">
                  <input type="checkbox" class="custom-control-input" id="e_cbSRapprove" name="e_cbSRapprove" value="SR02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbSRbrowse">
                  <input type="checkbox" class="custom-control-input" id="e_cbSRbrowse" name="e_cbSRbrowse" value="SR03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Service Request Approval Engineer') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbSRapprovaleng">
                  <input type="checkbox" class="custom-control-input" id="e_cbSRapprovaleng" name="e_cbSRapprovaleng" value="SR05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  Dua Kelinci status akhir di QC Approval
              <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Acceptance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUA">
                  <input type="checkbox" class="custom-control-input" id="e_cbUA" name="e_cbUA" value="SR04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            
              <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Acceptance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUA">
                  <input type="checkbox" class="custom-control-input" id="e_cbUA" name="e_cbUA" value="SR04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>

            <h4>
            <center><strong>Work Order Menu</strong></center>
            </h4>
            <hr>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('WO Create Without Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoCreatedirect">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoCreatedirect" name="e_cbWoCreatedirect" value="WO06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoMaint">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoMaint" name="e_cbWoMaint" value="WO01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoBrowse">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoBrowse" name="e_cbWoBrowse" value="WO05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <!-- <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Create') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoCreate">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoCreate" name="e_cbWoCreate" value="WO04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> -->
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Release') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoRelease">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoRelease" name="e_cbWoRelease" value="WO09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Warehouse Confirm') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoWhsConf">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoWhsConf" name="e_cbWoWhsConf" value="WO07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Start') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoStart">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoStart" name="e_cbWoStart" value="WO02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Work Order Finish') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoReport">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoReport" name="e_cbWoReport" value="WO03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('WO Approval') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbWoQc">
                  <input type="checkbox" class="custom-control-input" id="e_cbWoQc" name="e_cbWoQc" value="WO08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> 
			      
            <h4>
              <center><strong>Asset Usage</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset PM Calculate') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUSMT">
                  <input type="checkbox" class="custom-control-input" id="e_cbUSMT" name="e_cbUSMT" value="US01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Multi Batch') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUSmultiMT">
                  <input type="checkbox" class="custom-control-input" id="e_cbUSmultiMT" name="e_cbUSmultiMT" value="US02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Generator') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUSGen">
                  <input type="checkbox" class="custom-control-input" id="e_cbUSGen" name="e_cbUSGen" value="US03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Confirm') }}</label>
              <div class="col-6">
                <label class="switch" for="e_pmconf">
                  <input type="checkbox" class="custom-control-input" id="e_pmconf" name="e_pmconf" value="US05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('PM Notif Message') }}</label>
              <div class="col-6">
                <label class="switch" for="e_pmmssg">
                  <input type="checkbox" class="custom-control-input" id="e_pmmssg" name="e_pmmssg" value="US06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart Planning') }}</label>
              <div class="col-6">
                <label class="switch" for="e_ksp">
                  <input type="checkbox" class="custom-control-input" id="e_ksp" name="e_ksp" value="US06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Usage Browse') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbUSBrowse">
                  <input type="checkbox" class="custom-control-input" id="e_cbUSBrowse" name="e_cbUSBrowse" value="US04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>

			
            <!-- Booking -->
            <h4>
              <center><strong>Another Transactions</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Booking Asset') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbBoas">
                  <input type="checkbox" class="custom-control-input" id="e_cbBoas" name="e_cbBoas" value="BO01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('5 Why Transaction') }}</label>
              <div class="col-6">
                <label class="switch" for="e_whyhist">
                  <input type="checkbox" class="custom-control-input" id="e_whyhist" name="e_whyhist" value="BO02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Request Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="e_reqsp">
                  <input type="checkbox" class="custom-control-input" id="e_reqsp" name="e_reqsp" value="BO03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Transfer Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="e_trfsp">
                  <input type="checkbox" class="custom-control-input" id="e_trfsp" name="e_trfsp" value="BO04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Movement ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetMove">
                  <input type="checkbox" class="custom-control-input" id="e_SetMove" name="e_SetMove" value="MT30" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            

            <!-- Reports -->
            <h4>
            <center><strong>Report Menu</strong></center>
            </h4>
            <hr>
            <!-- <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('All Asset Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="cbSRcreate">
                  <input type="checkbox" class="custom-control-input" id="cbSRcreate" name="cbSRcreate" value="RT11" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> -->
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Detail WO Report') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRptDet">
                  <input type="checkbox" class="custom-control-input" id="e_cbRptDet" name="e_cbRptDet" value="RT08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Cost Report') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRptCost">
                  <input type="checkbox" class="custom-control-input" id="e_cbRptCost" name="e_cbRptCost" value="RT09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Report') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbAssetReport">
                  <input type="checkbox" class="custom-control-input" id="e_cbAssetReport" name="e_cbAssetReport" value="RT05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Report') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbEngReport">
                  <input type="checkbox" class="custom-control-input" id="e_cbEngReport" name="e_cbEngReport" value="RT04" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Remaining Sparepart') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRptRemsp">
                  <input type="checkbox" class="custom-control-input" id="e_cbRptRemsp" name="e_cbRptRemsp" value="RT10" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbAssetSchedule">
                  <input type="checkbox" class="custom-control-input" id="e_cbAssetSchedule" name="e_cbAssetSchedule" value="RT03" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Schedule (Year)') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRptSchyear">
                  <input type="checkbox" class="custom-control-input" id="e_cbRptSchyear" name="e_cbRptSchyear" value="RT07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbEngSchedule">
                  <input type="checkbox" class="custom-control-input" id="e_cbEngSchedule" name="e_cbEngSchedule" value="RT01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart Needs') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRptSpneed">
                  <input type="checkbox" class="custom-control-input" id="e_cbRptSpneed" name="e_cbRptSpneed" value="RT06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Booking Schedule') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbBookSchedule">
                  <input type="checkbox" class="custom-control-input" id="e_cbBookSchedule" name="e_cbBookSchedule" value="RT02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            

            <!-- Setting -->
            <h4>
              <center><strong>Settings</strong></center>
            </h4>
            <hr>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Department Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_dept">
                  <input type="checkbox" class="custom-control-input" id="e_dept" name="e_dept" value="MT21" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer Skills Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Skill">
                  <input type="checkbox" class="custom-control-input" id="e_Skill" name="e_Skill" value="MT22" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('User Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Eng">
                  <input type="checkbox" class="custom-control-input" id="e_Eng" name="e_Eng" value="MT01" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Role Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_RoleMaint">
                  <input type="checkbox" class="custom-control-input" id="e_RoleMaint" name="e_RoleMaint" value="MT02" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Engineer Group Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_EngGroup">
                  <input type="checkbox" class="custom-control-input" id="e_EngGroup" name="e_EngGroup" value="MT38" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Running Number Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRunning">
                  <input type="checkbox" class="custom-control-input" id="e_cbRunning" name="e_cbRunning" value="MT99" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('WSA Qxtend Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetWsa">
                  <input type="checkbox" class="custom-control-input" id="e_SetWsa" name="e_SetWsa" value="MT20" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Failure Type Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetFntype">
                  <input type="checkbox" class="custom-control-input" id="e_SetFntype" name="e_SetFntype" value="MT32" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Failure Code Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Fn">
                  <input type="checkbox" class="custom-control-input" id="e_Fn" name="e_Fn" value="MT33" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Impact Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetImp">
                  <input type="checkbox" class="custom-control-input" id="e_SetImp" name="e_SetImp" value="MT34" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Type Maintenance  ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Astype">
                  <input type="checkbox" class="custom-control-input" id="e_Astype" name="e_Astype" value="MT05" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Group Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Asgroup">
                  <input type="checkbox" class="custom-control-input" id="e_Asgroup" name="e_Asgroup" value="MT06" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Supplier Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Supp">
                  <input type="checkbox" class="custom-control-input" id="e_Supp" name="e_Supp" value="MT07" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Asset Site Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetAssetsite">
                  <input type="checkbox" class="custom-control-input" id="e_SetAssetsite" name="e_SetAssetsite" value="MT26" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Location Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetAssetloc">
                  <input type="checkbox" class="custom-control-input" id="e_SetAssetloc" name="e_SetAssetloc" value="MT28" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('UM Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetUm">
                  <input type="checkbox" class="custom-control-input" id="e_SetUm" name="e_SetUm" value="MT36" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Asset">
                  <input type="checkbox" class="custom-control-input" id="e_Asset" name="e_Asset" value="MT08" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Asset Hierarchy Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Aspar">
                  <input type="checkbox" class="custom-control-input" id="e_Aspar" name="e_Aspar" value="MT09" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Engineer For PM') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetEngpm">
                  <input type="checkbox" class="custom-control-input" id="e_SetEngpm" name="e_SetEngpm" value="MT31" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Mapping Asset - Failure') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetAsfn">
                  <input type="checkbox" class="custom-control-input" id="e_SetAsfn" name="e_SetAsfn" value="MT37" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Preventive Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_pmasset">
                  <input type="checkbox" class="custom-control-input" id="e_pmasset" name="e_pmasset" value="MT42" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Type ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Spt">
                  <input type="checkbox" class="custom-control-input" id="e_Spt" name="e_Spt" value="MT10" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Group ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Spg">
                  <input type="checkbox" class="custom-control-input" id="e_Spg" name="e_Spg" value="MT11" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-right min-txt">{{ __('Spare Part Site ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetSpsite">
                  <input type="checkbox" class="custom-control-input" id="e_SetSpsite" name="e_SetSpsite" value="MT27" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Location ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetSploc">
                  <input type="checkbox" class="custom-control-input" id="e_SetSploc" name="e_SetSploc" value="MT29" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Spare Part Code ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Spm">
                  <input type="checkbox" class="custom-control-input" id="e_Spm" name="e_Spm" value="MT12" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Tools Maintenance ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Tool">
                  <input type="checkbox" class="custom-control-input" id="e_Tool" name="e_Tool" value="MT14" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Code ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Rep">
                  <input type="checkbox" class="custom-control-input" id="e_Rep" name="e_Rep" value="MT34" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Group ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetRepgroup">
                  <input type="checkbox" class="custom-control-input" id="e_SetRepgroup" name="e_SetRepgroup" value="MT15" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div> --}}
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Instruction List ') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetIns">
                  <input type="checkbox" class="custom-control-input" id="e_SetIns" name="e_SetIns" value="MT35" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Sparepart List') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetSplist">
                  <input type="checkbox" class="custom-control-input" id="e_SetSplist" name="e_SetSplist" value="MT41" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('QC Specification') }}</label>
              <div class="col-6">
                <label class="switch" for="e_qcspec">
                  <input type="checkbox" class="custom-control-input" id="e_qcspec" name="e_qcspec" value="MT40" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Maintenance Code') }}</label>
              <div class="col-6">
                <label class="switch" for="e_SetPmcode">
                  <input type="checkbox" class="custom-control-input" id="e_SetPmcode" name="e_SetPmcode" value="MT39" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Routine Check Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_rcmmstr">
                  <input type="checkbox" class="custom-control-input" id="e_rcmmstr" name="e_rcmmstr" value="MT43" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Approval SR') }}</label>
              <div class="col-6">
                <label class="switch" for="e_appsr">
                  <input type="checkbox" class="custom-control-input" id="e_appsr" name="e_appsr" value="MT44" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Approval WO') }}</label>
              <div class="col-6">
                <label class="switch" for="e_appwo">
                  <input type="checkbox" class="custom-control-input" id="e_appwo" name="e_appwo" value="MT45" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Source') }}</label>
              <div class="col-6">
                <label class="switch" for="e_invso">
                  <input type="checkbox" class="custom-control-input" id="e_invso" name="e_invso" value="MT46" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Supply') }}</label>
              <div class="col-6">
                <label class="switch" for="e_invsu">
                  <input type="checkbox" class="custom-control-input" id="e_invsu" name="e_invsu" value="MT47" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            {{--  <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Instruction Details Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Ins">
                  <input type="checkbox" class="custom-control-input" id="e_Ins" name="e_Ins" value="MT16" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Instruction Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Repins">
                  <input type="checkbox" class="custom-control-input" id="e_Repins" name="e_Repins" value="MT18" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Part Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Reppart">
                  <input type="checkbox" class="custom-control-input" id="e_Reppart" name="e_Reppart" value="MT17" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Repair Details Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_cbRepdet">
                  <input type="checkbox" class="custom-control-input" id="e_cbRepdet" name="e_cbRepdet" value="MT23" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="level" class="col-6 col-form-label text-md-right full-txt">{{ __('Inventory Data Maintenance') }}</label>
              <div class="col-6">
                <label class="switch" for="e_Inv">
                  <input type="checkbox" class="custom-control-input" id="e_Inv" name="e_Inv" value="MT19" />
                  <div class="slider round"></div>
                </label>
              </div>
            </div>  --}}

              <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="e_btnconf">Save</button>
                <button type="button" class="btn btn-block btn-info" id="e_btnloading" style="display:none">
                  <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
                </button>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--Modal Delete-->
<div class="modal fade deleterole2" id="deleteModal" role="dialog" tabindex="-1" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Role Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="delete" method="post" action="deleterole">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_rolecode" id="tmp_rolecode">
          Delete Role <b> <span id="d_rolecode"></span> -- <span id="d_roledesc"></span> </b> ?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="d_btnclose" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success bt-action" id="d_btnconf">Confirm</button>
          <button type="button" class="btn btn-block btn-info" id="d_btnloading" style="display:none">
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

  $("#new").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnconf').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });

  $("#newedit").submit(function() {
    document.getElementById('e_btnclose').style.display = 'none';
    document.getElementById('e_btnconf').style.display = 'none';
    document.getElementById('e_btnloading').style.display = '';
    
  });

  $("#delete").submit(function() {
    document.getElementById('d_btnclose').style.display = 'none';
    document.getElementById('d_btnconf').style.display = 'none';
    document.getElementById('d_btnloading').style.display = '';
  });

  $(document).on('click', '.deletedata', function() {
    $('#deleteModal').modal('show');

    var role_code = $(this).data('rolecode');
    var role_desc = $(this).data('roledesc');

    document.getElementById('d_roledesc').innerHTML = role_desc;
    document.getElementById('d_rolecode').innerHTML = role_code;
    document.getElementById('tmp_rolecode').value = role_code;
  });

  $(document).on('click', '.editdata', function() {
    $('#editModal').modal('show');
    
    var rolecode = $(this).data('role_code');
    var roledesc = $(this).data('role_desc');
    var roleacc = $(this).data('role_access');
    var access = $(this).data('menu_access');

    document.getElementById('e_rolecode').value = rolecode;
    document.getElementById('e_roledesc').value = roledesc;
    document.getElementById('e_acc').value = roleacc;

    $.ajax({
      type: "get",
      url: "{{URL::to("menugetrole")}}",
      data: {
        search: rolecode,
      },
    
      success: function(data) {
        console.log(data);;
        var listmenu = data;
        
        // Setting
        
        if (listmenu.search("MT21") >= 0) {
          document.getElementById('e_dept').checked = true;
        } else {
          document.getElementById('e_dept').checked = false;
        }
        if (listmenu.search("MT22") >= 0) {
          document.getElementById('e_Skill').checked = true;
        } else {
          document.getElementById('e_Skill').checked = false;
        }
        if (listmenu.search("MT01") >= 0) {
          document.getElementById('e_Eng').checked = true;
        } else {
          document.getElementById('e_Eng').checked = false;
        }
        // if (listmenu.search("MT01") >= 0) {
        //   document.getElementById('e_User').checked = true;
        // } else {
        //   document.getElementById('e_User').checked = false;
        // }
        if (listmenu.search("MT02") >= 0) {
          document.getElementById('e_RoleMaint').checked = true;
        } else {
          document.getElementById('e_RoleMaint').checked = false;
        }
        if (listmenu.search("MT38") >= 0) {
          document.getElementById('e_EngGroup').checked = true;
        } else {
          document.getElementById('e_EngGroup').checked = false;
        }
        if (listmenu.search("MT99") >= 0) {
          document.getElementById('e_cbRunning').checked = true;
        } else {
          document.getElementById('e_cbRunning').checked = false;
        }
        if (listmenu.search("MT20") >= 0) {
          document.getElementById('e_SetWsa').checked = true;
        } else {
          document.getElementById('e_SetWsa').checked = false;
        }
        if (listmenu.search("MT32") >= 0) {
          document.getElementById('e_SetFntype').checked = true;
        } else {
          document.getElementById('e_SetFntype').checked = false;
        }
        if (listmenu.search("MT33") >= 0) {
          document.getElementById('e_Fn').checked = true;
        } else {
          document.getElementById('e_Fn').checked = false;
        }
        if (listmenu.search("MT34") >= 0) {
          document.getElementById('e_SetImp').checked = true;
        } else {
          document.getElementById('e_SetImp').checked = false;
        }
        if (listmenu.search("MT05") >= 0) {
          document.getElementById('e_Astype').checked = true;
        } else {
          document.getElementById('e_Astype').checked = false;
        }
        if (listmenu.search("MT06") >= 0) {
          document.getElementById('e_Asgroup').checked = true;
        } else {
          document.getElementById('e_Asgroup').checked = false;
        }
        if (listmenu.search("MT07") >= 0) {
          document.getElementById('e_Supp').checked = true;
        } else {
          document.getElementById('e_Supp').checked = false;
        }
        if (listmenu.search("MT26") >= 0) {
          document.getElementById('e_SetAssetsite').checked = true;
        } else {
          document.getElementById('e_SetAssetsite').checked = false;
        }
        if (listmenu.search("MT28") >= 0) {
          document.getElementById('e_SetAssetloc').checked = true;
        } else {
          document.getElementById('e_SetAssetloc').checked = false;
        }
        if (listmenu.search("MT08") >= 0) {
          document.getElementById('e_Asset').checked = true;
        } else {
          document.getElementById('e_Asset').checked = false;
        }
        if (listmenu.search("MT09") >= 0) {
          document.getElementById('e_Aspar').checked = true;
        } else {
          document.getElementById('e_Aspar').checked = false;
        }
        if (listmenu.search("MT30") >= 0) {
          document.getElementById('e_SetMove').checked = true;
        } else {
          document.getElementById('e_SetMove').checked = false;
        }
        {{--  if (listmenu.search("MT31") >= 0) {
          document.getElementById('e_SetEngpm').checked = true;
        } else {
          document.getElementById('e_SetEngpm').checked = false;
        }  
        if (listmenu.search("MT10") >= 0) {
          document.getElementById('e_Spt').checked = true;
        } else {
          document.getElementById('e_Spt').checked = false;
        }
        if (listmenu.search("MT11") >= 0) {
          document.getElementById('e_Spg').checked = true;
        } else {
          document.getElementById('e_Spg').checked = false;
        } --}}
        if (listmenu.search("MT27") >= 0) {
          document.getElementById('e_SetSpsite').checked = true;
        } else {
          document.getElementById('e_SetSpsite').checked = false;
        }
        if (listmenu.search("MT29") >= 0) {
          document.getElementById('e_SetSploc').checked = true;
        } else {
          document.getElementById('e_SetSploc').checked = false;
        }
        if (listmenu.search("MT12") >= 0) {
          document.getElementById('e_Spm').checked = true;
        } else {
          document.getElementById('e_Spm').checked = false;
        }
        {{--  if (listmenu.search("MT14") >= 0) {
          document.getElementById('e_Tool').checked = true;
        } else {
          document.getElementById('e_Tool').checked = false;
        }
        if (listmenu.search("MT15") >= 0) {
          document.getElementById('e_Rep').checked = true;
        } else {
          document.getElementById('e_Rep').checked = false;
        }  
        if (listmenu.search("MT34") >= 0) {
          document.getElementById('e_Rep').checked = true;
        } else {
          document.getElementById('e_Rep').checked = false;
        }
        if (listmenu.search("MT15") >= 0) {
          document.getElementById('e_SetRepgroup').checked = true;
        } else {
          document.getElementById('e_SetRepgroup').checked = false;
        } --}}
        if (listmenu.search("MT35") >= 0) {
          document.getElementById('e_SetIns').checked = true;
        } else {
          document.getElementById('e_SetIns').checked = false;
        }
        if (listmenu.search("MT41") >= 0) {
          document.getElementById('e_SetSplist').checked = true;
        } else {
          document.getElementById('e_SetSplist').checked = false;
        }
        if (listmenu.search("MT40") >= 0) {
          document.getElementById('e_qcspec').checked = true;
        } else {
          document.getElementById('e_qcspec').checked = false;
        }
        if (listmenu.search("MT36") >= 0) {
          document.getElementById('e_SetUm').checked = true;
        } else {
          document.getElementById('e_SetUm').checked = false;
        }
        if (listmenu.search("MT37") >= 0) {
          document.getElementById('e_SetAsfn').checked = true;
        } else {
          document.getElementById('e_SetAsfn').checked = false;
        }
        if (listmenu.search("MT42") >= 0) {
          document.getElementById('e_pmasset').checked = true;
        } else {
          document.getElementById('e_pmasset').checked = false;
        }
        if (listmenu.search("MT39") >= 0) {
          document.getElementById('e_SetPmcode').checked = true;
        } else {
          document.getElementById('e_SetPmcode').checked = false;
        }
        if (listmenu.search("MT43") >= 0) {
          document.getElementById('e_rcmmstr').checked = true;
        } else {
          document.getElementById('e_rcmmstr').checked = false;
        }
        if (listmenu.search("MT44") >= 0) {
          document.getElementById('e_appsr').checked = true;
        } else {
          document.getElementById('e_appsr').checked = false;
        }
        if (listmenu.search("MT45") >= 0) {
          document.getElementById('e_appwo').checked = true;
        } else {
          document.getElementById('e_appwo').checked = false;
        }
        if (listmenu.search("MT46") >= 0) {
          document.getElementById('e_invso').checked = true;
        } else {
          document.getElementById('e_invso').checked = false;
        }
        if (listmenu.search("MT47") >= 0) {
          document.getElementById('e_invsu').checked = true;
        } else {
          document.getElementById('e_invsu').checked = false;
        }
        
        {{--  if (listmenu.search("MT03") >= 0) {
          document.getElementById('e_Site').checked = true;
        } else {
          document.getElementById('e_Site').checked = false;
        }
        if (listmenu.search("MT04") >= 0) {
          document.getElementById('e_Loc').checked = true;
        } else {
          document.getElementById('e_Loc').checked = false;
        }
        if (listmenu.search("MT16") >= 0) {
          document.getElementById('e_Ins').checked = true;
        } else {
          document.getElementById('e_Ins').checked = false;
        }
        if (listmenu.search("MT18") >= 0) {
          document.getElementById('e_Repins').checked = true;
        } else {
          document.getElementById('e_Repins').checked = false;
        }
        if (listmenu.search("MT17") >= 0) {
          document.getElementById('e_Reppart').checked = true;
        } else {
          document.getElementById('e_Reppart').checked = false;
        }
        if (listmenu.search("MT23") >= 0) {
          document.getElementById('e_cbRepdet').checked = true;
        } else {
          document.getElementById('e_cbRepdet').checked = false;
        }
        if (listmenu.search("MT19") >= 0) {
          document.getElementById('e_Inv').checked = true;
        } else {
          document.getElementById('e_Inv').checked = false;
        }  --}}
        

        // Work Order
        {{--  if (listmenu.search("WO06") >= 0) {
          document.getElementById('e_cbWoCreatedirect').checked = true;
        } else {
          document.getElementById('e_cbWoCreatedirect').checked = false;
        }  --}}
        if (listmenu.search("WO01") >= 0) {
          document.getElementById('e_cbWoMaint').checked = true;
        } else {
          document.getElementById('e_cbWoMaint').checked = false;
        }
        {{--  if (listmenu.search("WO05") >= 0) {
          document.getElementById('e_cbWoBrowse').checked = true;
        } else {
          document.getElementById('e_cbWoBrowse').checked = false;
        }  --}}
        {{--  if (listmenu.search("WO04") >= 0) {
           document.getElementById('e_cbWoCreate').checked = true;
        } else {
           document.getElementById('e_cbWoCreate').checked = false;
        }  --}}
        if (listmenu.search("WO09") >= 0) {
          document.getElementById('e_cbWoRelease').checked = true;
        } else {
          document.getElementById('e_cbWoRelease').checked = false;
        }
        if (listmenu.search("WO07") >= 0) {
          document.getElementById('e_cbWoWhsConf').checked = true;
        } else {
          document.getElementById('e_cbWoWhsConf').checked = false;
        }
        if (listmenu.search("WO02") >= 0) {
          document.getElementById('e_cbWoStart').checked = true;
        } else {
          document.getElementById('e_cbWoStart').checked = false;
        }
        if (listmenu.search("WO03") >= 0) {
          document.getElementById('e_cbWoReport').checked = true;
        } else {
          document.getElementById('e_cbWoReport').checked = false;
        }
        if (listmenu.search("WO08") >= 0) {
          document.getElementById('e_cbWoQc').checked = true;
        } else {
          document.getElementById('e_cbWoQc').checked = false;
        }

        

        //Service Request
        if (listmenu.search("SR01") >= 0) {
          document.getElementById('e_cbSRcreate').checked = true;
        } else {
          document.getElementById('e_cbSRcreate').checked = false;
        }

        if (listmenu.search("SR02") >= 0) {
          document.getElementById('e_cbSRapprove').checked = true;
        } else {
          document.getElementById('e_cbSRapprove').checked = false;
        }

        if (listmenu.search("SR03") >= 0) {
          document.getElementById('e_cbSRbrowse').checked = true;
        } else {
          document.getElementById('e_cbSRbrowse').checked = false;
        }

        if (listmenu.search("SR05") >= 0) {
          document.getElementById('e_cbSRapprovaleng').checked = true;
        } else {
          document.getElementById('e_cbSRapprovaleng').checked = false;
        }

        {{--  if (listmenu.search("SR04") >= 0) {
          document.getElementById('e_cbUA').checked = true;
        } else {
          document.getElementById('e_cbUA').checked = false;
        }  --}}

        if (listmenu.search("SR04") >= 0) {
          document.getElementById('e_cbUA').checked = true;
        } else {
          document.getElementById('e_cbUA').checked = false;
        }


        // Usage
        if (listmenu.search("US01") >= 0) {
          document.getElementById('e_cbUSMT').checked = true;
        } else {
          document.getElementById('e_cbUSMT').checked = false;
        }
        {{--  if (listmenu.search("US02") >= 0) {
          document.getElementById('e_cbUSmultiMT').checked = true;
        } else {
          document.getElementById('e_cbUSmultiMT').checked = false;
        }  --}}
        if (listmenu.search("US03") >= 0) {
          document.getElementById('e_cbUSGen').checked = true;
        } else {
          document.getElementById('e_cbUSGen').checked = false;
        }
        if (listmenu.search("US05") >= 0) {
          document.getElementById('e_pmconf').checked = true;
        } else {
          document.getElementById('e_pmconf').checked = false;
        }
        if (listmenu.search("US06") >= 0) {
          document.getElementById('e_pmmssg').checked = true;
        } else {
          document.getElementById('e_pmmssg').checked = false;
        }
        if (listmenu.search("US06") >= 0) {
          document.getElementById('e_ksp').checked = true;
        } else {
          document.getElementById('e_ksp').checked = false;
        }
        if (listmenu.search("US04") >= 0) {
          document.getElementById('e_cbUSBrowse').checked = true;
        } else {
          document.getElementById('e_cbUSBrowse').checked = false;
        }

        // Booking
        if (listmenu.search("BO01") >= 0) {
          document.getElementById('e_cbBoas').checked = true;
        } else {
          document.getElementById('e_cbBoas').checked = false;
        }
        if (listmenu.search("BO02") >= 0) {
          document.getElementById('e_whyhist').checked = true;
        } else {
          document.getElementById('e_whyhist').checked = false;
        }
        if (listmenu.search("BO03") >= 0) {
          document.getElementById('e_reqsp').checked = true;
        } else {
          document.getElementById('e_reqsp').checked = false;
        }
        if (listmenu.search("BO04") >= 0) {
          document.getElementById('e_trfsp').checked = true;
        } else {
          document.getElementById('e_trfsp').checked = false;
        }

        //Report
        if (listmenu.search("RT08") >= 0) {
          document.getElementById('e_cbRptDet').checked = true;
        } else {
          document.getElementById('e_cbRptDet').checked = false;
        }
        if (listmenu.search("RT09") >= 0) {
          document.getElementById('e_cbRptCost').checked = true;
        } else {
          document.getElementById('e_cbRptCost').checked = false;
        }
        if (listmenu.search("RT05") >= 0) {
          document.getElementById('e_cbAssetReport').checked = true;
        } else {
          document.getElementById('e_cbAssetReport').checked = false;
        }
        if (listmenu.search("RT04") >= 0) {
          document.getElementById('e_cbEngReport').checked = true;
        } else {
          document.getElementById('e_cbEngReport').checked = false;
        }
        if (listmenu.search("RT10") >= 0) {
          document.getElementById('e_cbRptRemsp').checked = true;
        } else {
          document.getElementById('e_cbRptRemsp').checked = false;
        }
        if (listmenu.search("RT03") >= 0) {
          document.getElementById('e_cbAssetSchedule').checked = true;
        } else {
          document.getElementById('e_cbAssetSchedule').checked = false;
        }
        if (listmenu.search("RT07") >= 0) {
          document.getElementById('e_cbRptSchyear').checked = true;
        } else {
          document.getElementById('e_cbRptSchyear').checked = false;
        }
        if (listmenu.search("RT01") >= 0) {
          document.getElementById('e_cbEngSchedule').checked = true;
        } else {
          document.getElementById('e_cbEngSchedule').checked = false;
        }
        if (listmenu.search("RT06") >= 0) {
          document.getElementById('e_cbRptSpneed').checked = true;
        } else {
          document.getElementById('e_cbRptSpneed').checked = false;
        }
        if (listmenu.search("RT02") >= 0) {
          document.getElementById('e_cbBookSchedule').checked = true;
        } else {
          document.getElementById('e_cbBookSchedule').checked = false;
        }


      }
    });

    // flag tunggu semua menu
  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  function fetch_data(page, sort_type, sort_by, rolecode, roledesc) {
    $.ajax({
      url: "/rolemaster/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&rolecode=" + rolecode + "&roledesc=" + roledesc,
      success: function(data) {
        console.log(data);
        $('tbody').html('');
        $('tbody').html(data);
      }
    })
  }


  
  $(document).on('click', '#btnsearch', function() {
    var rolecode = $('#s_rolecode').val(); //tambahan
    var roledesc = $('#s_roledesc').val(); //tambahan
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = 1;

    document.getElementById("tmprolecode").value =rolecode;
    document.getElementById("tmproledesc").value =roledesc;

    fetch_data(page, sort_type, column_name, rolecode, roledesc);
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
    var rolecode = $('#s_rolecode').val(); 
    var roledesc = $('#s_roledesc').val(); 
    fetch_data(page, reverse_order, column_name, rolecode, roledesc);
  });

  
  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();

    // var rolecode = $('#s_rolecode').val(); 
    // var roledesc = $('#s_roledesc').val(); 

    var rolecode = $('#tmprolecode').val();
    var roledesc = $('#tmproledesc').val();
    fetch_data(page, sort_type, column_name, rolecode, roledesc);

  });

  $(document).on('change','#role_code',function(){

    var role_code = $('#role_code').val();

    $.ajax({
      url: "/cekrole?role_code=" + role_code,
      success: function(data) {
        
        if (data == "ada") {
          alert("Role Already Regitered!!");
          document.getElementById('role_code').value = '';
          document.getElementById('role_code').focus();
        }
        console.log(data);
      
      }
    })
  }); 

  $(document).on('change','#role_desc',function(){

    var role_desc = $('#role_desc').val();

    $.ajax({
      url: "/cekrole?role_code=" + role_desc,
      success: function(data) {
        
        if (data == "ada") {
          alert("Role Description Already Regitered!!");
          document.getElementById('role_desc').value = '';
          document.getElementById('role_desc').focus();
        }
        console.log(data);
      
      }
    })
  });

  $(document).on('change','#e_roledesc',function(){

    var code = $('#e_rolecode').val();
    var desc = $('#e_roledesc').val();

    $.ajax({
      url: "/cekrole2?code=" + code + "&desc=" + desc,
      success: function(data) {
        
        if (data == "ada") {
          alert("Role Description Already Regitered!!");
          document.getElementById('e_roledesc').value = '';
          document.getElementById('e_roledesc').focus();
        }
        console.log(data);
      
      }
    })
  });

  $(document).on('click', '#btnrefresh', function() {
    var rolecode  = ''; 
    var roledesc    = ''; 

    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = 1;

    document.getElementById('s_rolecode').value     = '';
    document.getElementById('s_roledesc').value     = '';
    document.getElementById('tmprolecode').value    = rolecode;
    document.getElementById('tmproledesc').value    = roledesc;

    fetch_data(page, sort_type, column_name, rolecode, roledesc);
  });
</script>
@endsection