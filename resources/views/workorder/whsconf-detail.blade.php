@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Transfer Detail</h1>
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
            <input type="text" class="form-control" id="wo_num" name="wo_num" value="{{$data->wo_number}}" readonly>
        </div>
        <label class="col-md-1 col-form-label text-md-right">Asset</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="asset" name="asset" value="{{$data->asset_desc}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Start Date</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="start_date" name="start_date" value="{{$data->wo_start_date}}" readonly>
        </div>
    </div>
    <div class="form-group row col-md-12">
        <label class="col-md-2 col-form-label text-md-right">SR Number</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="sr_num" name="sr_num" value="{{$data->wo_sr_number != null ? $data->wo_sr_number : '-'}}" readonly>
        </div>
        <label class="col-md-1 col-form-label text-md-right">Priority</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="prior" name="prior" value="{{$data->wo_priority}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Due Date</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="duedate" name="duedate" value="{{$data->wo_due_date}}" readonly>
            <input type="hidden" id="hidden_assetsite" value="{{$data->wo_site}}" />
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="col-lg-12 col-md-12">
    <form action="/whssubmit" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <input type="hidden" name="hide_wonum" value="{{$data->wo_number}}" />

        <div class="modal-header">
        </div>

        <div class="table-responsive modal-body">
            <div class="form-group row">
                <div class="table-responsive col-lg-12 col-md-12 tag-container" style="overflow-x: auto; display:inline-table; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Spare Part Code</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Spare Part Desc</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Total Required</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Supply Stock</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Transferred</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location & Lot From</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location To</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty to Transfer</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $sparepart_detail as $index => $spd )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->wd_sp_spcode}}
                                    <input type="hidden" class="hidden_spcode" name="hidden_spcode[]" value="{{$spd->wd_sp_spcode}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->spm_desc}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->wd_sp_required}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    @php

                                    $tSpcode = $spd->wd_sp_spcode;
                                    $tAssetSite = $data->wo_site;

                                    $tTotalReq = null;

                                    foreach ($datatemp_required as $totreq) {
                                    if ($totreq['t_spcode'] === $tSpcode && $totreq['t_asset_site'] === $tAssetSite) {
                                    $tTotalReq = $totreq['t_total_req'];
                                    break;
                                    }
                                    }
                                    @endphp
                                    {{ $tTotalReq }}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    @php

                                    $tSpcode = $spd->wd_sp_spcode;

                                    $tTotalStock = null;

                                    foreach ($result as $totstock) {
                                    if ($totstock['part'] === $tSpcode) {
                                    $tTotalStock = $totstock['qtyoh'];
                                    break;
                                    }
                                    }
                                    @endphp
                                    {{number_format($tTotalStock, 2)}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->wd_sp_whtf}}
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" data-index="{{ $index }}" required placeholder="Click Here">
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <select style="display: inline-block !important;" id="locto" class="form-control locto selectpicker" name="locto[]" data-dropup-auto="false" data-live-search="true" data-container="body" required>
                                        <option></option>
                                        @foreach ( $datalocsupply as $dtloc )
                                        <option value="{{$dtloc->inp_loc}}" data-siteto="{{$dtloc->inp_supply_site}}">{{$dtloc->inp_supply_site}}, {{$dtloc->inp_loc}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="hidden_siteto" name="hidden_siteto[]" value="" />
                                    <input type="hidden" class="hidden_locto" name="hidden_locto[]" value="" />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <input type="number" id="qtytotransfer" class="form-control qtytotransfer" name="qtytotransfer[]" min="0" value="{{$spd->wd_sp_required}}" step="0.01" required />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="color: red; text-align: center;">No Data Available</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="container" style="text-align: center;">
            <label>
                <input type="checkbox" id="confirmation-checkbox" required /> Confirm Transfer
            </label>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/wotransfer" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf" disabled>Confirm</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none; width: 150px !important;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
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


<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>
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
        $('#submit').submit(function(event) {
            // Cek apakah semua qtytotransfer bernilai 0
            const inputs = $('.qtytotransfer');
            let allZero = true;

            for (const input of inputs) {
                if (parseFloat(input.value) > 0) {
                    allZero = false;
                    break;
                }
            }

            // Jika semua bernilai 0, tampilkan alert dan hentikan submit
            if (allZero) {
                event.preventDefault();
                alert('Please enter a value greater than 0 for at least one Qty to Transfer field.');
                return;
            }

            // Tampilkan elemen loading dan sembunyikan tombol lain
            document.getElementById('btnconf').style.display = 'none';
            document.getElementById('btnback').style.display = 'none';
            document.getElementById('btnloading').style.display = '';

        });

        $(document).on('keyup', '.qtytotransfer', function() {
            var thisrow = $(this);
            var valueinput = thisrow.val();

            if (valueinput !== '0') {
                // console.log('add required');
                thisrow.closest('tr').find('.loclotfrom').attr('required', 'required');
                thisrow.closest('tr').find('.locto').attr('required', 'required');
            } else {
                // console.log('hapus required');
                thisrow.closest('tr').find('.loclotfrom').removeAttr('required');
                thisrow.closest('tr').find('.locto').removeAttr('required');
            }
        });

        // untuk membuat readonly
        $(".readonly").on('keydown paste focus mousedown', function(e) {
            if (e.keyCode != 9) // ignore tab
                e.preventDefault();
        });

        // $('.locto').select2({
        //     placeholder: 'Select Location To',
        //     width: '100%',
        //     theme: 'bootstrap4',
        //     allowClear: true,
        //     closeOnSelect: false,
        //     templateSelection: function (data, container) {
        //         // Memotong teks opsi menjadi 20 karakter
        //         var text = data.text.slice(0, 20);
        //         // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
        //         return text + (data.text.length > 20 ? '...' : '');
        //     }
        // });

        $(document).on('click', '.loclotfrom', function() {
            $('#loadingtable').modal('show');
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_spcode").val();
            const getassetsite = document.getElementById('hidden_assetsite').value;

            $.ajax({
                url: '/getwsastockfrom',
                method: 'GET',
                data: {
                    assetsite: getassetsite,
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
                    const headerColumns = ["Part", "Site", "Location", "Lot", "Quantity",  "UM", "Select"];
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

                            const loclot = `${site}, ${loc}, ${lot}`;

                            row.find(".loclotfrom").val(loclot);
                            row.find(".loclotfrom").attr('title', loclot);


                            const qtyohold = row.find(".qtytotransfer").val();

                            //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                            if (parseFloat(qtyohold.replace(/,/g, '')) > parseFloat(qtyoh.replace(/,/g, ''))) {
                                row.find(".qtytotransfer").attr("max", qtyoh);

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
        });

        $(document).on('change', 'select.locto', function() {

            var row = $(this).closest("tr");
            const locto = row.find(':selected').val();
            const siteto = row.find(':selected').data('siteto');


            row.find('.hidden_siteto').val(siteto);
            row.find('.hidden_locto').val(locto);

        });

        const confirmationCheckbox = document.getElementById("confirmation-checkbox");
        const transferButton = document.getElementById("btnconf");

        // checkbox confirm transfer
        confirmationCheckbox.addEventListener("change", () => {
            if (confirmationCheckbox.checked) {
                transferButton.disabled = false;
            } else {
                transferButton.disabled = true;
            }
        });
    });
</script>
@endsection