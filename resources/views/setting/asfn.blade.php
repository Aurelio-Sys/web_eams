@extends('layout.newlayout')
@section('content-header')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Mapping Asset - Failure Maintenance</h1>
        </div>
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    <div class="row">                 
        <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Asset Movement Create</button>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/asfn" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Group Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code" value="{{$s_code}}" autocomplete="off" />
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Group Desc</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="{{$s_desc}}" autocomplete="off" />
                </div>
            </div>
            <div class="col-12 form-group row">
                <label for="ss_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Failure Type</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <select id="s_fntype" class="form-control" style="color:black" name="s_fntype">
                        <option value="">--Select--</option>
                        @foreach($datafntype as $df)
                        <option value="{{$df->wotyp_code}}" {{$df->wotyp_code === $s_fntype ? "selected" : ""}}>{{$df->wotyp_code}} -- {{$df->wotyp_desc}}</option>
                        @endforeach
                    </select>
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
<div class="col-md-12">
    <hr>
</div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="15%">Asset Group</th>
                <th width="30%">Description</th>
                <th width="15%">Failure Type</th>
                <th width="30%">Description</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-asfn')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asmove_code" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Mapping Asset - Failure Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createaasfn">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_asset" class="col-md-4 col-form-label text-md-right">Asset Group<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_asset" class="form-control" name="t_asset" required>
                                <option value="">--Select Data--</option>
                                @foreach($dataasgroup as $dg)
                                <option value="{{$dg->asgroup_code}}">{{$dg->asgroup_code}} -- {{$dg->asgroup_desc}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="t_assetcek" id="t_assetcek">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_fntype" class="col-md-4 col-form-label text-md-right">Failure Type</label>
                        <div class="col-md-6">
                            <select id="t_fntype" class="form-control" name="t_fntype">
                                <option value="">--Select Data--</option>
                                @foreach($datafntype as $dt)
                                <option value="{{$dt->wotyp_code}}">{{$dt->wotyp_code}} -- {{$dt->wotyp_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10 offset-md-1">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                          <thead>
                            <tr id='full'>
                              <th width="70%">Failure Code</th>
                              <th width="20%">Delete</th>
                            </tr>
                          </thead>
                          <tbody id='detailapp'>

                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Mapping Asset - Failure Modify</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/editasfn">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_asset" class="col-md-4 col-form-label text-md-right">Asset Group</label>
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="te_asset" id="te_asset">
                            <input type="text" class="form-control" name="te_gdesc" id="te_gdesc" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_fntype" class="col-md-4 col-form-label text-md-right">Failure Type</label>
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="te_fntype" id="te_fntype">
                            <input type="text" class="form-control" name="te_fdesc" id="te_fdesc" readonly>
                        </div>
                    </div>
                    <div class="col-md-10 offset-md-1">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                          <thead>
                            <tr id='full'>
                              <th width="70%">Failure Code</th>
                              <th width="20%">Delete</th>
                            </tr>
                          </thead>
                          <tbody id='ed_detailapp'>

                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2">
                                <input type="button" class="btn btn-lg btn-block btn-focus" id="ed_addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                              </td>
                            </tr>
                          </tfoot>
                        </table>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Location Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteasfn">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code1" name="d_code1">
                    <input type="hidden" id="d_code2" name="d_code2">
                    Delete Mapping Asset Group <b><span id="td_code1"></span></b> 
                    Failure Type <b><span id="td_code2"></span></b> ?
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
    $(document).on('click', '#editarea', function(e) {
        $('#editModal').modal('show');

        var asset = $(this).data('asset');
        var gdesc = $(this).data('gdesc');
        var fntype = $(this).data('fntype');
        var fdesc = $(this).data('fdesc');

        document.getElementById('te_asset').value = asset;
        document.getElementById('te_gdesc').value = asset + " - " + gdesc;
        document.getElementById('te_fntype').value = fntype;
        document.getElementById('te_fdesc').value = fntype + " - " + fdesc;

        $.ajax({
            url:"editdetailasfn?asset="+asset+"&fntype="+fntype,
            success: function(data) {
            console.log(data);
            $('#ed_detailapp').html('').append(data);
          }
        })

    });

    $(document).on('click', '.deletearea', function(e) {
        alert('test');
        $('#deleteModal').modal('show');
        
        var asset = $(this).data('asset');
        var gdesc = $(this).data('gdesc');
        var fntype = $(this).data('fntype');
        var fdesc = $(this).data('fdesc');

        document.getElementById('d_code1').value = asset;
        document.getElementById('d_code2').value = fntype;
        document.getElementById('td_code1').innerHTML = gdesc;
        document.getElementById('td_code2').innerHTML = fdesc;
    });

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });    

    function resetSearch() {
        $('#s_code').val('');
        $('#s_desc').val('');
        $('#s_fntype').val('');
    }

    $("#t_asset").select2({
        width : '100%',
        theme : 'bootstrap4',
    });

    $("#t_fntype").select2({
        width : '100%',
        theme : 'bootstrap4',    
    });

    $("#s_fntype").select2({
        width : '100%',
        theme : 'bootstrap4',    
    });

    var counter = 1;

    function selectPicker() {
        $('.selectpicker').selectpicker().focus();
    }

    $("#addrow").on("click", function() {
        var sasset = $('#t_asset').val();
        var sfntype = $('#t_fntype').val();
        
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td data-label="Barang">';
        cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required>';
            cols += '<option value = ""> -- Select Data -- </option>'
        @foreach($datafncode as $df)
        cols += '<option value="{{$df->fn_code}}"> {{$df->fn_code}} -- {{$df->fn_desc}} </option>';
        @endforeach
        cols += '</select>';
        cols += '</td>';

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

        cols += '<td data-label="Barang">';
        cols += '<select id="barang" class="form-control barang selectpicker" name="barang[]" data-live-search="true" required>';
        cols += '<option value = ""> -- Select Data -- </option>'
        @foreach($datafncode as $df)
        cols += '<option value="{{$df->fn_code}}"> {{$df->fn_code}} -- {{$df->fn_desc}} </option>';
        @endforeach
        cols += '</select>';
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

</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
@endsection