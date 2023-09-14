@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Routine Check Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Routine Check Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/rcmmstr" method="GET">
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
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">QC Spec Desc</label>
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
                <th width="20%">Asset Desc</th>
                <th width="10%">QC Spec Code</th>
                <th width="20%">QC Spec Desc</th>
                <th width="10%">Time Check</th>
                <th width="10%">Interval</th>
                <th width="10%">Engineer</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-rcmmstr')
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Routine Check Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/creatrcmmstr">
                {{ csrf_field() }}
                <div class="modal-body">
                  <div class="form-group row">
                     <label for="t_asset" class="col-md-3 col-form-label text-md-right">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_asset" name="t_asset" required>
                        <option value="">-- Select Asset --</option>
                        @foreach($dataasset as $da)
                        <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="t_qcs" class="col-md-3 col-form-label text-md-right">QC Spesification <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_qcs" name="t_qcs" required>
                        <option value="">-- Select QC Specification --</option>
                        @foreach($dataqcs as $dq)
                        <option value="{{$dq->qcs_code}}">{{$dq->qcs_code}} -- {{$dq->qcs_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_start" class="col-md-3 col-form-label text-md-right">Start Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-3">
                        <input type="time" class="form-control" id="t_start" name="t_start" min="00:00" max="23:00" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_end" class="col-md-3 col-form-label text-md-right">End Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-3">
                        <input type="time" class="form-control" id="t_end" name="t_end" min="00:00" max="23:00" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_interval" class="col-md-3 col-form-label text-md-right">Interval <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-3">
                        <input type="number" class="form-control" id="t_interval" name="t_interval" min="1" max="24" required>
                     </div>
                     <label for="t_cal" class="col-md-2 col-form-label text-md-left">Hour</label>
                  </div>
                  <div class="form-group row">
                     <label for="t_eng" class="col-md-3 col-form-label text-md-right">Engineer Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                     <div class="col-md-8">
                        <select class="form-control" id="t_eng" name="t_eng" required>
                        <option value="">-- Select Engineer Group --</option>
                        @foreach($dataegr as $de)
                        <option value="{{$de->egr_code}}">{{$de->egr_code}} -- {{$de->egr_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_email" class="col-md-3 col-form-label text-md-right">Email</label>
                     <div class="col-md-8">
                           <input type="text" class="form-control" id="t_email" name="t_email" autocomplete="off">
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Routine Check Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editrcmmstr">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="form-group row">
                  <label for="te_asset" class="col-md-3 col-form-label text-md-right">Asset</label>
                  <div class="col-md-8">
                     <select class="form-control " id="te_asset" name="te_asset" required>
                     <option value="">--</option>
                     @foreach($dataasset as $da)
                     <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                     @endforeach
                     </select>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="te_qcs" class="col-md-3 col-form-label text-md-right">QC Spesification</label>
                  <div class="col-md-8">
                     <select class="form-control " id="te_qcs" name="te_qcs" required>
                     <option value="">--</option>
                     @foreach($dataqcs as $dq)
                     <option value="{{$dq->qcs_code}}">{{$dq->qcs_code}} -- {{$dq->qcs_desc}}</option>
                     @endforeach
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="te_start" class="col-md-3 col-form-label text-md-right">Start Time</label>
                  <div class="col-md-3">
                     <input type="time" class="form-control" id="te_start" name="te_start" min="00:00" max="23:00" required>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="te_end" class="col-md-3 col-form-label text-md-right">End Time</label>
                  <div class="col-md-3">
                     <input type="time" class="form-control" id="te_end" name="te_end" min="00:00" max="23:00" required>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="te_interval" class="col-md-3 col-form-label text-md-right">Interval</label>
                  <div class="col-md-3">
                     <input type="number" class="form-control" id="te_interval" name="te_interval" min="1" max="24" required>
                  </div>
                  <label for="te_cal" class="col-md-2 col-form-label text-md-left">Hour</label>
               </div>
               <div class="form-group row">
                  <label for="te_eng" class="col-md-3 col-form-label text-md-right">Engineer</label>
                  <div class="col-md-8">
                     <select class="form-control" id="te_eng" name="te_eng">
                     @foreach($dataegr as $de)
                     <option value="{{$de->egr_code}}">{{$de->egr_code}} -- {{$de->egr_desc}}</option>
                     @endforeach
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="te_email" class="col-md-3 col-form-label text-md-right">Email</label>
                  <div class="col-md-8">
                        <input type="text" class="form-control" id="te_email" name="te_email" autocomplete="off">
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Routine Check Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delrcmmstr">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_asset" name="d_asset">
                    <input type="hidden" id="d_qcs" name="d_qcs">
                    Delete Routine Check <b><span id="td_asset"></span></b> with Spesification <b> <span id="td_qcs"></span></b> ?
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
           var qcs = $(this).data('qcs');
           var start = $(this).data('start');
           var end = $(this).data('end');
           var interval = $(this).data('interval');
           var eng = $(this).data('eng');
           var email = $(this).data('email');

           document.getElementById('te_asset').value = asset;
           document.getElementById('te_qcs').value = qcs;
           document.getElementById('te_start').value = start;
           document.getElementById('te_end').value = end;
           document.getElementById('te_interval').value = interval;
           document.getElementById('te_eng').value = eng;
           document.getElementById('te_email').value = email;

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var asset = $(this).data('asset');
            var qcs = $(this).data('qcs');
            var assetdesc = $(this).data('assetdesc');
            var qcsdesc = $(this).data('qcsdesc');

            document.getElementById('d_asset').value          = asset;
            document.getElementById('d_qcs').value          = qcs;
            document.getElementById('td_asset').innerHTML = assetdesc + "(" + asset + ")" ;
            document.getElementById('td_qcs').innerHTML = qcsdesc;
       });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
        });   

         $("#t_asset").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#t_qcs").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#t_eng").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         //cek dobel code saat menu Create
        $(document).on('change', '#t_qcs', function() {
            var qcs = $('#t_qcs').val();
            var asset = $('#t_asset').val();
    
                $.ajax({
                url:"/cekrcmlist?asset="+asset+"&qcs="+qcs ,
                success: function(data) {
                    
                    if (data == "ada") {
                    alert("Data Already Registered!");
                    document.getElementById('t_qcs').value = '';
                    document.getElementById('t_qcs').focus();
                    }
                    console.log(data);
                
                }
                })
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