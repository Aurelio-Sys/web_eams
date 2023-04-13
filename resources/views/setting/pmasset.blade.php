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
<form action="/pmcode" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Preventive Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Preventive Desc</label>
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
                <th width="15%">Preventive</th>
                <th width="20%">PM Desc</th>
                <th width="10%">Type</th>
                <th width="15%">Instruction</th>
                <th width="15%">Sparepart</th>
                <th width="15%">QC Spec</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            {{--  @include('setting.table-pmcode')  --}}
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
                     <label for="t_asset" class="col-md-3 col-form-label text-md-right">Asset</label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_asset" name="t_asset">
                        <option value="">--</option>
                        @foreach($dataasset as $da)
                        <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="t_pmcode" class="col-md-3 col-form-label text-md-right">PM Code</label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_pmcode" name="t_pmcode">
                        <option value="">--</option>
                        @foreach($datapm as $dp)
                        <option value="{{$dp->pmc_code}}">{{$dp->pmc_code}} -- {{$dp->pmc_desc}}</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_time" class="col-md-3 col-form-label text-md-right">Lead Time</label>
                     <div class="col-md-4">
                           <input type="text" class="form-control" id="t_time" name="t_time" autocomplete="off" maxlength="24" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_mea" class="col-md-3 col-form-label text-md-right">Measurement</label>
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
                     <div class="col-md-8">
                           <input type="text" class="form-control" id="t_cal" name="t_cal" autocomplete="off" maxlength="255" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_meter" class="col-md-3 col-form-label text-md-right">Meter</label>
                     <div class="col-md-8">
                           <input type="text" class="form-control" id="t_meter" name="t_meter" autocomplete="off" maxlength="255" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_tol" class="col-md-3 col-form-label text-md-right">Tolerance</label>
                     <div class="col-md-8">
                           <input type="text" class="form-control" id="t_tol" name="t_tol" autocomplete="off" maxlength="255" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_start" class="col-md-3 col-form-label text-md-right">Start Date</label>
                     <div class="col-md-8">
                           <input type="text" class="form-control" id="t_start" name="t_start" autocomplete="off" maxlength="255" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="t_eng" class="col-md-3 col-form-label text-md-right">Engineer</label>
                     <div class="col-md-8">
                        <select class="form-control " id="t_eng" name="t_eng">
                        <option value="">--</option>
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
        <form class="form-horizontal" method="post" action="/editpmcode">
            {{ csrf_field() }}
            <div class="modal-body">
                
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
            <form class="form-horizontal" method="post" action="/delpmcode">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Preventive <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

           var code = $(this).data('code');
           var desc = $(this).data('desc');
           var type = $(this).data('type');
           var ins = $(this).data('ins');
           var spg = $(this).data('spg');
           var qcs = $(this).data('qcs');

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;
           document.getElementById('te_type').value = type;
           document.getElementById('te_ins').value = ins;
           document.getElementById('te_spg').value = spg;
           document.getElementById('te_qcs').value = qcs;
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value          = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

        $("#addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td width="15%"><input type="number" class="form-control" name="t_step[]" min="1"></td>'
          cols += '<td width="40%"><input type="text" class="form-control" name="t_stepdesc[]" maxlenght="255" autocomplete="off"></td>'
          cols += '<td width="30%"><input type="text" class="form-control" name="t_ref[]" maxlenght="255" autocomplete="off"></td>'
          cols += '<td width="15%"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#detailapp").append(newRow);
          counter++;

          selectPicker();
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counter -= 1
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td width="15%"><input type="number" class="form-control" name="te_step[]" min="1"></td>'
          cols += '<td width="40%"><input type="text" class="form-control" name="te_stepdesc[]" maxlenght="255" autocomplete="off"></td>'
          cols += '<td width="30%"><input type="text" class="form-control" name="te_ref[]" maxlenght="255" autocomplete="off"></td>'
          cols += '<td width="15%"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#ed_detailapp").append(newRow);
          counter++;

          selectPicker();
        });

        $(document).on('change','#cek',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox


            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.tick').val(1);
            } else
            {
                $(this).closest("tr").find('.tick').val(0);
            }        
        });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
        });   

         $("#t_ins").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#t_spg").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

         $("#t_qcs").select2({
            width : '100%',
            theme : 'bootstrap4',
         });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection