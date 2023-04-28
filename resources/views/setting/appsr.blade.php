@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Approval SR Maintenance</h1>
          </div>    
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/splist" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Sp List Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Sp List Desc</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_code1" class="col-md-2 col-sm-2 col-form-label text-md-right">Sparepart Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code1" type="text" class="form-control" name="s_code1"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc1" class="col-md-2 col-sm-2 col-form-label text-md-right">Sparepart Desc</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc1" type="text" class="form-control" name="s_desc1"
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
                <th width="15%">Dept Code</th>
                <th width="30%">Dept Desc</th>
                <th width="40%">Approval</th>
                <th width="15%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-appsr')
        </tbody>
    </table>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Approval SR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editappsr">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="form-group row">
                  <label for="te_code" class="col-md-4 col-form-label text-md-right">Department Code</label>
                  <div class="col-md-2">
                      <input type="text" class="form-control" id="te_code" name="te_code" readonly>
                  </div>
               </div>
               <div class="form-group row">
                     <label for="te_desc" class="col-md-4 col-form-label text-md-right">Department Desc</label>
                     <div class="col-md-6">
                        <input type="text" class="form-control" id="te_desc" name="te_desc" readonly>
                     </div>
               </div>
               <div class="col-md-10 offset-md-1">
                  <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                      <thead>
                       <th width="30%">Sequence</th>
                       <th width="50%">Role</th>
                       <th width="20%">Delete</th>
                      </thead>
                      <tbody id='ed_detailapp'></tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3">
                            <input type="button" class="btn btn-lg btn-block btn-focus" id="ed_addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                          </td>
                        </tr>
                      </tfoot>
                  </table>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Approval SR Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delappsr">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Approval SR Departemen <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;

            $.ajax({
                url:"editdetappsr?code="+code,
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

            document.getElementById('d_code').value          = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counter -= 1
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td width="30%"><input type="number" class="form-control" name="te_seq[]" min="0" required></td>';
          cols += '<td width="50%">';
          cols += '<select id="te_role" class="form-control selectpicker te_role" name="te_role[]" data-live-search="true" required>';
          cols += '<option value = ""> -- Select Data -- </option>'  
          @foreach($datarole as $dr)
          cols += '<option value="{{$dr->role_code}}"> {{$dr->role_code}} -- {{$dr->role_desc}} </option>';
          @endforeach
          cols += '</td>';
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