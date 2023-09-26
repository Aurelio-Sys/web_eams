@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">QC Specification Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">QC Specification Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/qcspec" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">QC Specification Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">QC Specification Description</label>
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
                <th width="35%">QC Spec Code</th>
                <th width="50%">QC Spec Desc</th>
                <th width="15%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-qcspec')
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">QC Specification Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createqcs">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">QC Spec Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="t_code" name="t_code" autocomplete="off" maxlength="24" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">QC Spec Desc <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="t_desc" name="t_desc" autocomplete="off" maxlength="255" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                          <thead>
                            <tr id='full'>
                              <th width="25%">QC Spec Parameter</th>
                              <th width="15%">Tools</th>
                              <th width="15%">Operator</th>
                              <th width="15%">Value 1</th>
                              <th width="15%">Value 2</th>
                              <th width="10%">Um</th>
                              <th width="5%">Delete</th>
                            </tr>
                          </thead>
                          <tbody id='detailapp'>

                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="7">
                                <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                              </td>
                            </tr>
                          </tfoot>
                        </table>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">QC Specification Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editqcs">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">QC Spec Code </label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="te_code" name="te_code" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">QC Spec Desc <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="te_desc" name="te_desc" autocomplete="off" maxlength="255" required>
                    </div>
                </div>
                
                <div class="col-md-12">
                <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                    <thead>
                        <th width="25%">QC Spec Parameter</th>
                        <th width="15%">Tools</th>
                        <th width="15%">Operator</th>
                        <th width="15%">Value 1</th>
                        <th width="15%">Value 2</th>
                        <th width="10%">Um</th>
                        <th width="5%">Delete</th>
                    </thead>
                    <tbody id='ed_detailapp'></tbody>
                    <tfoot>
                      <tr>
                        <td colspan="7">
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
            <h5 class="modal-title text-center" id="exampleModalLabel">QC Specification Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delqcs">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete QC Specification <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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
                url:"editdetqcs?code="+code,
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

       {{--  Fungsi untuk menampilkan dropdown data operator  --}}
       cmbop();

       function cmbop() {
            var test = [];

            test += '<option value="">1</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';
            test += '<option value="">2</option>';

            $('#t_op').html('').append(test); 
       }

        $("#addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td><input type="text" class="form-control" name="t_spec[]" autocomplete="off" maxlength="255" required></td>';
          cols += '<td><input type="text" class="form-control" name="t_tools[]" autocomplete="off" maxlength="255"></td>';
          cols += '<td><select class="form-control t_op" name="t_op[]" required>';
          cols += '<option value=""></option>'
          @foreach ($dataopt as $do)
            cols += '<option value="{{$do->id}}"> {{$do->opt_desc}} </option>';          
          @endforeach
          cols += '</select></td>'
          {{--  cols += '<td><input type="text" class="form-control" name="t_op[]" autocomplete="off" required></td>';  --}}
          cols += '<td><input type="text" class="form-control" name="t_val1[]" autocomplete="off" required></td>';
          cols += '<td><input type="text" class="form-control" name="t_val2[]" autocomplete="off"></td>';
          cols += '<td><input type="text" class="form-control" name="t_um[]" autocomplete="off"></td>';
          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
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

          cols += '<td><input type="text" class="form-control" name="te_spec[]" autocomplete="off" maxlength="255" required></td>';
          cols += '<td><input type="text" class="form-control" name="te_tools[]" autocomplete="off" maxlength="255"></td>';
          cols += '<td><select class="form-control te_op" name="te_op[]" required>';
          cols += '<option value=""></option>'
          @foreach ($dataopt as $do)
            cols += '<option value="{{$do->id}}"> {{$do->opt_desc}} </option>';          
          @endforeach
          cols += '</select></td>'
          {{--  cols += '<td><input type="text" class="form-control" name="te_op[]" autocomplete="off" maxlength="255" required></td>';  --}}
          cols += '<td><input type="text" class="form-control" name="te_val1[]" autocomplete="off" maxlength="255" required></td>';
          cols += '<td><input type="text" class="form-control" name="te_val2[]" autocomplete="off"></td>';
          cols += '<td><input type="text" class="form-control" name="te_um[]" autocomplete="off"></td>';
          cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';

          cols += '<td data-title="Action"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
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

        //cek dobel code saat menu Create
        $(document).on('change', '#t_code', function() {
            var code = $('#t_code').val();

            $.ajax({
                url:"/cekqcslist?code="+code ,
                success: function(data) {
                
                if (data == "ada") {
                    alert("Data Already Registered!");
                    document.getElementById('t_code').value = '';
                    document.getElementById('t_code').focus();
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