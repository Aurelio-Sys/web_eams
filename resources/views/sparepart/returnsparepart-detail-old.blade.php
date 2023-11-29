@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid ml-3">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Sparepart Detail</h1>
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

    .table-wo {
        height: 200px;
        overflow-y: auto;
        /* Bilah gulir vertikal */
    }
</style>

<!-- <div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div> -->

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/retspsubmit" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <div class="modal-header p-0">
        </div>

        <!-- <div class="form-group row" style="padding-left: 1em; margin-top: 1.5em;">
            <label class="col-md-3 col-form-label" style="font-size: 17px">Need date for Spareparts</label>
            <div class="col-md-3">
                <input type="date" class="form-control" id="due_date" name="due_date" value="" required>
            </div>
        </div> -->
        <div class="form-group row" style="padding-left: 1em; margin-top: 1.5em;">
            <label class="col-md-3 col-form-label" style="font-size: 17px">WO Number</label>
            <div class="col-md-3">
                <!-- <select name="wonbr" id="wonbr" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" autofocus>
                    <option value=""> -- Select WO Number -- </option>
                    @foreach($womstr as $da)
                    <option value="{{$da->wo_number}}"> {{$da->wo_number}} </option>
                    @endforeach
                </select> -->
                <input type="text" id="wonbr" class="form-control wonbr readonly" name="wonbr" data-toggle="tooltip" readonly required placeholder="Click Here">
                <input type="hidden" class="hidden_wonbr" name="hidden_wonbr" id="hidden_wonbr" value="" />
            </div>
        </div>


        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Return</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Location From</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Note</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Delete</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $wo_sp as $datas )

                            <!-- <tr>

                                <td style="vertical-align:middle;text-align:left;">
                                    <?php
                                    // {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                    ?>
                                    <input type="hidden" name="spret[]" value="{{$datas->spm_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <?php
                                    // {{number_format($datas->spg_qtyreq,2)}}
                                    ?>
                                    <input type="hidden" name="qtystandard[]" value="{{$datas->spg_qtyreq}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control" step="1" min="0" name="qtyrequired[]" value="{{$datas->spg_qtyreq}}" required />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea type="text" id="retnotes" class="form-control retnotes" name="retnotes[]" rows="2"></textarea>
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete">
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                </td>

                            </tr> -->

                            @empty
                            {{--


                            <tr>
                                <td>
                                    <select name="spret[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="200px" autofocus>
                                        <option value=""> -- Select Spare Part -- </option>
                                        @foreach($sp_all as $da)
                                        <option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                            @endforeach
                            <a href="javascript:void(0)" class="viewstok" data-toggle="tooltip" title="View Supply Stock" data-spcode="{{$da->spm_code}}">
                                <i class="icon-table fa fa-search fa-lg"></i>
                            </a>
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
                            <tr id="tfootbtn">
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
            <a class="btn btn-danger" href="/retsp" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Return to Warehouse</button>
            <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>

<div id="woNbrModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select WO Number</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body table-wo" id='wonbrtablemodal'>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stok Supply</h4>
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

<div id="myModalLoc" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Location & Lot From</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="thistablemodalLoc">

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

        $('.selectpicker').selectpicker().focus();

    }

    $(document).ready(function() {

        $(document).on('click', '.wonbr', function() {
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_spcode").val();

            $('#woNbrModal').modal('show');

            $.ajax({
                url: "retspwonbr",
                success: function(data) {
                    // console.log(data);
                    // $('#wonbrtablemodal').html('').append(data);
                    // select elemen HTML tempat menampilkan tabel
                    const tableContainer = document.getElementById("wonbrtablemodal");

                    // hapus tabel lama (jika ada)
                    if (tableContainer.hasChildNodes()) {
                        tableContainer.removeChild(tableContainer.firstChild);
                    }

                    // membuat elemen tabel
                    const table = document.createElement("table");
                    table.setAttribute("class", "table table-bordered table-hover");

                    // membuat header tabel
                    const headerRow = document.createElement("tr");
                    const headerColumns = ["WO Number", "SR Number", "Asset", "WO Note", "Action"];
                    headerColumns.forEach((columnTitle) => {
                        const headerColumn = document.createElement("th");
                        headerColumn.textContent = columnTitle;
                        headerRow.appendChild(headerColumn);
                    });
                    table.appendChild(headerRow);

                    // membuat baris record untuk setiap objek dalam dataLocLotFrom
                    data.forEach((record) => {
                        const rowtable = document.createElement("tr");
                        const columns = ["wo_number", "wo_sr_number", "wo_asset", "wo_note"];
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
                            const wonumber = record.wo_number;

                            document.getElementById('wonbr').value = wonumber;
                            document.getElementById('hidden_wonbr').value = wonumber;

                            $.ajax({
                                url: "retsplistwo?code=" + wonumber,
                                data: {
                                    wonumber: wonumber
                                },
                                success: function(data) {
                                    // console.log(data);
                                    $('#detailapp').html('').append(data);
                                }
                            })

                            if (wonumber != '') {
                                document.getElementById('tfootbtn').style.display = 'none';
                            } else {
                                document.getElementById('tfootbtn').style.display = '';

                            }

                            $('#woNbrModal').modal('hide');
                        });
                        selectColumn.appendChild(selectButton);
                        rowtable.appendChild(selectColumn);
                        table.appendChild(rowtable);
                    });

                    // menampilkan tabel pada elemen HTML yang dituju
                    tableContainer.appendChild(table);

                    // memanggil modal setelah tabel dimuat
                    $('#woNbrModal').modal('show');

                }
            })

        });

        $("#wonbr").on("change", function() {

            var wonumber = document.getElementById('wonbr').value;

            $.ajax({
                url: "retsplistwo?code=" + wonumber,
                data: {
                    wonumber: wonumber
                },
                success: function(data) {
                    // console.log(data);
                    $('#detailapp').html('').append(data);
                }
            })

            if (wonumber != '') {
                document.getElementById('tfootbtn').style.display = 'none';
            } else {
                document.getElementById('tfootbtn').style.display = '';

            }
        })

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
            cols += '<select name="spret[]" style="display: inline-block !important;" class="form-control selectpicker" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="350px" autofocus required>';
            cols += '<option value = ""> -- Select Sparepart -- </option>';
            @foreach($sp_all as $da)
            cols += '<option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>&nbsp;';
            cols += '<a href="javascript:void(0)" class="viewstok" data-toggle="tooltip"  title="View Supply Stock" data-spcode="">';
            cols += '<i class="icon-table fa fa-search fa-lg"></i>';
            cols += '</a>';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="number" class="form-control qtyreturn" name="qtyreturn[]" step=".01" min="0" required />';
            cols += '</td>';

            cols += '<td>';
            // cols += '<select name="locto[]" style="display: inline-block !important;" class="form-control selectpicker locto" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="350px" autofocus required>';
            // cols += '<option value = ""> -- Select Location To -- </option>';
            // @foreach($loc_from as $loc)
            // cols += '<option data-siteto="{{$loc->inp_supply_site}}" value="{{$loc->inp_loc}}">{{$loc->inp_loc}}</option>';
            // @endforeach
            // cols += '</select>';
            @foreach($loc_from as $index => $loc)
            cols += '<input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="locto[]" data-toggle="tooltip" data-index="' + {{$index}} + '" readonly required placeholder="Click Here">';
            cols += '<input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />';
            cols +=  '<input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />';
            cols += '<input type="hidden" class="siteto" name="siteto[]" value=""/>';
            @endforeach
            cols += '</td>';
            cols += '<td>';
            cols += '<textarea type="text" id="retnote" class="form-control retnote" name="retnote[]" rows="2" ></textarea>';
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

        $(document).on('click', '.loclotfrom', function() {
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_spcode").val();

            $.ajax({
                url: '/gettrfspwsastockfrom',
                method: 'GET',
                data: {
                    spcode: spcode,
                },
                success: function(vamp) {
                    // select elemen HTML tempat menampilkan tabel
                    const tableContainer = document.getElementById("thistablemodalLoc");

                    // hapus tabel lama (jika ada)
                    if (tableContainer.hasChildNodes()) {
                        tableContainer.removeChild(tableContainer.firstChild);
                    }

                    // membuat elemen tabel
                    const table = document.createElement("table");
                    table.setAttribute("class", "table table-bordered table-hover");

                    // membuat header tabel
                    const headerRow = document.createElement("tr");
                    const headerColumns = ["Part", "Site", "Location", "Lot", "Quantity", "UM", "Select"];
                    headerColumns.forEach((columnTitle) => {
                        const headerColumn = document.createElement("th");
                        headerColumn.textContent = columnTitle;
                        headerRow.appendChild(headerColumn);
                    });
                    table.appendChild(headerRow);

                    //validasi apakah wsa aktif atau tidak
                    if (Array.isArray(vamp)) {
                        // membuat baris record untuk setiap objek dalam dataLocLotFrom
                        vamp.forEach((record) => {
                            const rowtable = document.createElement("tr");
                            const columns = ["t_part", "t_site", "t_loc", "t_lot", "t_qtyoh", "t_um"];
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
                                const qtyoh = record.t_qtyoh;
                                row.find(".hidden_sitefrom").val(site);
                                row.find(".hidden_locfrom").val(loc);
                                row.find(".hidden_lotfrom").val(lot);

                                const loclot = `site: ${site} & loc: ${loc} & lot: ${lot}`;

                                row.find(".loclotfrom").val(loclot);
                                // console.log(row.find(".loclotfrom").val(loclot));
                                row.find(".loclotfrom").attr('title', loclot);


                                const qtyohold = row.find(".qtytotransfer").val();

                                //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                if (parseFloat(qtyohold) > parseFloat(qtyoh)) {
                                    row.find(".qtytotransfer").attr("max", qtyoh).val(qtyoh);
                                }

                                $('#myModalLoc').modal('hide');
                            });
                            selectColumn.appendChild(selectButton);
                            rowtable.appendChild(selectColumn);
                            table.appendChild(rowtable);
                        });

                        // menampilkan tabel pada elemen HTML yang dituju
                        tableContainer.appendChild(table);

                        // memanggil modal setelah tabel dimuat
                        $('#myModalLoc').modal('show');

                    } else {
                        alert('WSA Connection Failed !!!');
                    }

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

        $(document).on('change', 'select[name="spret[]"]', function() {
            // console.log('masuk');
            var selectedValue = $(this).val();
            
            // Mengubah data-spcode pada elemen <a> yang berada dalam <td> yang sama
            $(this).closest('td').find('.viewstok').attr('data-spcode', selectedValue);
            // console.log("Updated WO Number: ", $(this).closest('td').find('.viewstok').attr('data-spcode')); 
        });

        $(document).on('click', '.viewstok', function() {
            // $('#loadingtable').modal('show');
            var row = $(this).closest("tr");
            const spcode = $(this).attr('data-spcode');
            // const getassetsite = document.getElementById('hidden_assetsite').value;

            $.ajax({
                url: '/gettrfspwsastockfrom',
                method: 'GET',
                data: {
                    spcode: spcode,
                },
                success: function(vamp) {

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
                    const headerColumns = ["Part", "Site", "Location", "Lot", "Quantity", "UM"];
                    headerColumns.forEach((columnTitle) => {
                        const headerColumn = document.createElement("th");
                        headerColumn.textContent = columnTitle;
                        headerRow.appendChild(headerColumn);
                    });
                    table.appendChild(headerRow);

                    // membuat baris record untuk setiap objek dalam dataLocLotFrom
                    vamp.forEach((record) => {
                        const rowtable = document.createElement("tr");
                        const columns = ["t_part", "t_site", "t_loc", "t_lot", "t_qtyoh", "t_um"];
                        columns.forEach((columnKey) => {
                            const column = document.createElement("td");
                            column.textContent = record[columnKey];
                            rowtable.appendChild(column);
                        });
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
        });
    });
</script>
@endsection