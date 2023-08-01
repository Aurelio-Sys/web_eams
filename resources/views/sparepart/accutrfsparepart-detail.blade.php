@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Accumulative Sparepart Transfer Detail</h1>
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

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="col-lg-12 col-md-12">
    <form action="/submitaccutrf" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <div class="modal-header">
        </div>

        <div class="table-responsive modal-body">
            <div class="form-group row">
                <div class="table-responsive col-lg-12 col-md-12 tag-container" style="overflow-x: auto; display:inline-table; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0" >
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Asset Site</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Total Required</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Total Supply</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Location & Lot From</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Location To</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty to Transfer</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $output as $index => $spd )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    @php
                                        $getdesc_assetsite = $data_assetsite->where('assite_code','=', $spd['t_siteasset'])->first();

                                        $assetsite_desc = $getdesc_assetsite->assite_desc;
                                    @endphp

                                    {{$spd['t_siteasset']}} -- {{$assetsite_desc}}
                                    <input type="hidden" class="siteasset_hidden" name="siteasset_hidden[]" value="{{$spd['t_siteasset']}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    @php
                                        $getdesc_sp = $data_sp->where('spm_code','=', $spd['t_part'])->first();

                                        $sp_desc = $getdesc_sp->spm_desc;
                                    @endphp
                                    {{$spd['t_part']}} -- {{$sp_desc}}
                                    <input type="hidden" class="spcode_hidden" name="spcode_hidden[]" value="{{$spd['t_part']}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$spd['t_qtyreq']}}
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{number_format($spd['t_qtyoh'],2)}}
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" data-index="{{ $index }}" placeholder="Click Here">
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" /> 
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <select id="locto" class="form-control locto selectpicker" name="locto[]" data-dropup-auto="false" data-live-search="true">
                                        <option></option>
                                        @foreach ( $datalocsupply as $dtloc  )
                                            @if($dtloc->inp_asset_site == $spd['t_siteasset'])
                                                <option value="{{$dtloc->inp_loc}}" data-siteto="{{$dtloc->inp_supply_site}}">{{$dtloc->inp_supply_site}}, {{$dtloc->inp_loc}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="hidden_siteto" name="hidden_siteto[]" value="" />
                                    <input type="hidden" class="hidden_locto" name="hidden_locto[]" value="" />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <input type="number" id="qtytotransfer" class="form-control qtytotransfer" name="qtytotransfer[]" min="0" value="0" step="0.01" required />
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <!-- <input type="checkbox" class=""custom-control custom-checkbox" name="checkbox[]" value="N"> -->
                                    <input type="hidden" value="N" name="hide_check[]" class="hide_check" />
                                    <input class="transferchecker" type="checkbox" name="transferchecker[]" />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="color: red; text-align: center;" >No Data Available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container" style="text-align: center;" >
            <label>
                <input type="checkbox" id="confirmation-checkbox" required/> Confirm Transfer
            </label>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/accutransfer" id="btnback">Back</a>
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

        $(document).on('click','.transferchecker',function(){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked')) {
                $(this).closest("tr").find('.hide_check').val('Y');
                $(this).closest('tr').find('.loclotfrom').prop('required', true);
                $(this).closest('tr').find('.locto').prop('required', true);
            } else {
                $(this).closest("tr").find('.hide_check').val('N');
                $(this).closest('tr').find('.loclotfrom').prop('required', false);
                $(this).closest('tr').find('.locto').prop('required', false);
            }

        });

        $('body').on('change', 'input[name="checkbox[]"]', function() {
            // Periksa apakah checkbox dicentang atau tidak
            if ($(this).is(':checked')) {
                $(this).val('Y'); // Ubah nilai checkbox menjadi "Y"
                $(this).closest('tr').find('.loclotfrom').prop('required', true);
                $(this).closest('tr').find('.locto').prop('required', true);
            } else {
                $(this).val('N'); // Ubah nilai checkbox menjadi "N"
            }
        });

        $('#site_search').select2({
            placeholder: 'Select Asset Site',
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            closeOnSelect: true,
            templateSelection: function (data, container) {
                // Memotong teks opsi menjadi 20 karakter
                var text = data.text.slice(0, 20);
                // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
                return text + (data.text.length > 20 ? '...' : '');
            }
        });

        $('#spsearch').select2({
            placeholder: 'Select Asset Site',
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            closeOnSelect: true,
            templateSelection: function (data, container) {
                // Memotong teks opsi menjadi 20 karakter
                var text = data.text.slice(0, 20);
                // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
                return text + (data.text.length > 20 ? '...' : '');
            }
        });

        // untuk membuat readonly
        $(".readonly").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) // ignore tab
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


        $('#searchbtn').click(function() {
            var siteSearchValue = $('#site_search').val();
            var spSearchValue = $('#spsearch').val();

            $.ajax({
                url: '/searchaccutrf',
                type: 'GET',
                data: {
                    site_search: siteSearchValue,
                    spsearch: spSearchValue
                },
                success: function(response) {
                    var html = '';
                    // Buat struktur tabel dengan menggunakan data response
                    // dan tambahkan ke dalam elemen tbody dengan id 'detailapp'
                    // sesuaikan dengan struktur data dan penempatan di tabel Anda
                    // response.forEach(function(data) {
                    //     html += '<tr>';
                    //     html += '<td>' + data.asset_site + '</td>';
                    //     html += '<td>' + data.spare_part + '</td>';
                    //     html += '<td>' + data.total_required + '</td>';
                    //     html += '<td>' + data.total_supply + '</td>';
                    //     html += '<td>' + data.location_lot_from + '</td>';
                    //     html += '<td>' + data.location_to + '</td>';
                    //     html += '<td>' + data.qty_to_transfer + '</td>';
                    //     html += '</tr>';
                    // });

                    // $('#detailapp').html(html);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.loclotfrom', function() { 
            var row = $(this).closest("tr");
            const spcode = row.find(".spcode_hidden").val();
            const getassetsite = row.find('.siteasset_hidden').val();

            $.ajax({
                url: '/getwsastockfrom',
                method: 'GET',
                data: {
                    assetsite : getassetsite,
                    spcode : spcode,
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
                            const qtyoh = record.t_qtyoh;
                            row.find(".hidden_sitefrom").val(site);
                            row.find(".hidden_locfrom").val(loc);
                            row.find(".hidden_lotfrom").val(lot);

                            const loclot = `${site},${loc},${lot}`;

                            row.find(".loclotfrom").val(loclot);
                            row.find(".loclotfrom").attr('title',loclot);
                            

                            const qtyohold = row.find(".qtytotransfer").val();

                            //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                            if(parseFloat(qtyohold) > parseFloat(qtyoh)){
                                row.find(".qtytotransfer").attr("max", qtyoh).val(qtyoh);
                            }else{
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
                    

                },complete: function(vamp) {
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

        $(document).on('change', 'select.locto', function(){

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