@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Preventive Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Preventive Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/pmasset" method="GET">
<!-- Bagian Searching -->
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Maintenance Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="col-md-12"><hr></div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Asset</th>
                <th width="25%">Asset Desc</th>
                <th width="10%">Mtc Code</th>
                <th width="25%">Mtc Desc</th>
                <th width="7%">Mea</th>
                <th width="7%">Value</th>
                <th width="7%">UM</th>
                <th width="7%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-pmasset')
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Preventive Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/creatpmasset">
                {{ csrf_field() }}
                <div class="modal-body">
                  <div class="form-group row">
                     <label for="t_asset" class="col-md-3 col-form-label text-md-right">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_asset" name="t_asset" required>
                        <option value="">-- Select Data --</option>
                        @foreach($dataasset as $da)
                        <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="t_pmcode" class="col-md-3 col-form-label text-md-right">Maintenance Code</label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_pmcode" name="t_pmcode">
                        <option value="">-- Select Data --</option>
                        @foreach($datapm as $dp)
                        <option value="{{$dp->pmc_code}}">{{$dp->pmc_code}} -- {{$dp->pmc_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_time" class="col-md-3 col-form-label text-md-right">Lead Time</label>
                     <div class="col-md-3">
                           <input type="number" class="form-control" id="t_time" name="t_time" autocomplete="off" step="0.01">
                     </div>
                     <label for="t_time" class="col-md-2 col-form-label text-md-left">Days</label>
                  </div>
                  <div class="form-group row">
                     <label for="t_mea" class="col-md-3 col-form-label text-md-right">Measurement <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-4">
                     <select class="form-control " id="t_mea" name="t_mea" required>
                        <option value="">--</option>
                        <option value="C">Caledar</option>
                        <option value="M">Meter</option>
                        <option value="B">Both</option>
                     </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_cal" class="col-md-3 col-form-label text-md-right">Calendar</label>
                     <div class="col-md-3">
                           <input type="number" class="form-control" id="t_cal" name="t_cal" autocomplete="off" min="0">
                     </div>
                     <label for="t_cal" class="col-md-2 col-form-label text-md-left">Days</label>
                  </div>
                  <div class="form-group row">
                     <label for="t_meter" class="col-md-3 col-form-label text-md-right">Meter</label>
                     <div class="col-md-3">
                           <input type="number" class="form-control" id="t_meter" name="t_meter" autocomplete="off" min="0" step="0.1">
                     </div>
                     <div class="col-md-3">
                        <select class="form-control" id="t_durum" name="t_durum">
                           <option value=""></option>
                           @foreach($dataum as $du)
                           <option value="{{$du->um_code}}">{{$du->um_code}} -- {{$du->um_desc}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_tol" class="col-md-3 col-form-label text-md-right">Safety Time</label>
                     <div class="col-md-3">
                           <input type="number" class="form-control" id="t_tol" name="t_tol" autocomplete="off">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_start" class="col-md-3 col-form-label text-md-right">Last Maintenance <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-3">
                           <input type="date" class="form-control" id="t_start" name="t_start" autocomplete="off" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_eng" class="col-md-3 col-form-label text-md-right">Engineer <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-8">
                        <select class="form-control" multiple size="3" id="t_eng" name="t_eng[]" required>
                        @foreach($dataeng as $de)
                        <option value="{{$de->eng_code}}">{{$de->eng_code}} -- {{$de->eng_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Preventive Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editpmasset">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_asset" class="col-md-3 col-form-label text-md-right">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="te_asset" name="te_asset" readonly>
                        <input type="hidden" class="form-control" id="te_pmaid" name="te_pmaid">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_pmcode" class="col-md-3 col-form-label text-md-right">Maintenance Code</label>
                    <div class="col-md-8">
                       <select id="te_pmcode" class="form-control" name="te_pmcode" >
                        <option value="">--Select Data--</option>
                        @foreach($datapm as $r)
                            <option value="{{$r->pmc_code}}">{{$r->pmc_code}} -- {{$r->pmc_code}}</option>
                        @endforeach
                    </select>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_time" class="col-md-3 col-form-label text-md-right">Lead Time</label>
                    <div class="col-md-3">
                          <input type="number" class="form-control" id="te_time" name="te_time" autocomplete="off" step="0.01">
                    </div>
                    <label for="t_time" class="col-md-2 col-form-label text-md-left">Days</label>
                 </div>
                 <div class="form-group row">
                    <label for="te_mea" class="col-md-3 col-form-label text-md-right">Measurement <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-4">
                    <select class="form-control " id="te_mea" name="te_mea" required>
                       <option value="">--</option>
                       <option value="C">Caledar</option>
                       <option value="M">Meter</option>
                       <option value="B">Both</option>
                    </select>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_cal" class="col-md-3 col-form-label text-md-right">Calendar</label>
                    <div class="col-md-3">
                          <input type="number" class="form-control" id="te_cal" name="te_cal" autocomplete="off" min="0">
                    </div>
                    <label for="t_cal" class="col-md-2 col-form-label text-md-left">Days</label>
                 </div>
                 <div class="form-group row">
                    <label for="te_meter" class="col-md-3 col-form-label text-md-right">Meter</label>
                    <div class="col-md-3">
                          <input type="number" class="form-control" id="te_meter" name="te_meter" autocomplete="off" min="0" step="0.1">
                    </div>
                    <div class="col-md-3">
                       <select class="form-control" id="te_durum" name="te_durum">
                        <option value="">--</option>
                          @foreach($dataum as $du)
                          <option value="{{$du->um_code}}">{{$du->um_code}} -- {{$du->um_desc}}</option>
                          @endforeach
                       </select>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_tol" class="col-md-3 col-form-label text-md-right">Safety Time</label>
                    <div class="col-md-3">
                          <input type="number" class="form-control" id="te_tol" name="te_tol" autocomplete="off">
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_start" class="col-md-3 col-form-label text-md-right">Last Maintenance</label>
                    <div class="col-md-3">
                          <input type="date" class="form-control" id="te_start" name="te_start" autocomplete="off" readonly>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="te_eng" class="col-md-3 col-form-label text-md-right">Engineer <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-8">
                       <select class="form-control" multiple size="3" id="te_eng" name="te_eng[]" required>
                       </select>
                       <input type="hidden" id="te_pickeng" name="te_pickeng">
                    </div>
                 </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Preventive Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delpmasset">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_asset" name="d_asset">
                    <input type="hidden" id="d_pmcode" name="d_pmcode">
                    Delete Preventive <b><span id="td_asset"></span> -- <span id="td_pmcode"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var counter = 1;

        function selectPicker() {
            $('.selectpicker').selectpicker().focus();
        }

       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var asset = $(this).data('asset');
           var pmcode = $(this).data('pmcode');
           var time = $(this).data('time');
           var mea = $(this).data('mea');
           var cal = $(this).data('cal');
           var meter = $(this).data('meter');
           var meterum = $(this).data('meterum');
           var tolerance = $(this).data('tolerance');
           var start = $(this).data('start');
           var eng = $(this).data('eng');
           var pmaid = $(this).data('pmaid');

           document.getElementById('te_asset').value = asset;
           document.getElementById('te_pmcode').value = pmcode;
           document.getElementById('te_time').value = time;
           document.getElementById('te_mea').value = mea;
           document.getElementById('te_cal').value = cal;
           document.getElementById('te_meter').value = meter;
           document.getElementById('te_durum').value = meterum;
           document.getElementById('te_tol').value = tolerance;
           document.getElementById('te_start').value = start;
           document.getElementById('te_pickeng').value = eng;
           document.getElementById('te_pmaid').value = pmaid;
           
           editpickeng();

           $("#te_pmcode").select2({
            width : '100%',
            theme : 'bootstrap4',
         });
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var asset = $(this).data('asset');
            var pmcode = $(this).data('pmcode');
            var assetdesc = $(this).data('assetdesc');
            var pmcodedesc = $(this).data('pmcodedesc');

            document.getElementById('d_asset').value          = asset;
            document.getElementById('d_pmcode').value          = pmcode;
            document.getElementById('td_asset').innerHTML = assetdesc + "(" + asset + ")" ;
            document.getElementById('td_pmcode').innerHTML = pmcodedesc;
       });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
        });   

         $("#t_asset").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#t_pmcode").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         function pickeng(){

            $.ajax({
                url:"/pickeng",
                success: function(data) {
                    var jmldata = data.length;

                    var eng_code = [];
                    var eng_desc = [];
                    var test = [];

                    test += '<option value="">--Select Engineer--</option>';

                    for(i = 0; i < jmldata; i++){
                        eng_code.push(data[i].eng_code);
                        eng_desc.push(data[i].eng_desc);
 
                        test += '<option value=' + eng_code[i] + '>' + eng_code[i] + '--' + eng_desc[i] + '</option>';                   
                    }
                   
                    $('#t_eng').html('').append(test); 
                }
            })
        }

        pickeng();

         $("#t_eng").select2({
            width : '100%',
            placeholder : '',
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
        });

        function editpickeng(){
            var eng = $('#te_pickeng').val();
            var a = eng.split(";");

            $.ajax({
                url:"/pickeng",
                success: function(data) {
                    var jmldata = data.length;

                    var eng_code = [];
                    var eng_desc = [];
                    var test = [];

                    test += '<option value="">--Select Engineer--</option>';

                    for(i = 0; i < jmldata; i++){
                        eng_code.push(data[i].eng_code);
                        eng_desc.push(data[i].eng_desc);

                        if (a.includes(eng_code[i])) {
                            test += '<option value=' + eng_code[i] + ' selected>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + eng_code[i] + '>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
                        }                        
                    }

                    $('#te_eng').html('').append(test); 
                }
            })
        }

        $("#te_eng").select2({
            width : '100%',
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
        });

        $(document).on('change', '#t_mea', function() {
            var asset = $('#t_asset').val();
            var pmcode = $('#t_pmcode').val();
  
              $.ajax({
                url:"/cekpmmtc?asset="+asset+"&pmcode="+pmcode ,
                success: function(data) {
                  console.log(data);
                  if (data == "ada") {
                    alert("Asset code with PM code selected is already registered!!!");
                    document.getElementById('t_pmcode').value = '';
                    document.getElementById('t_pmcode').focus();
                  }
                  console.log(data);
                
                }
              })

              $("#t_pmcode").select2({
                width : '100%',
                theme : 'bootstrap4',
             });
          });
          
          $(document).on('change', '#t_pmcode', function() {
            var asset = $('#t_asset').val();
            var pmcode = $('#t_pmcode').val();
  
              $.ajax({
                url:"/cekpmmtc?asset="+asset+"&pmcode="+pmcode ,
                success: function(data) {
                  console.log(data);
                  if (data == "ada") {
                    alert("Asset code with PM code selected is already registered!!!");
                    document.getElementById('t_pmcode').selectedIndex = 0;
                    document.getElementById('t_pmcode').focus();
                  }
                  console.log(data);
                
                }
              })
          });

          $("#t_durum").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#te_durum").select2({
            width : '100%',
            theme : 'bootstrap4',
         });


          $(document).on('change', '#t_mea', function() {
            var mea = $('#t_mea').val();
            
            switch (mea) {
                case "C":
                  document.getElementById('t_cal').required = true;
                  document.getElementById('t_meter').required = false;
                  document.getElementById('t_durum').required = false;
                  break;
                case "M":
                  document.getElementById('t_cal').required = false;
                  document.getElementById('t_meter').required = true;
                  document.getElementById('t_durum').required = true;
                  break;
                case "B":
                  document.getElementById('t_cal').required = true;
                  document.getElementById('t_meter').required = true;
                  document.getElementById('t_durum').required = true;
                  break;
                // tambahkan case lain jika diperlukan
                default:
                  // tindakan yang dilakukan jika nilai mea tidak cocok dengan case di atas
                  document.getElementById('t_cal').required = false;
                  document.getElementById('t_meter').required = false;
                  document.getElementById('t_durum').required = false;
                  break;
            }            
          });

          $(document).on('change', '#te_mea', function() {
            var mea = $('#te_mea').val();
 
            switch (mea) {
                case "C":
                  document.getElementById('te_cal').required = true;
                  document.getElementById('te_meter').required = false;
                  document.getElementById('te_durum').required = false;
                  break;
                case "M":
                  document.getElementById('te_cal').required = false;
                  document.getElementById('te_meter').required = true;
                  document.getElementById('te_durum').required = true;
                  break;
                case "B":
                  document.getElementById('te_cal').required = true;
                  document.getElementById('te_meter').required = true;
                  document.getElementById('te_durum').required = true;
                  break;
                // tambahkan case lain jika diperlukan
                default:
                  // tindakan yang dilakukan jika nilai mea tidak cocok dengan case di atas
                  document.getElementById('te_cal').required = false;
                  document.getElementById('te_meter').required = false;
                  document.getElementById('te_durum').required = false;
                  break;
            }            
          });

    </script>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script> -->

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection