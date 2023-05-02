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

        <input type="hidden" name="hide_wonum" value="{{$data->wo_nbr}}" />

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
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->repair_code}}
                                    <input type="hidden" name="repcode[]" value="{{$datas->repair_code}}" />
                                    <input type="hidden" name="line[]" value="{{$datas->wo_dets_line}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->ins_code}}
                                    <input type="hidden" name="inscode[]" value="{{$datas->ins_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->insd_part}} -- {{$descpart}}
                                    <input type="hidden" class="partneed" name="partneed[]" value="{{$datas->insd_part}}" />
                                    <input type="hidden" class="partdesc" name="partdesc[]" value="{{$descpart}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{ number_format($cqty ?? $dqtyreq,2) }}
                                    <input type="hidden" name="qtyreq[]" value="{{$cqty}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{ number_format($dqtyreq,2) }}
                                    <input type="hidden" name="qtyrequest[]" value="{{ $dqtyreq }}" class="dqtyreq" />
                                </td>
                                
                                <td style="vertical-align: middle; text-align: center;">
                                    <select name="t_site[]" class="form-control t_site">
                                        <option value="">-- Select --</option>
                                    @foreach($sitedata as $rssite)
                                        <option value="{{ $rssite->site_code }}" {{$dsite == $rssite->site_code ? "selected" : ""}}>{{ $rssite->site_code }}</option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @empty

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
@endsection

@section('scripts')
<script type="text/javascript">
    var counter = 1;

    function selectPicker() {
        $('.selectpicker').selectpicker().focus();
    }

    $(document).ready(function() {

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
            
            @foreach ($qstok as $qstok)
            if(part == "{{$qstok->stok_part}}" && site == "{{$qstok->stok_site}}" && vloc == "{{$qstok->stok_loc}}" && vlot == "{{$qstok->stok_lot}}") {
                
                qtystok.html({{$qstok->stok_qty}});
                
                 /*if(dqtyreq > {{$qstok->stok_qty}}) {
                    {{--  $(this).closest('tr').find('.qtyconf').val({{$qstok->stok_qty}});  --}}
                    qtyconf.val({{$qstok->stok_qty}});
                } else {
                    qtyconf.val(dqtyreq);
                } */
            }
            @endforeach
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