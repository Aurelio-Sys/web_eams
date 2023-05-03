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
            <input type="hidden" id="hidden_assetsite" value="{{$data->asset_site}}" />
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/whssubmit" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <input type="hidden" name="hide_wonum" value="{{$data->wo_number}}" />

        <div class="modal-header">
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive col-lg-12 col-md-12 tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0" >
                        <thead>
                            <tr>
                                <td style="text-align: center; width: 7% !important; font-weight: bold;">Spare Part Code</td>
                                <td style="text-align: center; width: 7% !important; font-weight: bold;">Spare Part Desc</td>
                                <td style="text-align: center; width: 20% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Location & Lot From</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Location To</td>
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
                                <td style="vertical-align:middle;text-align:right;">
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom" name="loclotfrom[]" value="" data-index="{{ $index }}">
                                    <input type="hidden" class="hidden_siteform" name="hidden_siteform" value="" />
                                    <input type="hidden" class="hidden_locform" name="hidden_locform[]" value="" />
                                    <input type="hidden" class="hidden_lotform" name="hidden_lotform[]" value="" /> 
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <select id="locto" class="form-control" name="locto[]">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <input type="number" id="qtytotransfer" class="form-control" name="qtytotransfer[]" min="0" step="0.01" />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="color: red; text-align: center;" >No Data Available</td>
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

        <div class="modal-footer">
            <a class="btn btn-danger" href="/whsconfirm" id="btnback">Back</a>
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

        $(document).on('click', '.loclotfrom', function() { 
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_spcode").val();
            const getassetsite = document.getElementById('hidden_assetsite').value;

            // console.log(spcode);

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
                            const lot = record.t_site;
                            row.find(".hidden_siteform").val(site);
                            row.find(".hidden_locform").val(loc);
                            row.find(".hidden_lotform").val(lot);

                            row.find(".loclotform").val();
                            // console.log("Record selected:", record.t_loc);
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



        const checkboxes = document.querySelectorAll('.qaddel');
        const submitButton = document.querySelector('#btnconf');

        function checkButton() {
            let checked = false;
            for (const checkbox of checkboxes) {
            if (checkbox.checked) {
                checked = true;
                break;
            }
            }

            if (checked) {
            submitButton.removeAttribute('disabled');
            } else {
            submitButton.setAttribute('disabled', 'disabled');
            }
        }

        for (const checkbox of checkboxes) {
            checkbox.addEventListener('click', checkButton);
        }

        $("table.order-list").on("click", ".ibtnDel", function(event) {
            var row = $(this).closest("tr");
            var line = row.find(".line").val();

            if (line == counter - 1) {
                // kalo line terakhir delete kurangin counter
                counter -= 1
            }

            $(this).closest("tr").remove();
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

        /* 
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
              
        }); */

        /* $(".t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        }); */

        $(".t_site").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $(".t_lot").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $(document).on('change', '.t_loc', function() {
            var qtystok = $(this).closest('tr').find('.qtystok');
            var site = $(this).closest('tr').find('.t_site').val();
            var loc = $(this).closest('tr').find('.t_loc').val();
            var part = $(this).closest('tr').find('.partneed').val();
            var dqtyreq = $(this).closest('tr').find('.dqtyreq').val();
            var qtyconf = $(this).closest('tr').find('.qtyconf');

            
        });

        $(document).on('change', '.t_lot', function() {
            var qtystok = $(this).closest('tr').find('.qtystok');
            var site = $(this).closest('tr').find('.t_site').val();
            var loc = $(this).closest('tr').find('.t_loc');
            var part = $(this).closest('tr').find('.partneed').val();
            var dqtyreq = $(this).closest('tr').find('.dqtyreq').val();
            var qtyconf = $(this).closest('tr').find('.qtyconf');

            var lot = $(this).closest('tr').find('.t_lot').val();
            var explode = lot.split(",");
            var vloc = explode[1];
            var vlot = explode[0];

            loc.val(vloc);
            console.log(vloc, part, site, vlot);
            
            
        });

        /* jika site diubah, select lot dan location diubah sesuai dengan wsa stok */
        $(document).on('change', '.t_site', function() {
            var site = $(this).closest('tr').find('.t_site').val();
            var part = $(this).closest('tr').find('.partneed').val();
            var lot = $(this).closest('tr').find('.t_lot');

            $.ajax({
                url:"/searchlot?t_site="+site+"&t_part="+part,
                success:function(data){
                    console.log(data);
                    lot.html('').append(data);
                    lot.val(data);
                }
            }) 
        });

        $(document).on('change','.qaddel',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox
    
            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.tick').val(1);
            } else
            {
                $(this).closest("tr").find('.tick').val(0);
            }        
        });
    });
</script>
@endsection