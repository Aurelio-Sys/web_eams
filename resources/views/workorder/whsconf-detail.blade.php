@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Warehouse Confirm Detail</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<style type="text/css">
    .bootstrap-select .dropdown-menu {
        width: 400px !important;
        min-width: 400px !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
</style>
<div class="row">
    <div class="form-group row col-md-12">
        <label class="col-md-2 col-form-label text-md-right">Work Order</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="wo_num" name="wo_num" value="{{$data->wo_nbr}}" readonly>
        </div>
        <label class="col-md-1 col-form-label text-md-right">Asset</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="asset" name="asset" value="{{$data->asset_desc}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Schedule Date</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="schedule_date" name="schedule_date" value="{{$data->wo_schedule}}" readonly>
        </div>
    </div>
    <div class="form-group row col-md-12">
        <label class="col-md-2 col-form-label text-md-right">SR Number</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="sr_num" name="sr_num" value="{{$data->wo_sr_nbr != null ? $data->wo_sr_nbr : '-'}}" readonly>
        </div>
        <label class="col-md-1 col-form-label text-md-right">Priority</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="prior" name="prior" value="{{$data->wo_priority}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Due Date</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="duedate" name="duedate" value="{{$data->wo_duedate}}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/submitrelease" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <input type="hidden" name="hide_wonum" value="{{$data->wo_nbr}}" />

        <div class="modal-header">
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Repair Code</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Instruction Code</td>
                                <td style="text-align: center; width: 20% !important; font-weight: bold;">Spare Part</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Request</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Site</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Stock</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Confirm</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Confirm</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>

                            @forelse ( $combineSP as $datas )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->repair_code}}
                                    <input type="hidden" name="repcode[]" value="{{$datas->repair_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->ins_code}}
                                    <input type="hidden" name="inscode[]" value="{{$datas->ins_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->insd_part}} -- {{$datas->insd_part_desc}}
                                    <input type="hidden" name="partneed[]" value="{{$datas->insd_part}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->insd_qty}}
                                    <input type="hidden" name="qtyreq[]" value="{{$datas->insd_qty}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->insd_qty}}
                                    <input type="hidden" name="qtyreq[]" value="{{$datas->insd_qty}}" />
                                </td>
                                <td>
                                    <select name="t_site[]" class="form-control t_site">
                                    @foreach($sitedata as $rssite)
                                        <option value="{{ $rssite->site_code }}">{{ $rssite->site_code }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="t_loc[]" class="form-control t_loc">

                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->insd_qty}}
                                    <input type="hidden" name="qtyreq[]" value="{{$datas->insd_qty}}" />
                                </td>
                                <td>
                                    <input type="number" class="form-control" step="1" min="0" name="qtyrequest[]" value="{{$datas->insd_qty}}" required />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <!-- <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"> -->
                                    
                                    <input type="checkbox" class="qaddel" value="">
                                    <input type="hidden" class="op" name="op[]" value="M" />
                                    
                                </td>
                            </tr>
                            @empty

                            @endforelse


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add New Spare Part" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/worelease" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Confirm</button>
            <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var counter = 1;

    function selectPicker() {

        $('.selectpicker').selectpicker().focus();

    }

    $(document).ready(function() {
        $("#addrow").on("click", function() {



            var rowCount = $('#createTable tr').length;

            var currow = rowCount - 2;

            // alert(currow);

            var lastline = parseInt($('#createTable tr:eq(' + currow + ') td:eq(0) input[type="number"]').val()) + 1;

            if (lastline !== lastline) {
                // check apa NaN
                lastline = 1;
            }

            // alert(lastline);

            var newRow = $("<tr>");
            var cols = "";


            cols += '<td>';
            cols += '<select name="repcode[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-width="150px" required autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($rpdata as $rd)
            cols += '<option value="{{$rd->repm_code}}"> {{$rd->repm_code}} -- {{$rd->repm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<select name="inscode[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-width="150px" required autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($insdata as $insdats)
            cols += '<option value="{{$insdats->ins_code}}"> {{$insdats->ins_code}} -- {{$insdats->ins_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<select name="partneed[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-width="150px" required autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($spdata as $da)
            cols += '<option value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="number" class="form-control qtyreq" name="qtyreq[]" step="1" min="1" required />';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="number" class="form-control qtyrequest" name="qtyrequest[]" step="1" min="1" required />';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
            cols += '<input type="hidden" class="op" name="op[]" value="A"/>';
            cols += '</tr>'
            counter++;

            newRow.append(cols);
            $("#detailapp").append(newRow);

            // selectRefresh();

            selectPicker();
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
            var row = $(this).closest("tr");
            var line = row.find(".line").val();
            // var colCount = $("#createTable tr").length;


            if (line == counter - 1) {
                // kalo line terakhir delete kurangin counter
                counter -= 1
            }

            $(this).closest("tr").remove();

            // if(colCount == 2){
            //   // Row table kosong. sisa header & footer
            //   counter = 1;
            // }

        });

        $(document).on('click', '.qaddel', function() {
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked')) {
                $(this).closest("tr").find('.op').val('R');
            } else {
                $(this).closest("tr").find('.op').val('M');
            }

        });

        $(document).on('change', '.t_site', function() {
            var loc = $(this).closest('tr').find('.t_loc');
            var site = $(this).val();
        
              $.ajax({
                  url:"/locasset?t_site="+site,
                  success:function(data){
                      console.log(data);
                      loc.html('').append(data);
                      loc.val(data);
                  }
              }) 
        });

        $(".t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $(".t_site").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });
    });
</script>
@endsection