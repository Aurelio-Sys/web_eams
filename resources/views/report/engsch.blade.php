@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
<div class="row justify-content-between">
  <div class="col-sm-6">
    <div class="d-flex">
        <h1 class="m-0 text-dark">&nbsp;&nbsp;Engineer Schedule</h1>
    </div>
  </div><!-- /.col -->
  <div style="text-align: right">
    Work Order Status  :  
    <span class="badge badge-primary">Firm</span>
    {{--  <span class="badge badge-danger">Open</span>  --}}
    <span class="badge badge-success">Started</span>
    <span class="badge badge-warning">Finish</span>
    <span class="badge badge-secondary">Closed</span>
</div>
</div><!-- /.row -->
<br>
<div class="row">      
  <div class="col-sm-12">
    <div class="d-flex justify-content-between">                
            <form class="form-horizontal col-md-12" method="get" action="/engsch">
                {{ csrf_field() }}

                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="row col-md-12">
                          <div class="col-md-6">
                            <div class="row col-md-12">
                              <div class="col-md-4">
                                  <label class="col-form-label">Engineer</label>
                              </div>
                              <div class="col-md-8">
                                  <select id="engcode" class="form-control" name="engcode">
                                      <option value="">--Select Data--</option>
                                    @foreach($dataeng as $da)
                                        <option value="{{$da->eng_code}}">{{$da->eng_code}} -- {{$da->eng_desc}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-md-4">
                                  <label for="s_dept" class="col-form-label text-md-left">Departement</label>
                              </div>
                              <div class="col-md-8">
                                  <select id="s_dept" class="form-control" name="s_dept">
                                      <option value="">--Select Data--</option>
                                    @foreach($datadept as $dd)
                                        <option value="{{$dd->dept_code}}">{{$dd->dept_code}} -- {{$dd->dept_desc}}</option>
                                      @endforeach
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-1">
                              <label for="t_type" class="col-form-label text-md-right">Type</label>    
                          </div>
                          <div class="col-md-2">
                              <select class="form-control" id="wotype" name="wotype">
                                  <option value="All" selected="selected">All</option>
                                  <option value="PM">PM</option>
                                  <option value="CM">CM</option>
                              </select>
                          </div>
                          <div class="col-md-3">
                              <div class="row">
                                  <button type="submit" class="btn btn-primary bt-action" id="btnedit">Search</button>
                                  &ensp;
                                  <a href="/engsch" id="maju"  class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'><i class="fas fa-sync-alt"></i></a>
                              </div>
                          </div>
                        </div>

                        <!-- Label kosong untuk spasi -->
                        <label class="col-md-12"></label>
                        <div>
                            <h1 class="m-0 text-dark text-center">
                                <a href="/engsch?bulan={{$bulan}}&stat=mundur&engcode={{$engcode}}&wotype={{$wotype}}&dept={{$sdept}}" id="mundur"><i class="fas fa-angle-left"></i></a>
                                &ensp;&ensp;{{$bulan}}&ensp;&ensp;
                                <input type='hidden' name='bulan' id='bulan' value='{{$bulan}}'>
                                <a href="/engsch?bulan={{$bulan}}&stat=maju&engcode={{$engcode}}&wotype={{$wotype}}&dept={{$sdept}}" id="maju" ><i class="fas fa-angle-right"></i></a>
                            </h1>
                        </div>
                    </div>
                    
                    @if(!$fotoeng)
                    @else
                        <div class="col-md-2 " colspan='2'>
                            <img src="/upload/{{$fotoeng->eng_photo}}" class="rounded float-right" width="auto" height="100px" id="foto1">
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
                    <td>
                        {{$i}}
                        <br>
                        @if($ds == 1)
                            @php($ds = $datawo->where('tgl','=',$i)->first())
                            @include('report.engsch-det')
                        @elseif($ds > 1)
                            @foreach($datawo as $ds)
                                @if($ds->tgl == $i)
                                    @include('report.engsch-det')
                                @endif
                            @endforeach
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
            </tr>
            @if($stop == 1)
                @break
            @endif
        @endfor
    </tbody>
    </table>
    
</body>

<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
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

@endsection('content')
@section('scripts')
<script type="text/javascript">
    document.getElementById('engcode').value = "{{$engcode}}";
    document.getElementById('wotype').value = "{{$wotype}}";
    document.getElementById('s_dept').value = "{{$sdept}}";

    $(document).on('click', '.viewwo', function() {
      $('#viewModal').modal('show');
      var wonbr = $(this).data('wonbr');
      {{--  var srnumber = $(this).data('srnumber');
      var btnendel1 = document.getElementById("btndeleteen1");
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
          url: "/listuploadview/" + srnumber,
          success: function(data) {
            // console.log(data);
            $('#munculgambar_view_sr').html('').append(data);
          }
        })
    });

    $("#engcode").select2({
        width : '100%',
        theme : 'bootstrap4',
        
    });
    $("#s_dept").select2({
      width : '100%',
      theme : 'bootstrap4',
      
  });

</script>
@endsection