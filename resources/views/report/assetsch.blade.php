@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div>
            <div class="d-flex">
                <h1 class="m-0 text-dark">Asset Maintenance Schedule</h1>
            </div>
          </div><!-- /.col -->
          <div>
            Work Order Status  :  
            <span class="badge badge-info">Plan</span>
            <span class="badge badge-danger">Firm</span>
            <span class="badge badge-primary">Released</span>
            <span class="badge badge-success">Started</span>
            <span class="badge badge-warning">Finish</span>
            <span class="badge badge-secondary">Closed</span>
          </div>
        </div><!-- /.row -->
        <br>
             <div class="row">
              
          <div class="col-sm-12">
            <div class="d-flex justify-content-between">
                    <form class="form-horizontal col-md-12" method="get" action="/assetsch">
                        {{ csrf_field() }}

                        @if(!$foto)
                            @php($dtasset = "")
                        @else
                            @php($dtasset = $foto->asset_code)
                        @endif

                        <div class="row col-md-12">
                            <div class="col-md-2">
                                <label for="t_asset" class="col-form-label text-md-right">Asset Code</label>
                                <br><br>
                                <label for="t_asset" class="col-form-label text-md-right">Location</label>
                                <br><br>
                                <label class="col-form-label text-md-right">Status</label>
                            </div>
                            <div class="col-md-6">
                                <select id="t_asset" class="form-control" name="t_asset">
                                    <option value="">--Select Data--</option>
                                   @foreach($dataAsset as $da)
                                      <option value="{{$da->asset_code}}" {{$dtasset === $da->asset_code ? "selected" : ""}}>{{$da->asset_code}} -- {{$da->asset_desc}} -- {{$da->asloc_desc}} </option>
                                    @endforeach
                                </select>
                                <br>
                                <select id="t_loc" class="form-control" name="t_loc">
                                  <option value="">--Select Data--</option>
                                 @foreach($dataloc as $dl)
                                    <option value="{{$dl->asloc_code}}" {{$sloc === $dl->asloc_code ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
                                  @endforeach
                                </select>
                                <br>
                                <select id="t_status" class="form-control" name="t_status">
                                  <option value="">--Select Status--</option>
                                  <option value="plan" {{$sstatus === "plan" ? "selected" : ""}}>Plan</option>
                                  <option value="firm" {{$sstatus === "firm" ? "selected" : ""}}>Firm</option>
                                  <option value="released" {{$sstatus === "released" ? "selected" : ""}}>Released</option>
                                  <option value="started" {{$sstatus === "started" ? "selected" : ""}}>Started</option>
                                  <option value="finished" {{$sstatus === "finished" ? "selected" : ""}}>Finished</option>
                                  <option value="closed" {{$sstatus === "closed" ? "selected" : ""}}>Closed</option>
                                  <option value="canceled" {{$sstatus === "canceled" ? "selected" : ""}}>Canceled</option>
                                  <option value="acceptance" {{$sstatus === "acceptance" ? "selected" : ""}}>Acceptance</option>
                                </select>
                                <!-- Label kosong untuk spasi -->
                                <label class="col-md-12>"></label>
                                <div>
                                <h1 class="m-0 text-dark text-center">
                                    <a href="/assetsch?bulan={{$bulan}}&stat=mundur&t_asset={{$dtasset}}&t_loc={{$sloc}}&t_status={{$sstatus}}" ><i class="fas fa-angle-left"></i></a>
                                    &ensp;&ensp;{{$bulan}}&ensp;&ensp;
                                    <input type='hidden' name='bulan' id='bulan' value='{{$bulan}}'>
                                    <a href="/assetsch?bulan={{$bulan}}&stat=maju&t_asset={{$dtasset}}&t_loc={{$sloc}}&t_status={{$sstatus}}" ><i class="fas fa-angle-right"></i></a>
                                </h1>
                            </div>
                            </div>
                            <div class="col-md-2">
                                <div class= "row">
                                    <button type="submit" class="btn btn-primary bt-action" id="btnedit">Search</button>
                                    &ensp;
                                    <a href="/assetsch"  class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>

                            @if(!$foto)
                            @else
                                <div class="col-md-2 " colspan='2'>
                                    <img src="/uploadassetimage/{{$foto->asset_image}}" class="rounded float-right" width="auto" height="100px" id="foto1">
                                </div>
                            @endif

                        </div>

                    </form>   

                      
                
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->

       
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<head>
    <title>Chart</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</head>
<body>
<style>
    table {
        table-layout:fixed;
    }
    th {
        text-align: center;
    }
    td {
        width: 100px;
        height: 100px;
        text-align: right;
        overflow: auto;
    }
</style>
    <table class="table table-bordered">
    <thead class="table-info">
        <tr>
        <th scope="col">Monday</th>
        <th scope="col">Tuesday</th>
        <th scope="col">Wednesday</th>
        <th scope="col">Thursday</th>
        <th scope="col">Friday</th>
        <th scope="col">Saturday</th>
        <th scope="col">Sunday</th>
        </tr>
    </thead>
    <tbody>
        @php($i = 1)
        @php($stop = 0)
        @for($x = 1; $x <= 6; $x++)
        <tr>
            @if($i == 1)
                @for($z = 1; $z <= $kosong; $z++)
                    <td></td>
                @endfor
            @else 
                @php($z = 1)
            @endif
            @for($y = $z; $y <= 7; $y++)
                @if($i > $skrg)
                    <td></td>
                @else
                    @php($ds = $datawo->where('tgl','=',$i)->count())
                    @php($dp = $datapm->where('tgl','=',$i)->count())
                    <td>
                        {{$i}}
                        <br>
                        {{--  Menampilkan data WO  --}}
                        @if($ds == 1)
                            @php($ds = $datawo->where('tgl','=',$i)->first())
                            @include('report.assetsch-det')
                        @elseif($ds > 1)
                            @foreach($datawo as $ds)
                                @if($ds->tgl == $i)
                                    @include('report.assetsch-det')
                                @endif
                            @endforeach
                        @endif

                        {{--  Menampilkan data PM yang belum confirm   --}}
                        @if($dp == 1)
                            @php($dp = $datapm->where('tgl','=',$i)->first())
                            @include('report.assetsch-detpm')
                        @elseif($dp > 1)
                            @foreach($datapm as $dp)
                                @if($dp->tgl == $i)
                                    @include('report.assetsch-detpm')
                                @endif
                            @endforeach
                        @endif

                        {{--  Menampilkan reminder asset renewal data dari asset_mstr field asset_renew  --}}
                        @php($tglrenew = 0)
                        @php($angkaBulan = date('m', strtotime($bulan)))
                        @php($stringTanggal = sprintf('%02d-%02d-%04d', $i, $angkaBulan, substr($bulan, -4)))
                        @php($tanggalObj = DateTime::createFromFormat('d-m-Y', $stringTanggal))
                        @php($tglrenew = $datarenew->where('asset_renew','=',$tanggalObj->format('Y-m-d')))
                        @if($tglrenew->count() > 0)
                          <a href="javascript:void(0)" class="viewrenew" data-toggle="modal"  title="View Asset"  data-target="#renewModal"
                            data-tglrenew="aa"> 
                            <span class="badge badge-danger">Asset Renewal</span>
                          </a>
                        @endif
                    </td>
                @endif
                @if($i == $skrg)
                    @php($stop = 1)
                    @break
                @else
                    @php($i += 1)
                @endif
            @endfor
            @if($stop == 1)
                @break
            @endif
        @endfor
    </tbody>
    </table>
    
</body>

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
            <!-- <label for="v_duedate" class="col-md-2 col-form-label text-md-left">Due Date</label>
            <div class="col-md-4">
              <input id="v_duedate" type="date" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}" autofocus readonly>
            </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!--Modal PM View-->
<div class="modal fade" id="viewpmModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Preventive Maintenance Planning View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="pm_asset" class="col-md-2 col-form-label text-md-left">Asset Code</label>
          <div class="col-md-4">
            <input type="text" readonly id="pm_asset" type="text" class="form-control pm_asset" name="pm_asset">
          </div>
          <label for="pm_assetloc" class="col-md-2 col-form-label text-md-left">Location</label>
          <div class="col-md-4">
            <input id="pm_assetloc" type="text" class="form-control" name="pm_assetloc" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="pm_assetdesc" class="col-md-2 col-form-label text-md-left">Asset Desc</label>
          <div class="col-md-4">
            <input type="text" readonly id="pm_assetdesc" type="text" class="form-control pm_assetdesc" name="pm_assetdesc">
          </div>
          <label for="pm_eng" class="col-md-2 col-form-label text-md-left">Engineer List</label>
          <div class="col-md-4">
            <textarea id="pm_eng" class="form-control pm_eng" name="pm_eng" readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="pm_startdate" class="col-md-2 col-form-label text-md-left">Schedule Date</label>
          <div class="col-md-4">
            <input id="pm_startdate" readonly type="text" class="form-control" name="pm_startdate">
          </div>
          <label for="pm_duedate" class="col-md-2 col-form-label text-md-left">Due Date</label>
          <div class="col-md-4">
            <input id="pm_duedate" type="text" class="form-control" name="pm_duedate" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="pm_pmcode" class="col-md-2 col-form-label text-md-left">PM Code</label>
          <div class="col-md-4">
            <input id="pm_pmcode" readonly type="text" class="form-control" name="pm_pmcode">
          </div>
          <label for="pm_pmmea" class="col-md-2 col-form-label text-md-left">Measurement</label>
          <div class="col-md-4">
            <input id="pm_pmmea" type="text" class="form-control" name="pm_pmmea" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="pm_lastno" class="col-md-2 col-form-label text-md-left">Last Maintenance Number</label>
          <div class="col-md-4">
            <input id="pm_lastno" readonly type="text" class="form-control" name="pm_lastno">
          </div>
          <label for="pm_lastdate" class="col-md-2 col-form-label text-md-left">Last Maintenance Date</label>
          <div class="col-md-4">
            <input id="pm_lastdate" type="text" class="form-control" name="pm_lastdate" readonly>
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

<!--Modal Renew-->
<div class="modal fade" id="renewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Renewal View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="v_counter" value=0>
      <div class="modal-body">
        <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="tabelRenew">

                </tbody>
              </table>  
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!--Modal Loading-->
<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>
  </div>
</div>

@endsection('content')

@section('scripts')
<script type="text/javascript">

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
          var duedate = vamp.wo_master.wo_due_date;
          var createdby = vamp.wo_master.wo_createdby;
          var department = vamp.wo_master.wo_department ? vamp.wo_master.wo_department : '';
          var deptdesc = vamp.dept_desc.dept_desc ? vamp.dept_desc.dept_desc : '';
          var rejectreason = vamp.sr_acceptance_note ? vamp.sr_acceptance_note : '';
          var status = vamp.wo_master.wo_status;
          var wotype = vamp.wo_master.wo_type;
          var wostart = vamp.wo_master.wo_job_startdate ? vamp.wo_master.wo_job_startdate : "";
          var wofinish = vamp.wo_master.wo_job_finishdate ? vamp.wo_master.wo_job_finishdate : "";
          var wofinishtime = vamp.wo_master.wo_job_finishtime ? vamp.wo_master.wo_job_finishtime : "";
          var wostarttime = vamp.wo_master.wo_job_starttime ? vamp.wo_master.wo_job_starttime : "";

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
          document.getElementById('v_startdate').value = startdate.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
          document.getElementById('v_duedate').value = duedate.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
          document.getElementById('v_creator').value = createdby;
          document.getElementById('v_dept').value = department + ' - ' + deptdesc;
          document.getElementById('v_srnote').value = srnote;
          document.getElementById('v_rejectreason').value = rejectreason;
          document.getElementById('v_status').value = status;
          document.getElementById('v_wotype').value = wotype;
          document.getElementById('v_wostart').value = wostart.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1") + " " + wostarttime;
          document.getElementById('v_wofinish').value = wofinish.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1") + " " + wofinishtime;
          
  
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
          url: "/listuploadview/" + srnumber,
          success: function(data) {
            // console.log(data);
            $('#munculgambar_view_sr').html('').append(data);
          }
        })
    });
    // flag tunggu semua menu  --}}

    $("#t_asset").select2({
        width : '100%',
        theme : 'bootstrap4',   
    });
    $("#t_loc").select2({
      width : '100%',
      theme : 'bootstrap4',   
  });

  $(document).on('click', '.viewpm', function() {
    $('#viewpmModal').modal('show');
    var asset = $(this).data('asset');
    var assetdesc = $(this).data('assetdesc');
    var assetloc = $(this).data('assetloc');
    var eng = $(this).data('eng');
    var startdate = $(this).data('startdate');
    var duedate= $(this).data('duedate');
    var pmmea= $(this).data('pmmea');
    var pmcode= $(this).data('pmcode');
    var lastno= $(this).data('lastno');
    var lastdate= $(this).data('lastdate');

    document.getElementById('pm_asset').value = asset;
    document.getElementById('pm_assetdesc').value = assetdesc;
    document.getElementById('pm_assetloc').value = assetloc;
    document.getElementById('pm_eng').value = eng;
    document.getElementById('pm_startdate').value = startdate.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
    document.getElementById('pm_duedate').value = duedate.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
    document.getElementById('pm_pmcode').value = pmcode;
    document.getElementById('pm_pmmea').value = pmmea;
    document.getElementById('pm_lastno').value = lastno;
    document.getElementById('pm_lastdate').value = lastdate.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");

  });

  $(document).on('click', '.viewrenew', function() {
    $('#renewModal').modal('show');
    var tglrenew = $(this).data('tglrenew');
    {{--  alert(tglrenew);
  
    $.ajax({
      url: "/listuploadviewxx/" + srnumber,
      success: function(data) {
        // console.log(data);
        $('#tabelRenew').html('').append(data);
      }
    })  --}}
  });

</script>
@endsection