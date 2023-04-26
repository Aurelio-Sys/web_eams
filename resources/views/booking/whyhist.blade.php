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
<form action="/invsu" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Site</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Sparepart Supply Site</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_loc" type="text" class="form-control" name="s_loc"
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
                <th width="20%">WO Number</th>
                <th width="45%">Problem</th>
                <th width="15%">Action</th>  
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
            <form class="form-horizontal" method="post" action="/createwhyhist">
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
                           <select class="form-control" id="t_wo" name="t_wo">
                              <option value=""></option>
                              @foreach($datawo as $dw)
                              <option value="{{$dw->wo_number}}">{{$dw->wo_number}}</option>
                              @endforeach
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
        <form class="form-horizontal" method="post" action="/editinvsu">
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Supply Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delinvsu">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_desc" name="d_desc">
                    Delete Inventory Supply from <b> Asset Site : <span id="td_code"></span> , Supply Site : <span id="td_desc"></span></b> ?
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
           var dasset = $(this).data('dasset')
           var dsource = $(this).data('dsource')

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;
           document.getElementById('tv_code').value = code + " -- " + dasset;
           document.getElementById('tv_desc').value = desc + " -- " + dsource;

            $.ajax({
                url:"editdetinvsu?code1="+code+"&code2="+desc,
                success: function(data) {
                console.log(data);
                $('#ed_detailapp').html('').append(data);
              }
            })

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');
            var dasset = $(this).data('dasset')
            var dsource = $(this).data('dsource')

            document.getElementById('d_code').value          = code;
            document.getElementById('d_desc').value          = desc;
            document.getElementById('td_code').innerHTML = code + "(" + dasset + ")" ;
            document.getElementById('td_desc').innerHTML = desc + "(" + dsource + ")" ;
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