@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Release Detail</h1>
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
                                <td style="text-align: center; width: 8% !important; font-weight: bold;">Repair Code</td>
                                <td style="text-align: center; width: 12% !important; font-weight: bold;">Instruction Code</td>
                                <td style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</td>
                                <td style="text-align: center; width: 8% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 15% !important; font-weight: bold;">Qty to Request</td>
                                <td style="text-align: center; width: 11% !important; font-weight: bold;">Note</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Delete</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @php($dline = 1)
                            @forelse ( $combineSP as $datas )

                            <!-- Desc Item -->
                            @if($datas->insd_part_desc == "")
                                @php($qsp = $spdata->where('spm_code','=',$datas->insd_part)->count())
                                @if($qsp == 0)
                                    @php($descpart = "")
                                @else
                                    @php($rssp = $spdata->where('spm_code','=',$datas->insd_part)->first())
                                    @php($descpart = $rssp->spm_desc)
                                @endif
                            @else
                                @php($descpart = $datas->insd_part_desc)
                            @endif

                            <!-- Qty Conf -->
                            <!-- @php($qwhsconf = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->count()) -->
                            <!-- @php($qwhsconf = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_line','=',$dline)->count()) jika line yang tersimpan mulai dari 2, ini tidak bisa digunakan -->
                            @php($qwhsconf = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->count())
                            @if($qwhsconf == 0)
                            @php($dqtyreq = $datas->insd_qty)
                            @php($whsconf = "")
                            @php($whsdate = "")
                            @php($dqtyrequire = 0)
                            @php($note_release = "")
                            @else
                            <!-- @php($cwhsconf = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->first()) -->
                            @php($cwhsconf = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_line','=',$datas->wo_dets_line)->first())
                            @php($dqtyreq = $cwhsconf->wo_dets_wh_qty)
                            @php($whsconf = $cwhsconf->wo_dets_wh_conf)
                            @php($whsdate = $cwhsconf->wo_dets_wh_date)
                            @php($dline = $cwhsconf->wo_dets_line)
                            @php($dqtyrequire = $cwhsconf->wo_dets_sp_qty)
                            @php($note_release = $cwhsconf->wo_dets_worelease_note)
                            @endif

                            @if ($datas->repair_code != null)
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->repair_code}}
                                    <input type="hidden" name="repcode[]" value="{{$datas->repair_code}}" />
                                    <input type="hidden" name="line[]" id="line" value="{{$dline}}" />
                                    @php($dline = $dline + 1)
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->ins_code}}
                                    <input type="hidden" name="inscode[]" value="{{$datas->ins_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->insd_part}} -- {{$descpart}}
                                    <input type="hidden" name="partneed[]" value="{{$datas->insd_part}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{number_format($datas->insd_qty ?? $dqtyrequire,2)}}
                                    <input type="hidden" name="qtyreq[]" value="{{$datas->insd_qty}}" />
                                </td>
                                @if($whsconf == "1")
                                <!-- jika warehouse sudah melakukan confirm -->
                                <td style="vertical-align:middle;text-align:right;">
                                    {{ number_format($dqtyreq,2) }}
                                    <input type="hidden" class="form-control" step="1" min="0" name="qtyrequest[]" value="{{$dqtyreq}}" />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea class="form-control" name="note_release[]" id="note_release[]" style="width: 100%;" maxlength="99">{{ $note_release }}</textarea>
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    {{date('Y-m-d', strtotime($whsdate))}}
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                </td>
                                @else
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control" step="1" min="0" name="qtyrequest[]" value="{{$datas->insd_qty ?? $dqtyrequire}}" required />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea class="form-control" name="note_release[]" id="note_release[]" style="width: 100%;" maxlength="99">{{ $note_release }}</textarea>
                                </td>
                                @if($datas->wo_status == "plan")
                                <!-- jika belum pernah direlease akan muncul tombol delete -->

                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete">
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                </td>
                                @else
                                <!-- jika sudah pernah dilakukan release namun warehouse belum confirm -->
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="checkbox" class="qaddel" name="qaddel[]" value="">
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                </td>
                                @endif
                                @endif
                            </tr>
                            @endif
                            
                            @empty
                            <tr>
                                <td>
                                    <select name="repcode[]" style="display: inline-block !important;" class="form-control selectpicker repcode" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px" required autofocus>
                                        <option value=""> -- Select Data -- </option>
                                        @foreach($rc as $rd)
                                        <option value="{{$rd->repm_code}}"> {{$rd->repm_code}} -- {{$rd->repm_desc}} </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select name="inscode[]" style="display: inline-block !important;" class="form-control selectpicker insclass" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px" required autofocus>
                                        <option value=""> -- Select Data -- </option>
                                        @foreach($insdata as $insdats)
                                        <option data-repcode2="{{$insdats->repm_code}}" value="{{$insdats->repdet_ins}}"> {{$insdats->repdet_ins}} -- {{$insdats->ins_desc}} </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select name="partneed[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="200px" required autofocus>
                                        <option value=""> -- Select Data -- </option>
                                        @foreach($spdata as $da)
                                        <option value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number" class="form-control qtyreq" name="qtyreq[]" step="1" min="1" required />
                                </td>

                                <td>
                                    <input type="number" class="form-control qtyrequest" name="qtyrequest[]" step="1" min="1" required />
                                    <input type="hidden" class="line" name="line[]" id="line" />
                                </td>

                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea class="form-control" name="note_release[]" id="note_release[]" style="width: 100%;" maxlength="99"></textarea>
                                </td>

                                <td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>
                                <input type="hidden" class="op" name="op[]" value="A" />
                            </tr>
                            
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
            <a class="btn btn-danger" href="/worelease" id="btnback">Back</a>
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
            cols += '<select name="repcode[]" style="display: inline-block !important;" class="form-control selectpicker repcode" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px" required autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($rc as $rd)
            cols += '<option value="{{$rd->repm_code}}"> {{$rd->repm_code}} -- {{$rd->repm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<select name="inscode[]" style="display: inline-block !important;" class="form-control selectpicker insclass" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px" required autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($insdata as $insdats)
            cols += '<option data-repcode2="{{$insdats->repm_code}}" value="{{$insdats->repdet_ins}}"> {{$insdats->repdet_ins}} -- {{$insdats->ins_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<select name="partneed[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="200px" autofocus >';
            cols += '<option value = ""> -- Select Data -- </option>';
            @foreach($spdata as $da)
            cols += '<option value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="number" class="form-control qtyrequest" name="qtyrequest[]" step="1" min="0" required />';
            cols += '<input type="hidden" class="line" name="line[]" id="line" />';
            cols += '</td>';

            cols += '<td>';
            cols += '<textarea class="form-control" name="note_release[]" id="note_release[]" style="width: 100%;" maxlength="99" ></textarea>';
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

        $(document).on('change', 'select.repcode', function() {

            // console. log(jQuery(). jquery);
            var rc = $(this).val();
            var a = $(this).closest("tr").find('div').find('.insclass option');
            // console.log(a);

            a.each(function(e) {

                if ($(this).data('repcode2') != rc) {
                    $(this).remove();
                    // $(this).prop('disabled', false);
                }

            })
            $(this).closest("tr").find('.insclass').selectpicker('refresh');

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
    });
</script>
@endsection