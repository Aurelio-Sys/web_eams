@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Sparepart Warehouse Maintenance</h1>
            <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan pemindahan sparepart dari inventory supply ke inventory source oleh pihak warehouse</p>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/trfsp" method="GET">
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
                    <label for="s_nomorrs" class="col-md-2 col-form-label text-md-right">{{ __('RT Number') }}</label>
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

<!-- transfer request browse -->
<div class="table-responsive col-12 mt-0 pt-0" style="overflow-x: auto;overflow-y: hidden ;display: inline-block;white-space: nowrap; position:relative;">
    <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr style="text-align: center;">
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" width="10%">Return Sparepart Number<span id="name_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" width="10%">WO Number<span id="name_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="10%">Return By<span id="username_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" width="10%">Return Date<span id="username_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="10%">Status<span id="username_icon"></span></th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @include('sparepart.table-retsparepartwhsbrowse')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!-- transfer Sparepart View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Return Sparepart Warehouse View Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin: 0px 0px 0.8em 0px;">
                    <label for="v_rsnumber" class="col-md-2 col-form-label">RT Number</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="v_rsnumber" name="v_rsnumber" readonly>
                    </div>
                    <label for="v_retby" class="col-md-2 col-form-label">Returned By</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="v_retby" name="v_retby" readonly>
                    </div>
                    <label for="v_retdate" class="col-md-2 col-form-label">Returned Date</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="v_retdate" name="v_retdate" readonly>
                    </div>
                </div>
                <div class="form-group row" style="margin: 0px 0px 1.5em 0px;">
                    <label for="v_trfby" class="col-md-2 col-form-label">Transferred By</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="v_trfby" name="v_trfby" readonly>
                    </div>
                    <label for="v_trfdate" class="col-md-2 col-form-label">Transferred Date</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="v_trfdate" name="v_trfdate" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <table width="100%" id='asetTable' class='table table-striped table-bordered dataTable no-footer order-list'>
                        <thead>
                            <th width="20%">Spare part</th>
                            <th width="8%">Qty Req</th>
                            <!-- <th width="8%">Site From</th> -->
                            <th width="20%">Site & Location & Lot From</th>
                            <th width="15%">Request SP Note</th>
                            <th width="8%">Qty Trf</th>
                            <!-- <th width="8%">Site To</th> -->
                            <th width="15%">Site & Location To</th>
                            <th width="15%">Transfer SP Note</th>
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
@endsection
@section('scripts')
<script>
    $(document).on('click', '.viewtrfsp', function() {

        $('#viewModal').modal('show');

        var rsnumber = $(this).data('rsnumber');
        var retby = $(this).data('retby');
        var duedate = $(this).data('duedate');
        var trfby = $(this).data('trfby');
        var trfdate = $(this).data('trfdate');

        document.getElementById('v_rsnumber').value = rsnumber;
        document.getElementById('v_retby').value = retby;
        document.getElementById('v_retdate').value = duedate;
        document.getElementById('v_trfby').value = trfby;
        document.getElementById('v_trfdate').value = trfdate;

        $.ajax({
            url: "retspwhsviewdet?code=" + rsnumber,
            success: function(data) {
                // console.log(data);
                $('#v_detailapp').html('').append(data);
            }
        })

    });

    function resetSearch() {
        $('#s_nomorwo').val('');
        $('#s_asset').val('');
        $('#s_priority').val('');
    }

    $(document).ready(function() {
        var cur_url = window.location.href;

        let paramString = cur_url.split('?')[1];
        let queryString = new URLSearchParams(paramString);

        let asset = queryString.get('s_asset');
        let priority = queryString.get('s_priority');

        $('#s_asset').val(asset).trigger('change');
        $('#s_priority').val(priority).trigger('change');
    });

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });
</script>
@endsection