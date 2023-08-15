@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Sparepart Warehouse Detail</h1>
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

    input::placeholder {
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="form-group row col-md-12">
        <label class="col-md-3 col-form-label text-md-right">Return Sparepart Number</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="rs_num" name="rs_num" value="{{$data->ret_sp_number}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Returned Date</label>
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control" id="due_date" name="due_date" value="{{date('d-m-Y',strtotime($data->created_at))}}" readonly>
        </div>
        <label class="col-md-3 col-form-label text-md-right">WO Number</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="wo_num" name="wo_num" value="{{$data->ret_sp_wonumber}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Returned By</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="req_by" name="req_by" value="{{$data->ret_sp_return_by}}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/retspwhssubmit" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <input type="hidden" name="hide_rsnum" value="{{$data->ret_sp_number}}" />

        <div class="modal-header">
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive col-lg-12 col-md-12 tag-container" style="overflow-x: auto; display:inline-table; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Spare Part Code</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Spare Part Desc</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Return</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Return SP Note</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location From</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location To</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty to Transfer</td>
                                <td style="text-align: center; width: 12% !important; font-weight: bold;">Transfer SP Note</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $sparepart_detail as $index => $spd )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->ret_spd_sparepart_code}}
                                    <input type="hidden" class="hidden_spcode" name="hidden_spcode[]" value="{{$spd->ret_spd_sparepart_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->spm_desc}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->ret_spd_qty_return}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->ret_spd_engnote}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd->ret_spd_loc_from}}
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="{{$spd->ret_spd_site_from}}" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="{{$spd->ret_spd_loc_from}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <input type="text" id="loclotto" class="form-control loclotto readonly" name="loclotto[]" data-toggle="tooltip" data-index="{{ $index }}" readonly required placeholder="Click Here">
                                    <input type="hidden" class="hidden_siteto" name="hidden_siteto[]" value="" />
                                    <input type="hidden" class="hidden_locto" name="hidden_locto[]" value="" />
                                    <input type="hidden" class="hidden_lotto" name="hidden_lotto[]" value="" />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <input type="number" id="qtytotransfer" class="form-control qtytotransfer" name="qtytotransfer[]" min="0.01" value="{{$spd->ret_spd_qty_return}}" step="0.01" max="{{$spd->ret_spd_qty_return}}" required />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <textarea type="text" id="notes" class="form-control notes" name="notes[]" rows="2" ></textarea>
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
            <a class="btn btn-danger" href="/retspwhs" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf" disabled>Confirm</button>
            <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Location & Lot To</h4>
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

        $(document).on('click', '.loclotto', function() {
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_spcode").val();

            $.ajax({
                url: '/getretspwsastockfrom',
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
                    const headerColumns = ["Part", "Site", "Location", "Quantity", "Select"];
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
                            // const columns = ["t_part", "t_site", "t_loc", "t_lot", "t_qtyoh"];
                            const columns = ["t_part", "t_site", "t_loc", "totalqty"];
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
                                // const lot = record.t_lot;
                                const qtyoh = record.t_qtyoh;
                                row.find(".hidden_siteto").val(site);
                                row.find(".hidden_locto").val(loc);
                                // row.find(".hidden_lotto").val(lot);

                                const loclot = `site: ${site} & loc: ${loc} & lot: ${lot}`;

                                row.find(".loclotto").val(loclot);
                                row.find(".loclotto").attr('title', loclot);


                                // const qtyohold = row.find(".qtytotransfer").val();

                                // //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                // if (parseFloat(qtyohold) > parseFloat(qtyoh)) {
                                //     row.find(".qtytotransfer").attr("max", qtyoh).val(qtyoh);
                                // }

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