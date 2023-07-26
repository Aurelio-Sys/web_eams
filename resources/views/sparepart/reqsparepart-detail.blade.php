@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid ml-3">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Request Sparepart Detail</h1>
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

<!-- <div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div> -->

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/reqspsubmit" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <div class="modal-header p-0">
        </div>

        <div class="form-group row" style="padding-left: 1em; margin-top: 1.5em;">
            <label class="col-md-3 col-form-label" style="font-size: 17px">Need date for Spareparts</label>
            <div class="col-md-3">
                <input type="date" class="form-control" id="due_date" name="due_date" value="" required>
            </div>
        </div>
        <div class="form-group row" style="padding-left: 1em; margin-top: 1.5em;">
            <label class="col-md-3 col-form-label" style="font-size: 17px">WO Number</label>
            <div class="col-md-3">
                <select name="wonbr" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" autofocus>
                    <option value=""> -- Select WO Number -- </option>
                    @foreach($womstr as $da)
                    <option value="{{$da->wo_number}}"> {{$da->wo_number}} </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Request</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Location To</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Note</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Delete</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $wo_sp as $datas )

                            <tr>

                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                    <input type="hidden" name="spreq[]" value="{{$datas->spm_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{number_format($datas->spg_qtyreq,2)}}
                                    <input type="hidden" name="qtystandard[]" value="{{$datas->spg_qtyreq}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control" step="1" min="0" name="qtyrequired[]" value="{{$datas->spg_qtyreq}}" required />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea type="text" id="reqnotes" class="form-control reqnotes" name="reqnotes[]" rows="2"></textarea>
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete">
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                </td>

                            </tr>

                            @empty
                            {{--


                            <tr>
                                <td>
                                    <select name="spreq[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="200px" autofocus>
                                        <option value=""> -- Select Spare Part -- </option>
                                        @foreach($sp_all as $da)
                                        <option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                            @endforeach
                            </select>
                            </td>

                            <td>
                                <input type="number" class="form-control qtystandard" name="qtystandard[]" step="1" min="0" required />
                            </td>

                            <td>
                                <input type="number" class="form-control qtyrequired" name="qtyrequired[]" step="1" min="0" required />
                            </td>

                            <td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>
                            <input type="hidden" class="op" name="op[]" value="A" />
                            </tr>
                            --}}

                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add New Spare Part" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/reqsp" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Request to Warehouse</button>
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

            // var line = document.getElementById('line').value;

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
            cols += '<select name="spreq[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="350px" autofocus required>';
            cols += '<option value = ""> -- Select Sparepart -- </option>';
            @foreach($sp_all as $da)
            cols += '<option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="number" class="form-control qtyrequest" name="qtyrequest[]" step=".01" min="0" required />';
            cols += '</td>';

            cols += '<td>';
            cols += '<select name="locto[]" style="display: inline-block !important;" class="form-control selectpicker locto" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="350px" autofocus required>';
            cols += '<option value = ""> -- Select Location To -- </option>';
            @foreach($loc_to as $loc)
            cols += '<option data-siteto="{{$loc->inp_supply_site}}" value="{{$loc->inp_loc}}">{{$loc->inp_loc}}</option>';
            @endforeach
            cols += '</select>';
            cols += '<input type="hidden" class="siteto" name="siteto[]" value=""/>';
            cols += '</td>';
            cols += '<td>';
            cols += '<textarea type="text" id="reqnote" class="form-control reqnote" name="reqnote[]" rows="2" ></textarea>';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
            cols += '<input type="hidden" class="op" name="op[]" value="A"/>';
            cols += '</tr>';
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


        $(document).on('change', '.qaddel', function(e) {
            var checkbox = $(this), // Selected or current checkbox
                value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked')) {
                $(this).closest("tr").find('.tick').val(1);
            } else {
                $(this).closest("tr").find('.tick').val(0);
            }
        });

        $(document).on('change', '.locto', function(e) {
            var selectedOption = $(this).find('option:selected');
            var siteTo = selectedOption.attr('data-siteto');

            var row = $(this).closest("tr");
            row.find(".siteto").val(siteTo);

        });
    });
</script>
@endsection