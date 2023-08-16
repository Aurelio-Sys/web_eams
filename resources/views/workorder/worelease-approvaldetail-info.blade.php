@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">WO Release Approval Detail</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<style type="text/css">
    .bootstrap-select .dropdown-menu {
        width: 350px !important;
        min-width: 350px !important;
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

    input::placeholder {
        font-weight: bold;
    }
</style>
<div class="row">
    <form class="form-horizontal newedit" id="newedit" method="post" action="/approvewo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <input type="hidden" name="repairtype" id="repairtype" value="">
            <input type="hidden" id="v_counter">
            <input type="hidden" id="idwo" name="idwo" value="{{$idwo->id}}">
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
                    <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" value="{{$header->wo_number}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" value="{{$header->wo_sr_number}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetcode" type="text" class="form-control pl-0 col-md-12 c_assetcode" style="background:transparent;border:none;text-align:left" name="c_assetcode" value="{{$header->asset_code}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetdesc" type="text" class="form-control pl-0 col-md-12 c_assetdesc" style="background:transparent;border:none;text-align:left" name="c_assetdesc" value="{{$header->asset_desc}}" readonly />
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
                    <input id="c_startdate" type="text" class="form-control pl-0 col-md-12 c_startdate" style="background:transparent;border:none;text-align:left" name="c_startdate" value="{{$header->wo_start_date}}" readonly />
                </div>
                <div class="col-md-3 h-50">
                    <input id="c_duedate" type="text" class="form-control pl-0 col-md-12 c_duedate" style="background:transparent;border:none;text-align:left" name="c_duedate" value="{{$header->wo_due_date}}" readonly />
                    <input type="hidden" id="hidden_assetsite" name="hidden_assetsite" value="{{$header->wo_site}}" />
                </div>
            </div>

            <div class="row mt-2">
                <div class="row col-md-12">
                    <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
                </div>
            </div>
            <!-- Spare Part -->

            <!-- <div style="border: 1px solid black; padding-top: 5%; padding-bottom: 5%; padding-left: 5%; padding-right: 5%;"> -->
            <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                            <!-- <th style="text-align: center; width: 10% !important; font-weight: bold;">Issue</th> -->
                            <th style="text-align: center; width: 10% !important; font-weight: bold;">Required</th>
                            <!-- <th style="text-align: center; width: 10% !important; font-weight: bold;">Issued</th> -->
                            <!-- <th style="text-align: center; width: 10% !important; font-weight: bold;">Location & Lot</th> -->
                            <!-- <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th> -->
                        </tr>
                    </thead>
                    <tbody id='detailapp'>
                        @forelse ( $sparepart as $datas )
                        <tr>
                            <td style="vertical-align:middle;text-align:left;">
                                {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                <input type="hidden" class="hidden_sp" name="hidden_sp[]" value="{{$datas->spm_code}}" />
                            </td>
                            @php
                            $difference = number_format($datas->wd_sp_required - $datas->wd_sp_issued, 2, '.', '');
                            if ($difference < 0) { $difference=0; } @endphp <!-- <td style="vertical-align:middle;text-align:center;">
                                <input type="number" class="form-control qtypotong" step="0.01" min="{{ $datas->wd_sp_issued == 0 ? 0 : -$datas->wd_sp_issued }}" name="qtypotong[]" value="{{$difference}}" required />
                                </td> -->
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->wd_sp_required}}
                                    <input type="hidden" name="qtyrequired[]" value="{{$datas->wd_sp_required}}" />
                                </td>
                                <!-- <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->wd_sp_issued}}
                                    <input type="hidden" class="qtyissued" name="qtyissued[]" value="{{$datas->wd_sp_issued}}" />
                                </td> -->
                                <!-- <td style="vertical-align: middle; text-align: left;">
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off" readonly placeholder="Click Here">
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" /> 
                                </td> -->
                                <!-- <td style="vertical-align:middle;text-align:center;">
                                
                                </td> -->
                        </tr>

                        @empty
                        <!--
                            <tr>
                                <td>
                                    <select style="display: inline-block !important;" class="form-control selectpicker spreq" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px">
                                        <option value=""> -- Select Spare Part -- </option>
                                        @foreach($newsparepart as $da)
                                        <option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="hidden_sp" name="hidden_sp[]" />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control qtypotong" min="0" step="0.01" name="qtypotong[]" value="0" required />
                                </td>
                                <td>
                                    <input type="hidden" name="qtyrequired[]" value="0" />
                                </td>
                                <td>
                                    <input type="hidden" class="qtyissued" name="qtyissued[]" value="0" />
                                </td>
                                <td>
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off">
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />
                                </td>
                                <td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>
                                <input type="hidden" class="op" name="op[]" value="A" />
                            </tr>

                            -->

                        @endforelse
                    </tbody>
                    <!-- <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add New Spare Part" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot> -->
                </table>
            </div>
            <!-- </div> -->

            <!-- End Spare Part -->
            <div class="form-group row col-md-12" style="display: none;">
                <label for="v_reason" class="col-md-4 col-form-label text-md-left">Reason</label>
                <div class="col-md-6">
                    <textarea id="v_reason" name="v_reason" class="form-control" rows="3" readonly>{{$approver->retr_reason ? $approver->retr_reason : ''}}</textarea>
                </div>
            </div>
            <div class="form-group row col-md-12">
                <label for="v_message" class="col-md-4 col-form-label text-md-left">eAMS Message</label>
                <div class="col-md-6" id="v_message">
                    @if($approver->retr_status == 'approved')
                    <p style="font-weight: bold;color:green;margin-top:5px">{{'this wo release has been approved by ' . $approver->username}}</p>
                    @elseif($approver->retr_status == 'revision')
                    <p style="font-weight: bold;color:red;margin-top:5px">{{'this wo release has been rejected by ' . $approver->username}}</p>
                    @else
                    <p style="font-weight: bold;color:navy;margin-top:5px">please wait the previous approver to do approval</p>
                    @endif
                </div>
            </div>

            <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
            <input type="hidden" id="repairtypenow" name="repairpartnow" />
        </div>

        <div class="modal-footer">
            <a id="btnclose" class="btn btn-info" href="/woreleaseapprovalbrowse" id="btnback">Back</a>
            <!-- <button type="submit" class="btn btn-danger" name="action" value="reject" id="btnreject">Reject</button>
              <button type="submit" class="btn btn-success" name="action" value="approve" id="btnapprove">Approve</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none; width: 150px !important;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Saving
            </button> -->
        </div>
    </form>
</div>


<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Location & Lot From</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="thistablemodal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    var counter = 1;

    function selectPicker() {

        $('.selectpicker').selectpicker();

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

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<select style="display: inline-block !important;" class="form-control selectpicker spreq" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px">';
            cols += '<option value = ""> -- Select Spare Part -- </option>';
            @foreach($newsparepart as $da)
            cols += '<option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '<input type="hidden" class="hidden_sp" name="hidden_sp[]" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="number" class="form-control qtypotong" min="0" step="0.01" name="qtypotong[]" value="0" required />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="hidden" name="qtyrequired[]" value="0" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="hidden" class="qtyissued" name="qtyissued[]" value="0" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="text" id="loclotfrom" class="form-control loclotfrom" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off" readonly placeholder="Click Here">';
            cols += '<input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            cols += '<input type="hidden" class="op" name="op[]" value="A" />';
            counter++;

            newRow.append(cols);
            $("#detailapp").append(newRow);

            // selectRefresh();

            selectPicker();
        });

        $("#addrow_ins").on("click", function() {

            // var line = document.getElementById('line').value;

            var rowCount = $('#createTableIns tr').length;

            var currow = rowCount - 2;

            // alert(currow);

            var lastline = parseInt($('#createTableIns tr:eq(' + currow + ') td:eq(0) input[type="number"]').val()) + 1;

            if (lastline !== lastline) {
                // check apa NaN
                lastline = 1;
            }

            // alert(lastline);

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="number" min="0" step="1" class="form-control stepnumber" name="stepnumber[]" value="' + lastline + '" readonly />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<textarea type="text" class="form-control stepdesc" name="stepdesc[]" maxlength="250">';
            cols += '</textarea>';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<div class="input-group">';
            cols += '<input type="number" min="0" step="0.01" class="form-control ins_duration" id="input-with-select" name="ins_duration[]"/>';
            cols += '<div class="input-group-append">';
            cols += '<select class="form-control durationum" name="durationum[]">';
            @foreach($um as $dataum)
            cols += '<option value="{{$dataum->um_code}}">{{$dataum->um_desc}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</div>';
            cols += '</div>';
            cols += '</td>';

            cols += '<td style="max-width: 100px !important; vertical-align:middle;text-align:center;">';
            cols += '<select class="form-control selectpicker ins_list_eng" name="ins_list_eng[' + (lastline - 1) + '][option][]" style="max-width: 100px !important;" multiple="multiple" data-live-search="true" data-max-options="5" data-size="3" data-dropup-auto="false">';
            @foreach($engineers as $dataeng)
            cols += '<option value="{{$dataeng["eng_code"]}}">{{$dataeng["eng_code"]}} -- {{$dataeng["eng_desc"]}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            counter++;

            newRow.append(cols);
            $("#detailapp_ins").append(newRow);

            // selectRefresh();

            selectPicker();
        });

        $("#addrow_qc").on("click", function() {

            // var line = document.getElementById('line').value;

            var rowCount = $('#createTableQc tr').length;

            var currow = rowCount - 2;

            // alert(currow);

            var lastline = parseInt($('#createTableQc tr:eq(' + currow + ') td:eq(0) input[type="number"]').val()) + 1;

            if (lastline !== lastline) {
                // check apa NaN
                lastline = 1;
            }

            // alert(lastline);

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td>';
            cols += '<input type="text" class="form-control qcparam" name="qcparam[]" maxlength="250" required />';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="text" class="form-control resultqc1" name="resultqc1[]" value="" maxlength="250" />';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            counter++;

            newRow.append(cols);
            $("#detailapp_qc").append(newRow);

            // selectRefresh();

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

        $("#failurecode").select2({
            width: '100%',
            // placeholder: "Select Failure Code",
            theme: "bootstrap4",
            allowClear: true,
            maximumSelectionLength: 3,
            closeOnSelect: false,
            allowClear: true,
            multiple: true,
        });

        $('#newedit').submit(function(event) {

            document.getElementById('btnreject').style.display = 'none';
            document.getElementById('btnapprove').style.display = 'none';
            document.getElementById('btnclose').style.display = 'none';
            document.getElementById('btnloading').style.display = '';

        });

        $(document).on('keyup', '.qtypotong', function() {
            var thisrow = $(this);
            var valueinput = thisrow.val();

            if (valueinput !== '0') {
                // console.log('add required');
                thisrow.closest('tr').find('.loclotfrom').attr('required', 'required');
            } else {
                // console.log('hapus required');
                thisrow.closest('tr').find('.loclotfrom').removeAttr('required');
            }
        });

        // console.log(wonbr);
        var wonbr = document.getElementById('c_wonbr').value;
        var srnumber = document.getElementById('c_srnbr').value;

        // var message = '<?php echo ($approver->retr_approved_by != null) ? "this wo has been " . $approver->retr_status : "please wait the previous approver to do approval"; ?>';

        // $('#v_message').text(message);

        $.ajax({
            url: "/imageview",
            data: {
                wonumber: wonbr,
            },
            success: function(data) {

                /* coding asli ada di backup-20211026 sblm PM attach file, coding aslinya nampilin gambar*/
                //alert('test');

                $('#munculgambar').html('').append(data);
            }
        })

        $.ajax({
            url: "/listuploadview/" + srnumber,
            success: function(data) {
                // console.log(data);
                $('#munculgambar_sr').html('').append(data);
            }
        })

        $(document).on('change', 'select.spreq', function() {
            var row = $(this).closest("tr");
            const spreqOption = $(this).val();

            row.find(".hidden_sp").val(spreqOption);

        });

        $(document).on('click', '.loclotfrom', function() {
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_sp").val();
            const qtypotong = row.find(".qtypotong").val();
            const getassetsite = document.getElementById('hidden_assetsite').value;

            if (qtypotong > 0) {
                //jika qty yang mau diissue bernilai positif
                $.ajax({
                    url: '/getwsasupply',
                    method: 'GET',
                    data: {
                        assetsite: getassetsite,
                        spcode: spcode,
                    },
                    success: function(vamp) {
                        // console.log(vamp);

                        // select elemen HTML tempat menampilkan tabel
                        const tableContainer = document.getElementById("thistablemodal");

                        // hapus tabel lama (jika ada)
                        if (tableContainer.hasChildNodes()) {
                            tableContainer.removeChild(tableContainer.firstChild);
                        }

                        // membuat elemen tabel
                        const table = document.createElement("table");
                        table.setAttribute("class", "table table-bordered table-hover");

                        // membuat header tabel
                        const headerRow = document.createElement("tr");
                        const headerColumns = ["Part", "Site", "Location", "Lot", "Quantity", "Select"];
                        headerColumns.forEach((columnTitle) => {
                            const headerColumn = document.createElement("th");
                            headerColumn.textContent = columnTitle;
                            headerRow.appendChild(headerColumn);
                        });
                        table.appendChild(headerRow);

                        // membuat baris record untuk setiap objek dalam dataLocLotFrom
                        vamp.forEach((record) => {
                            const rowtable = document.createElement("tr");
                            const columns = ["t_part", "t_site", "t_loc", "t_lot", "t_qtyoh"];
                            columns.forEach((columnKey) => {
                                const column = document.createElement("td");
                                column.textContent = record[columnKey];
                                rowtable.appendChild(column);
                            });
                            const selectColumn = document.createElement("td");
                            const selectButton = document.createElement("button");
                            selectButton.setAttribute("class", "btn btn-primary");
                            selectButton.textContent = "Select";
                            selectButton.setAttribute("type", "button");
                            selectButton.addEventListener("click", function() {
                                // aksi yang ingin dilakukan saat tombol select diklik
                                const site = record.t_site;
                                const loc = record.t_loc;
                                const lot = record.t_lot;
                                let qtyoh = record.t_qtyoh;

                                qtyoh = qtyoh.replace(',', '');
                                row.find(".hidden_sitefrom").val(site);
                                row.find(".hidden_locfrom").val(loc);
                                row.find(".hidden_lotfrom").val(lot);

                                const loclot = `site: ${site} & loc: ${loc} & lot: ${lot}`;

                                row.find(".loclotfrom").val(loclot);
                                row.find(".loclotfrom").attr('title', loclot);

                                const qtyohold = row.find(".qtypotong").val();

                                //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                if (parseFloat(qtyohold) > parseFloat(qtyoh)) {
                                    row.find(".qtypotong").attr("max", qtyoh).val(qtyoh);
                                }

                                $('#myModal').modal('hide');
                            });
                            selectColumn.appendChild(selectButton);
                            rowtable.appendChild(selectColumn);
                            table.appendChild(rowtable);
                        });

                        // menampilkan tabel pada elemen HTML yang dituju
                        tableContainer.appendChild(table);

                        // memanggil modal setelah tabel dimuat
                        $('#myModal').modal('show');


                    },
                    complete: function(vamp) {
                        //  $('.modal-backdrop').modal('hide');
                        // alert($('.modal-backdrop').hasClass('in'));

                        setTimeout(function() {
                            $('#loadingtable').modal('hide');
                        }, 500);

                        setTimeout(function() {
                            $('#viewModal').modal('show');
                        }, 1000);

                    }
                })

            } else if (qtypotong < 0) {
                //jika qty yang mau dissue bernilai negatif menandakan bahwa yang sudah diissued ingin dikembalikan lagi dengan receipt unplanned
                const wonumber = $('#c_wonbr').val();

                $.ajax({
                    url: '/getwodetsp',
                    method: 'GET',
                    data: {
                        spcode: spcode,
                        wonumber: wonumber,
                    },
                    success: function(vimp) {

                        // select elemen HTML tempat menampilkan tabel
                        const tableContainer = document.getElementById("thistablemodal");

                        // hapus tabel lama (jika ada)
                        if (tableContainer.hasChildNodes()) {
                            tableContainer.removeChild(tableContainer.firstChild);
                        }

                        // membuat elemen tabel
                        const table = document.createElement("table");
                        table.setAttribute("class", "table table-bordered table-hover");

                        // membuat header tabel
                        const headerRow = document.createElement("tr");
                        const headerColumns = ["Part", "Site", "Location", "Lot", "Quantity", "Select"];
                        headerColumns.forEach((columnTitle) => {
                            const headerColumn = document.createElement("th");
                            headerColumn.textContent = columnTitle;
                            headerRow.appendChild(headerColumn);
                        });
                        table.appendChild(headerRow);

                        // membuat baris record untuk setiap objek dalam dataLocLotFrom
                        vimp.forEach((record) => {
                            const rowtable = document.createElement("tr");
                            const columns = ["wd_sp_spcode", "wd_sp_site_issued", "wd_sp_loc_issued", "wd_sp_lot_issued", "wd_sp_issued"];
                            columns.forEach((columnKey) => {
                                const column = document.createElement("td");
                                column.textContent = record[columnKey];
                                rowtable.appendChild(column);
                            });
                            const selectColumn = document.createElement("td");
                            const selectButton = document.createElement("button");
                            selectButton.setAttribute("class", "btn btn-primary");
                            selectButton.textContent = "Select";
                            selectButton.setAttribute("type", "button");
                            selectButton.addEventListener("click", function() {
                                // aksi yang ingin dilakukan saat tombol select diklik
                                const site = (record.wd_sp_site_issued != null) ? record.wd_sp_site_issued : '';
                                const loc = (record.wd_sp_loc_issued != null) ? record.wd_sp_loc_issued : '';
                                const lot = (record.wd_sp_lot_issued != null) ? record.wd_sp_lot_issued : '';

                                let qtyoh = record.wd_sp_issued;
                                qtyoh = qtyoh.replace(',', '');
                                row.find(".hidden_sitefrom").val(site);
                                row.find(".hidden_locfrom").val(loc);
                                row.find(".hidden_lotfrom").val(lot);

                                const loclot = `site: ${site} & loc: ${loc} & lot: ${lot}`;

                                row.find(".loclotfrom").val(loclot);
                                row.find(".loclotfrom").attr('title', loclot);

                                const qtyohold = row.find(".qtypotong").val();

                                //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                if (parseFloat(qtyohold) < parseFloat(qtyoh)) {
                                    row.find(".qtypotong").attr("min", -qtyoh).val(-qtyoh);
                                }

                                $('#myModal').modal('hide');
                            });
                            selectColumn.appendChild(selectButton);
                            rowtable.appendChild(selectColumn);
                            table.appendChild(rowtable);
                        });

                        // menampilkan tabel pada elemen HTML yang dituju
                        tableContainer.appendChild(table);

                        // memanggil modal setelah tabel dimuat
                        $('#myModal').modal('show');


                    },
                    complete: function(vimp) {
                        //  $('.modal-backdrop').modal('hide');
                        // alert($('.modal-backdrop').hasClass('in'));

                        setTimeout(function() {
                            $('#loadingtable').modal('hide');
                        }, 500);

                        setTimeout(function() {
                            $('#viewModal').modal('show');
                        }, 1000);

                    }
                })
            }
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
    });
</script>
@endsection