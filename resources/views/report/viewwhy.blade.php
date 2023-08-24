@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">View 5 Why Transactions</h1>
          </div>    
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/viewwhy" method="GET">
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
                <label for="s_key" class="col-md-2 col-sm-2 col-form-label text-md-right">Keyword</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_key" type="text" class="form-control" name="s_key"
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
            @include('report.table-viewwhy')
        </tbody>
    </table>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">5 Why Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="v_asset" class="col-md-2 col-form-label text-md-right">Asset</label>
                    <div class="col-md-9">
                       <input type="text" class="form-control" id="v_asset" name="v_asset" readonly>
                       <input type="hidden" id="v_id" name="v_id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_wo" class="col-md-2 col-form-label text-md-right">WO Number</label>
                    <div class="col-md-9">
                       <select class="form-control" id="v_wo" name="v_wo" readonly>
                          <option value=""></option>
                          @foreach($datawo as $dw)
                          <option value="{{$dw->wo_number}}">{{$dw->wo_number}}</option>
                          @endforeach
                       </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_key" class="col-md-2 col-form-label text-md-right">Keyword</label>
                    <div class="col-md-9">
                       <input type="text" class="form-control" id="v_key" name="v_key" readonly>
                    </div>
                </div>
                <div class="form-group row">
                 <label for="v_problem" class="col-md-2 col-form-label text-md-right">Problem</label>
                 <div class="col-md-9">
                    <textarea id="v_problem" name="v_problem" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="v_why1" class="col-md-2 col-form-label text-md-right">Why 1</label>
                 <div class="col-md-9">
                    <textarea id="v_why1" name="v_why1" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="v_why2" class="col-md-2 col-form-label text-md-right">Why 2</label>
                 <div class="col-md-9">
                    <textarea id="v_why2" name="v_why2" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="v_why3" class="col-md-2 col-form-label text-md-right">Why 3</label>
                 <div class="col-md-9">
                    <textarea id="v_why3" name="v_why3" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="v_why4" class="col-md-2 col-form-label text-md-right">Why 4</label>
                 <div class="col-md-9">
                    <textarea id="v_why4" name="v_why4" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                 <label for="v_why5" class="col-md-2 col-form-label text-md-right">Why 5</label>
                 <div class="col-md-9">
                    <textarea id="v_why5" name="v_why5" rows="2" cols="50" class="form-control" readonly></textarea>
                 </div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-md-2 col-form-label text-md-right">Current File</label>
                    <div class="col-md-9">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>File Name</th>
                          </tr>
                        </thead>
                        <tbody id="vlistupload">
        
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
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

       $(document).on('click', '.viewdata', function() {
            $('#viewModal').modal('show');

            var id = $(this).data('id');
            var asset = $(this).data('asset');
            var wo = $(this).data('wo');
            var key = $(this).data('key');
            var problem = $(this).data('problem');
            var why1 = $(this).data('why1');
            var why2 = $(this).data('why2');
            var why3 = $(this).data('why3');
            var why4 = $(this).data('why4');
            var why5 = $(this).data('why5');

            {{--  document.getElementById('v_id').value = id;  --}}
            document.getElementById('v_asset').value = asset;
            document.getElementById('v_wo').value = wo;
            document.getElementById('v_key').value = key;
            document.getElementById('v_problem').value = problem;
            document.getElementById('v_why1').value = why1;
            document.getElementById('v_why2').value = why2;
            document.getElementById('v_why3').value = why3;
            document.getElementById('v_why4').value = why4;
            document.getElementById('v_why5').value = why5;

            $.ajax({
                url: "/whyfileview/" + id,
                success: function(data) {
                console.log(data);
                $('#vlistupload').html('').append(data);
                }
            })
       });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
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