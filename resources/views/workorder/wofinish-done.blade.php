@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Report Detail</h1>
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

    .swal-popup {
        font-size: 2rem !important;
    }

    hr.new1 {
        border-top: 1px solid red !important;
    }

    .images {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .images .img,
    .images .pic {
        flex-basis: 31%;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .images .img {
        width: 112px;
        height: 93px;
        background-size: cover;
        margin-right: 10px;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .images .img:nth-child(3n) {
        margin-right: 0;
    }

    .images .img span {
        display: none;
        text-transform: capitalize;
        z-index: 2;
    }

    .images .img::after {
        content: '';
        width: 100%;
        height: 100%;
        transition: opacity .1s ease-in;
        border-radius: 4px;
        opacity: 0;
        position: absolute;
    }

    .images .img:hover::after {
        display: block;
        background-color: #000;
        opacity: .5;
    }

    .images .img:hover span {
        display: block;
        color: #fff;
    }

    .images .pic {
        background-color: #DCDCD4;
        align-self: center;
        text-align: center;
        padding: 40px 0;
        text-transform: uppercase;
        color: whitesmoke;
        font-size: 12px;
        cursor: pointer;
    }
</style>
<div class="row">
    <form class="form-horizontal" id="newedit" method="post" action="/reportingwo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <input type="hidden" name="repairtype" id="repairtype" value="">
            <input type="hidden" id="v_counter">
            <input type="hidden" name="statuswo" id="statuswo">
            <div class="form-group row col-md-12">
                <div class="col-md-3 h-50">
                    <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_assetcode" class="col-md-12 col-form-label text-md-left p-0">Asset Code</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_assetdesc" class="col-md-12 col-form-label text-md-left p-0">Asset Desc</label>
                </div>
                <div class="col-md-3">
                    <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" value="{{$header->wo_number}}" autofocus readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" value="{{$header->wo_sr_number}}" autofocus readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetcode" type="text" class="form-control pl-0 col-md-12 c_assetcode" style="background:transparent;border:none;text-align:left" name="c_assetcode" value="{{$header->asset_code}}" autofocus readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetdesc" type="text" class="form-control pl-0 col-md-12 c_assetdesc" style="background:transparent;border:none;text-align:left" name="c_assetdesc" value="{{$header->asset_desc}}" autofocus readonly/>
                </div>
            </div>
            <div class="form-group row col-md-12">
                    <div class="col-md-3 h-50">
                    <label for="c_startdate" class="col-md-12 col-form-label text-md-left p-0">Start Date WO</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_duedate" class="col-md-12 col-form-label text-md-left p-0">Due Date WO</label>
                </div>
                <div class="col-md-6 h-50">

                </div>
                <div class="col-md-3 h-50">
                    <input id="c_startdate" type="text" class="form-control pl-0 col-md-12 c_startdate" style="background:transparent;border:none;text-align:left" name="c_startdate" value="{{$header->wo_start_date}}" autofocus readonly/>
                </div>
                <div class="col-md-3 h-50">
                    <input id="c_duedate" type="text" class="form-control pl-0 col-md-12 c_duedate" style="background:transparent;border:none;text-align:left" name="c_duedate" value="{{$header->wo_due_date}}" autofocus readonly/>
                </div>
            </div>

            <!-- Spare Part -->
            
            <div style="border: 1px solid black;">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Location & Lot</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Required</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Issued</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Issue</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $sparepart as $datas )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                    <input type="hidden" name="spreq[]" value="{{$datas->spm_code}}" />
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" required>
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" /> 
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->wd_sp_required}}
                                    <input type="hidden" name="qtyrequired[]" value="{{$datas->wd_sp_required}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->wd_sp_issued}}
                                    <input type="hidden" name="qtyissued[]" value="{{$datas->wd_sp_issued}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control" step="0.01" name="qtypotong[]" value="" required />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                
                                </td>
                            </tr>
                            
                            @empty                            
                            
                            <tr>
                                <td>
                                    <select name="spreq[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px" autofocus>
                                        <option value=""> -- Select Spare Part -- </option>
                                        @foreach($newsparepart as $da)
                                        <option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" required>
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />
                                </td>
                                <td>
                                    <!-- qty required -->
                                </td>
                                <td>
                                    <!-- qty issued -->
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control" step="0.01" name="qtypotong[]" value="" required />
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

            <!-- hanya muncul jika WO PM -->
            <div id="preventiveonly" style="display:none">

                <div class="form-group row col-md-12 c_lastmeasurement">
                    <label for="c_repairhour" class="col-md-4 col-form-label text-md-left">Last Measurement</label>
                    <div class="col-md-6">
                        <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01">
                    </div>
                </div>
                <div class="form-group row col-md-12 c_engineerdiv">
                    <label for="c_lastmeasurementdate" class="col-md-4 col-form-label text-md-left">Last Maintenance</label>
                    <div class="col-md-6">
                        <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate" readonly>
                    </div>
                </div>
                <input type="hidden" name="assettype" id="assettype">
            </div>

            <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
            <input type="hidden" id="repairtypenow" name="repairpartnow" />
        </div>

        <div class="modal-footer">
            <a id="btnclose" class="btn btn-danger" href="/woreport" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none; width: 150px !important;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
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
            cols += '<select name="spreq[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px" autofocus >';
            cols += '<option value = ""> -- Select Spare Part -- </option>';
            @foreach($newsparepart as $da)
            cols += '<option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" required>';
            cols += '<input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />';
            cols += '</td>';
            
            cols += '<td>';

            cols += '</td>';
            
            cols += '<td>';

            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="number" class="form-control" step="0.01" name="qtypotong[]" value="" required />';
            cols += '</td>';
            
            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            cols += '<input type="hidden" class="op" name="op[]" value="A" />';
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
    });


    $(document).ready(function() {

        $("#failurecode").select2({
            width: '100%',
            placeholder: "Select Failure Code",
            theme: "bootstrap4",
            allowClear: true,
            maximumSelectionLength: 3,
            closeOnSelect: false,
            allowClear: true,
            multiple: true,
        });

        // if (document.getElementById('argcheck').checked) {
        //     $('#argcheck').change();
        // }

        // if (document.getElementById('arccheck').checked) {
        //     $('#arccheck').change();
        // }

        $('#newedit').submit(function(event) {
            document.getElementById('btnconf').style.display = 'none';
            document.getElementById('btnclose').style.display = 'none';
            document.getElementById('btnloading').style.display = '';
        });

        $('#repairgroup').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
        });
        $('#repaircode1').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
        });
        $('#repaircode2').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
        });
        $('#repaircode3').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
        });

        var wonbr = document.getElementById('c_wonbr').value;

        // console.log(wonbr);

        // $.ajax({
        //   url: "/imageview",
        //   data: {
        //     wonumber: wonbr,
        //   },
        //   success: function(data) {

        //     /* coding asli ada di backup-20211026 sblm PM attach file, coding aslinya nampilin gambar*/
        //     //alert('test');

        //     $('#munculgambar').html('').append(data);
        //   }
        // })


    
    });

    $(document).on('click', '.deleterow', function(e) {
        var data = $(this).closest('tr').find('.rowval').val();

        Swal.fire({
        title: '',
        text: "Delete File ?",
        icon: '',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
        }).then((result) => {
        if (result.value) {
            $.ajax({
            url: "/delfilewofinish/" + data,
            success: function(data) {

                $('#munculgambar').html('').append(data);
            }
            })
        } else {

        }
        })
  });
</script>
@endsection