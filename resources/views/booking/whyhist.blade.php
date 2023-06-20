@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">5 Why Transactions</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/whyhist" method="GET">
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
                <label for="s_asset" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_asset" type="text" class="form-control" name="s_asset"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_wo" class="col-md-2 col-sm-2 col-form-label text-md-right">WO Number</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_wo" type="text" class="form-control" name="s_wo"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_problem" class="col-md-2 col-sm-2 col-form-label text-md-right">Problem</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_problem" type="text" class="form-control" name="s_problem"
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
                <th width="20%">Asset</th>
                <th width="15%">WO Number</th>
                <th width="30%">Problem</th>
                <th width="10%">User</th>
                <th width="10%">Date</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('booking.table-whyhist')
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Input 5 Why Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createwhyhist" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_asset" class="col-md-2 col-form-label text-md-right">Asset</label>
                        <div class="col-md-9">
                           <select class="form-control" id="t_asset" name="t_asset" required>
                              <option value=""></option>
                              @foreach($dataasset as $da)
                              <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_wo" class="col-md-2 col-form-label text-md-right">WO Number</label>
                        <div class="col-md-9">
                           {{--  <select class="form-control" id="t_wo" name="t_wo">  --}}
                           <select id="t_wo" class="form-control" name="t_wo">
                              {{--  <option value=""></option>
                              @foreach($datawo as $dw)
                              <option value="{{$dw->wo_number}}">{{$dw->wo_number}}</option>
                              @endforeach  --}}
                           </select>
                        </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_problem" class="col-md-2 col-form-label text-md-right">Problem</label>
                     <div class="col-md-9">
                        <textarea id="t_problem" name="t_problem" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_why1" class="col-md-2 col-form-label text-md-right">Why 1</label>
                     <div class="col-md-9">
                        <textarea id="t_why1" name="t_why1" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_why2" class="col-md-2 col-form-label text-md-right">Why 2</label>
                     <div class="col-md-9">
                        <textarea id="t_why2" name="t_why2" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_why3" class="col-md-2 col-form-label text-md-right">Why 3</label>
                     <div class="col-md-9">
                        <textarea id="t_why3" name="t_why3" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_why4" class="col-md-2 col-form-label text-md-right">Why 4</label>
                     <div class="col-md-9">
                        <textarea id="t_why4" name="t_why4" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="t_why5" class="col-md-2 col-form-label text-md-right">Why 5</label>
                     <div class="col-md-9">
                        <textarea id="t_why5" name="t_why5" rows="2" cols="50" class="form-control"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                        <label for="file" class="col-sm-2 col-form-label text-md-right">{{ __('Upload') }}</label>
                        <div class="col-md-9 input-file-container">
                          <input type="file" class="form-control" id="filename" name="filename[]" multiple>
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
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Supply Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editwhyhist" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="t_asset" class="col-md-2 col-form-label text-md-right">Asset</label>
                    <div class="col-md-9">
                       <input type="text" class="form-control" id="te_asset" name="te_asset" readonly>
                       <input type="hidden" id="te_id" name="te_id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_wo" class="col-md-2 col-form-label text-md-right">WO Number</label>
                    <div class="col-md-9">
                       <select class="form-control" id="te_wo" name="te_wo">
                          <option value=""></option>
                          @foreach($datawo as $dw)
                          <option value="{{$dw->wo_number}}">{{$dw->wo_number}}</option>
                          @endforeach
                       </select>
                    </div>
                </div>
                <div class="form-group row">
                 <label for="te_problem" class="col-md-2 col-form-label text-md-right">Problem</label>
                 <div class="col-md-9">
                    <textarea id="te_problem" name="te_problem" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="te_why1" class="col-md-2 col-form-label text-md-right">Why 1</label>
                 <div class="col-md-9">
                    <textarea id="te_why1" name="te_why1" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="te_why2" class="col-md-2 col-form-label text-md-right">Why 2</label>
                 <div class="col-md-9">
                    <textarea id="te_why2" name="te_why2" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="te_why3" class="col-md-2 col-form-label text-md-right">Why 3</label>
                 <div class="col-md-9">
                    <textarea id="te_why3" name="te_why3" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="te_why4" class="col-md-2 col-form-label text-md-right">Why 4</label>
                 <div class="col-md-9">
                    <textarea id="te_why4" name="te_why4" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="te_why5" class="col-md-2 col-form-label text-md-right">Why 5</label>
                 <div class="col-md-9">
                    <textarea id="te_why5" name="te_why5" rows="2" cols="50" class="form-control"></textarea>
                 </div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-md-2 col-form-label text-md-right">Current File</label>
                    <div class="col-md-9">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>File Name</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody id="elistupload">
        
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="file" class="col-md-2 col-form-label text-md-right">Upload New File</label>
                    <div class="col-md-9 input-file-container">
                      <input type="file" class="form-control" id="te_filename" name="te_filename[]" multiple>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">5 Why Transactions Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delwhyhist">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Transaction ?
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

           var id = $(this).data('id');
           var asset = $(this).data('asset');
           var wo = $(this).data('wo');
           var problem = $(this).data('problem');
           var why1 = $(this).data('why1');
           var why2 = $(this).data('why2');
           var why3 = $(this).data('why3');
           var why4 = $(this).data('why4');
           var why5 = $(this).data('why5');

           document.getElementById('te_id').value = id;
           document.getElementById('te_asset').value = asset;
           document.getElementById('te_wo').value = wo;
           document.getElementById('te_problem').value = problem;
           document.getElementById('te_why1').value = why1;
           document.getElementById('te_why2').value = why2;
           document.getElementById('te_why3').value = why3;
           document.getElementById('te_why4').value = why4;
           document.getElementById('te_why5').value = why5;

           $.ajax({
                url: "/whyfile/" + id,
                success: function(data) {
                console.log(data);
                $('#elistupload').html('').append(data);
                }
            })

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var id = $(this).data('id');
            var asset = $(this).data('asset');
            var problem = $(this).data('problem');

            document.getElementById('d_code').value = id;
       });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
        });   

        $("#t_asset").select2({
         width : '100%',
         theme : 'bootstrap4',
        });

        $("#t_wo").select2({
         width : '100%',
         theme : 'bootstrap4',
        });

        $(document).on('change', '#t_asset', function() {
          var code = $('#t_asset').val();

            $.ajax({
                url:"/searchwoasset?code="+code,
                success:function(data){
                    console.log(data);
                    $('#t_wo').html('').append(data);
                }
            }) 
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