@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Request Sparepart Maintenance</h1>
        </div><!-- /.col -->
        <div class="col-sm-3">
            <a class="btn btn-block btn-primary" href="{{route('reqspcreate')}}">
                Request Sparepart</a>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/reqsp" method="GET">
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

                    <!--FORM Search Disini-->
                    <label for="s_nomorrs" class="col-md-2 col-form-label text-md-right">{{ __('RS Number') }}</label>
                    <div class="col-md-3 col-sm-12 mb-2 input-group">
                        <input id="s_nomorrs" type="text" class="form-control" name="s_nomorrs" value="" autofocus autocomplete="off">
                    </div>
                    <label for="s_reqby" class="col-md-2 col-form-label text-md-right">{{ __('Request By') }}</label>
                    <div class="col-md-3 col-sm-12 mb-2 input-group">
                        <select id="s_reqby" class="form-control" style="color:black" name="s_reqby" autofocus autocomplete="off">
                            <option value="">--Select Request By--</option>
                            @foreach($requestby as $reqby)
                            <option value="{{$reqby->username}}">{{$reqby->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <label for="s_datefrom" class="col-md-2 col-form-label text-md-right">{{ __('Needed Date From') }}</label>
                    <div class="col-md-3 col-sm-12 mb-2 input-group">
                        <input id="s_datefrom" type="date" class="form-control" name="s_datefrom" value="" autofocus autocomplete="off">
                    </div>
                    <label for="s_daeto" class="col-md-2 col-form-label text-md-right">{{ __('Needed Date To') }}</label>
                    <div class="col-md-3 col-sm-12 mb-2 input-group">
                        <input id="s_dateto" type="date" class="form-control" name="s_dateto" value="" autofocus autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>
                    <label for="s_status" class="col-md-2 col-form-label text-md-right">{{ __('Status') }}</label>
                    <div class="col-md-3 col-sm-12 mb-2 input-group">
                        <select id="s_status" type="text" class="form-control" name="s_status">
                            <option value="">--Select Status--</option>
                            <option value="open">open</option>
                            <option value="closed">closed</option>
                            <option value="canceled">canceled</option>
                        </select>
                    </div>
                    <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                        <button class="btn btn-block btn-primary" id="btnsearch" style="float:right" />Search</button>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- <div class="container-fluid mt-3 mb-2" style="display: flex; flex-direction: row-reverse;">
    <button type="submit" class="btn btn-success bt-action" id="btnconf">Release Work Order</button>
</div> -->

<!-- Request Sparepart Browse -->
<div class="table-responsive col-12 mt-0 pt-0" style="overflow-x: auto;overflow-y: hidden ;display: inline-block;white-space: nowrap; position:relative;">
    <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr style="text-align: center;">
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" width="10%">Req Sparepart Number<span id="name_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="10%">Request By<span id="username_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" width="10%">Due Date<span id="username_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="10%">Status<span id="username_icon"></span></th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @include('sparepart.table-reqsparepartbrowse')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>
</div>

<!-- Request Sparepart View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Request Sparepart View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin: 0px 0px 0.8em 0px;">
                    <label for="v_rsnumber" class="col-md-3 col-form-label">RS Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="v_rsnumber" name="v_rsnumber" readonly>
                    </div>
                    <label for="v_reqby" class="col-md-3 col-form-label">Requested By</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="v_reqby" name="v_reqby" readonly>
                    </div>
                </div>
                <div class="form-group row" style="margin: 0px 0px 1.5em 0px;">
                    <label for="v_duedate" class="col-md-3 col-form-label">Needed Date</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="v_duedate" name="v_duedate" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <table width="100%" id='asetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                        <thead>
                            <th width="30%">Spare part</th>
                            <th width="10%">Qty Request</th>
                            <th width="20%">Location To</th>
                        </thead>
                        <tbody id='v_detailapp'></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Request Sparepart Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Request Sparepart Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/reqspupdate">
                <!-- <form class="form-horizontal" method="post" action="#"> -->
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row" style="margin: 0px 0px 0.8em 0px;">
                        <label for="e_rsnumber" class="col-md-3 col-form-label">RS Number</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="e_rsnumber" name="e_rsnumber" readonly>
                        </div>
                        <label for="e_reqby" class="col-md-3 col-form-label">Requested By</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="e_reqby" name="e_reqby" readonly>
                        </div>
                    </div>
                    <div class="form-group row" style="margin: 0px 0px 1.5em 0px;">
                        <label for="e_duedate" class="col-md-3 col-form-label">Needed Date</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="e_duedate" name="e_duedate">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                            <thead>
                                <th width="30%">Spare part</th>
                                <th width="10%">Qty Request</th>
                                <th width="20%">Location To</th>
                                <th width="10%">Delete</th>
                            </thead>
                            <tbody id='ed_detailapp'></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
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

<!-- Request Sparepart Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Request Sparepart Cancel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="statuscancel">
            <form class="form-horizontal" id="newcancel" method="post" action="reqspcancel" enctype="multipart/form-data">
                {{csrf_field()}}

                <div style="display: none;">
                    <label for="c_rsnumber" class="col-md-4 col-form-label text-md-right">{{ __('RS Number') }}</label>
                    <div class="col-md-7">
                        <input id="c_rsnumber" type="text" class="form-control" name="c_rsnumber" value="" readonly>
                    </div>
                </div>

                <div class="modal-body">
                    <span class="col-md-12"><b>Are you sure want to cancel <span id="rsnbr"><b></b></span>
                            ?</b></span>
                    <!-- <div class="form-group row" id="divnotecancel"> -->
                    <label class="col-md-12 col-form-label">If you are sure, please fill the cancelation reason <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <textarea class="form-control" id="c_reason" name="c_reason" autofocus maxlength="150" required></textarea>
                    <!-- </div> -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="c_btnclose" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success bt-action" id="c_btnconf">Yes</button>
                    <button type="button" class="btn bt-action" id="c_btnloading" style="display: none;">
                        <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;Loading
                    </button>
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

    $(document).on('click', '.viewreqsp', function() {

        $('#viewModal').modal('show');

        var rsnumber = $(this).data('rsnumber');
        var reqby = $(this).data('reqby');
        var duedate = $(this).data('duedate');

        document.getElementById('v_rsnumber').value = rsnumber;
        document.getElementById('v_reqby').value = reqby;
        document.getElementById('v_duedate').value = duedate;

        $.ajax({
            url: "reqspviewdet?code=" + rsnumber,
            success: function(data) {
                // console.log(data);
                $('#v_detailapp').html('').append(data);
            }
        })

    });

    $(document).on('click', '.cancelreqsp', function() {

        $('#cancelModal').modal('show');

        var rsnumber = $(this).data('rsnumber');

        document.getElementById('c_rsnumber').value = rsnumber;
        document.getElementById('rsnbr').innerHTML = rsnumber;

    });

    $(document).on('click', '.editreqsp', function() {

        $('#editModal').modal('show');

        var rsnumber = $(this).data('rsnumber');
        var reqby = $(this).data('reqby');
        var duedate = $(this).data('duedate');

        // console.log(duedate);

        document.getElementById('e_rsnumber').value = rsnumber;
        document.getElementById('e_reqby').value = reqby;
        document.getElementById('e_duedate').value = duedate;

        $.ajax({
            url: "reqspeditdet?code=" + rsnumber,
            success: function(data) {
                // console.log(data);
                $('#ed_detailapp').html('').append(data);
            }
        })

    });

    $("#ed_addrow").on("click", function() {

        var newRow = $("<tr>");
        var cols = "";

        cols += '<td>';
        cols += '<select name="te_spreq[]" id="te_spreq" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
        cols += '<option value = ""> -- Select Sparepart -- </option>';
        @foreach($sp_all as $da)
        cols += '<option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
        @endforeach
        cols += '</select>';
        cols += '</td>';

        cols += '<td>';
        cols += '<input type="number" class="form-control" name="te_qtyreq[]" id="te_qtyreq" step=".01" min="0" required />';
        cols += '</td>';

        cols += '<td>';
        cols += '<select name="te_locto[]" id="te_locto" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" required>';
        cols += '<option value = ""> -- Select Location To -- </option>';
        @foreach($loc_to as $loc)
        cols += '<option value="{{$loc->inp_loc}}">{{$loc->inp_loc}}</option>';
        @endforeach
        cols += '</select>';
        cols += '</td>';
        cols += '<td width="15%"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
        cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
        cols += '</tr>'
        newRow.append(cols);
        $("#ed_detailapp").append(newRow);
        counter++;

        selectPicker();

    });

    $("table.order-list").on("click", ".ibtnDel", function(event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    $(document).on('change', '#cek', function(e) {
        var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox


        if (checkbox.is(':checked')) {
            $(this).closest("tr").find('.tick').val(1);
        } else {
            $(this).closest("tr").find('.tick').val(0);
        }
    });

    function resetSearch() {
        $('#s_nomorrs').val('');
        $('#s_reqby').val('');
        $('#s_status').val('');
        $('#s_datefrom').val('');
        $('#s_dateto').val('');
    }

    $(document).ready(function() {
        var cur_url = window.location.href;

        let paramString = cur_url.split('?')[1];
        let queryString = new URLSearchParams(paramString);

        let reqby = queryString.get('s_reqby');
        let status = queryString.get('s_status');
        let datefrom = queryString.get('s_datefrom');
        let dateto = queryString.get('s_dateto');
        // let priority = queryString.get('s_status');

        $('#s_reqby').val(reqby).trigger('change');
        $('#s_status').val(status).trigger('change');
        $('#s_datefrom').val(datefrom).trigger('change');
        $('#s_dateto').val(dateto).trigger('change');

        $('#s_reqby').select2({
            width: '100%',
            closeOnSelect: true,
            theme: 'bootstrap4',
        });
    });

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });
</script>
@endsection