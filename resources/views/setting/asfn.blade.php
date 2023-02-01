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
    <br>
</div><!-- /.container-fluid -->
@endsection
@section('content')
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off" />
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Description</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off" />
                </div>
                <input type="hidden" id="tmpcode" />
                <input type="hidden" id="tmpdesc" />
            </div>
            <div class="col-12 form-group row">
                <label for="ss_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Location Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="ss_code" type="text" class="form-control" name="ss_code" value="" autofocus autocomplete="off" />
                </div>
                <label for="ss_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location Description</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="ss_desc" type="text" class="form-control" name="ss_desc" value="" autofocus autocomplete="off" />
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                </div>
                <input type="hidden" id="tmpscode" />
                <input type="hidden" id="tmpsdesc" />
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <hr>
</div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Asset Group</th>
                <th>Description</th>
                <th>Failure Type</th>
                <th>Description</th>
                <th>Action</th>
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
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_fntype" class="col-md-4 col-form-label text-md-right">Failure Type<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_fntype" class="form-control" name="t_fntype" required>
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

@php($descSite = '')
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
            <form class="form-horizontal" method="post" action="/editassetloc">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_asset" class="col-md-4 col-form-label text-md-right">Asset Group<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="te_asset" class="form-control" name="te_asset" required>
                                <option value="">--Select Data--</option>
                                @foreach($dataasgroup as $dg)
                                <option value="{{$dg->asgroup_code}}">{{$dg->asgroup_code}} -- {{$dg->asgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_fntype" class="col-md-4 col-form-label text-md-right">Failure Type<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="te_fntype" class="form-control" name="te_fntype" required>
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
                          <tbody id='ed_detailapp'>

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
                <h5 class="modal-title text-center" id="exampleModalLabel">Location Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteassetloc">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_locationid" name="d_locationid">
                    <input type="hidden" id="d_site" name="d_site">
                    Delete Location <b><span id="td_locationid"></span> -- <span id="td_locationdesc"></span></b> For Site <b><span id="td_site"></span></b> ?
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
        var fntype = $(this).data('fntype');

        document.getElementById('te_asset').value = asset;
        document.getElementById('te_fntype').value = fntype;

    });

    $(document).on('click', '.deletearea', function(e) {
        $('#deleteModal').modal('show');

        var locationid = $(this).data('locationid');
        var desc = $(this).data('desc');
        var site = $(this).data('site');

        document.getElementById('d_locationid').value = locationid;
        document.getElementById('d_site').value = site;
        document.getElementById('td_locationid').innerHTML = locationid;
        document.getElementById('td_locationdesc').innerHTML = desc;
        document.getElementById('td_site').innerHTML = site;
    });

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, code, desc, scode, sdesc) {
        $.ajax({
            url: "areamaster/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&code=" + code + "&desc=" + desc + "&scode=" + scode + "&sdesc=" + sdesc,
            success: function(data) {
                console.log(data);
                $('tbody').html('');
                $('tbody').html(data);
            }
        })
    }

    $(document).on('click', '#btnsearch', function() {
        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        var scode = $('#ss_code').val();
        var sdesc = $('#ss_desc').val();

        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = 1;

        document.getElementById('tmpcode').value = code;
        document.getElementById('tmpdesc').value = desc;
        document.getElementById('tmpscode').value = scode;
        document.getElementById('tmpscode').value = sdesc;

        fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
    });

    $(document).on('click', '.sorting', function() {
        var column_name = $(this).data('column_name');
        var order_type = $(this).data('sorting_type');
        var reverse_order = '';
        if (order_type == 'asc') {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            clear_icon();
            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
        }
        if (order_type == 'desc') {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            clear_icon();
            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
        }
        $('#hidden_column_name').val(column_name);
        $('#hidden_sort_type').val(reverse_order);
        var page = $('#hidden_page').val();
        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        var scode = $('#ss_code').val();
        var sdesc = $('#ss_desc').val();
        fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
    });


    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        var scode = $('#ss_code').val();
        var sdesc = $('#ss_desc').val();
        fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
    });

    $(document).on('click', '#btnrefresh', function() {

        var code = '';
        var desc = '';
        var scode = '';
        var sdesc = '';

        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = 1;

        document.getElementById('tmpcode').value = code;
        document.getElementById('tmpdesc').value = desc;
        document.getElementById('tmpscode').value = scode;
        document.getElementById('tmpscode').value = sdesc;

        document.getElementById('s_code').value = code;
        document.getElementById('s_desc').value = desc;
        document.getElementById('ss_code').value = scode;
        document.getElementById('ss_desc').value = sdesc;

        fetch_data(page, sort_type, column_name, code, desc, scode, sdesc);
    });

    $("#t_asset").select2({
        width : '100%',
        theme : 'bootstrap4',
        
    });

    var counter = 1;

    function selectPicker() {

        $('.selectpicker').selectpicker().focus();

    }

    $("#addrow").on("click", function() {

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

    $(document).on('change', '#t_asset', function() {
        var sasset = $('#t_asset').val();
        var sfntype = $('#t_fntype').val();
            $.ajax({
                url:"/cekasfn?sasset="+sasset+"&sfntype="+sfntype,
                success:function(data){
                    if (data == "ada") {
                        alert("Data Already Registered!!");
                        document.getElementById('t_asset').focus();
                        document.getElementById('t_asset').value = '';
                        document.getElementById('t_fntype').value = '';
                    }
                    console.log(data);
                }
            }) 
    });

    $(document).on('change', '#t_fntype', function() {
        var sasset = $('#t_asset').val();
        var sfntype = $('#t_fntype').val();
        {{--  alert("type");  --}}
            $.ajax({
                url:"/cekasfn?sasset="+sasset+"&sfntype="+sfntype,
                success:function(data){
                    if (data == "ada") {
                        alert("Data Already Registered!!");
                        document.getElementById('t_asset').focus();
                        document.getElementById('t_asset').value = '';
                        document.getElementById('t_fntype').value = '';
                    }
                    console.log(data);
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