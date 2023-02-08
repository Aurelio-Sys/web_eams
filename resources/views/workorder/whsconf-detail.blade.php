@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Warehouse Confirm Detail</h1>
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
                                <td style="text-align: center; width: 7% !important; font-weight: bold;">Repair Code</td>
                                <td style="text-align: center; width: 7% !important; font-weight: bold;">Instruction Code</td>
                                <td style="text-align: center; width: 20% !important; font-weight: bold;">Spare Part</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Qty Request</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Site</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Lot</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Loc From</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Loc To</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Stock</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Qty Confirm</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Qty To Confirm</td>
                                <td style="text-align: center; width: 19% !important; font-weight: bold;">Release Note</td>
                                <td style="text-align: center; width: 8% !important; font-weight: bold;">Confirm</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>

                            @forelse ( $combineSP as $datas )
                                <!-- qty required -->
                                @if($datas->insd_part == "")
                                    @php($cqty = 0)
                                    @php($ccek = 0)
                                @else
                                    @php($cqty = $datas->insd_qty)
                                    @php($ccek = 1)
                                @endif

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

                                <!-- qty request -->
                                @php($qqtyreq = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->count())
                                @if($qqtyreq == 0)
                                    @php($dqtyreq = 0)
                                    @php($whsconf = "")
                                    @php($whsdate = "")
                                    @php($note_release = "")
                                    @php($dqtymove = 0)
                                @else
                                    @php($sqtyreq = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->first())
                                    @php($dqtyreq = $sqtyreq->wo_dets_sp_qty)
                                    @php($whsconf = $sqtyreq->wo_dets_wh_conf)
                                    @php($whsdate = $sqtyreq->wo_dets_wh_date)
                                    @php($note_release = $sqtyreq->wo_dets_worelease_note)
                                    @php($dqtymove = $sqtyreq->wo_dets_wh_qty)
                                @endif

                                <!-- default lokasi -->
                                <!-- @php($qsite = $spdata->where('spm_code','=',$datas->insd_part)->count())
                                @if($qsite == 0)
                                    @php($dsite = "")
                                    @php($dloc = "")
                                @else
                                    @php($ssite = $spdata->where('spm_code','=',$datas->insd_part)->first())
                                    @php($dsite = $ssite->spm_site)
                                    @php($dloc = $ssite->spm_loc)
                                @endif
                                -->

                                <!-- stok -->
                                @php($cstok = $qstok->where('stok_site','=',$dsite)->where('stok_part','=',$datas->insd_part)->count())
                                @if($cstok == 0)
                                    @php($dstok = 0)
                                    @php($dsite = "")
                                    @php($dloc = "")
                                    @php($dlot = "")
                                @else
                                    @php($rsstok = $qstok->where('stok_site','=',$dsite)->where('stok_part','=',$datas->insd_part)->first())
                                    @php($dstok = $rsstok->stok_qty)
                                    @php($dsite = $rsstok->stok_site)
                                    @php($dloc = $rsstok->stok_loc)
                                    @php($dlot = $rsstok->stok_lot)
                                @endif

                                <!-- Qty Confirm -->
                                @if($whsconf == 0)
                                    @if($dqtyreq > $dstok)
                                        @php($dconf = $dstok)
                                    @else
                                        @php($dconf = $dqtyreq - $dqtymove)
                                    @endif
                                @else
                                    @php($dconf = 0)
                                @endif

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
                                <td style="vertical-align: middle; text-align: center;">
                                    @php($qlot = $qstok->where('stok_part','=',$datas->insd_part)
                                                    ->where('stok_site','=',$dsite))
                                    <select name="t_lot[]" class="form-control t_lot">
                                        <option value="">-- Select --</option>
                                    @foreach($qlot as $rslot)
                                        @if($dlot == $rslot->stok_lot && $dloc == $rslot->stok_loc)
                                            <option value="{{ $rslot->stok_lot }},{{ $rslot->stok_loc }}" selected>{{ $rslot->stok_lot }} -- Loc : {{ $rslot->stok_loc }}</option>
                                        @else
                                            <option value="{{ $rslot->stok_lot }},{{ $rslot->stok_loc }}" >{{ $rslot->stok_lot }} -- Loc : {{ $rslot->stok_loc }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>

                                <td style="vertical-align: middle; text-align: center;">
                                    <input type="input" name="t_loc[]" class="form-control t_loc" value="{{$dloc}}" readonly>
                                    <!-- perubahan stok berdasarkan lot
                                        <select name="t_loc[]" class="form-control t_loc">
                                        <option value="">-- Select --</option>
                                    @php($rsloc = $locdata->where('loc_site','=',$dsite))
                                    @foreach($rsloc as $rsloc)
                                        <option value="{{ $rsloc->loc_code }}" {{$dloc == $rsloc->loc_code ? "selected" : ""}}>{{ $rsloc->loc_code }} -- {{ $rsloc->loc_desc }}</option>
                                    @endforeach
                                    </select> -->
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$dataloceng->eng_site}} -- {{$dataloceng->eng_loc}}
                                    <input type="hidden" name="rlssite[]" value="{{$dataloceng->eng_site}}" />
                                    <input type="hidden" name="rlsloc[]" value="{{$dataloceng->eng_loc}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <p class="qtystok" >{{ number_format($dstok,2) }}</p>
                                    <input type="hidden" name="qtystok[]" value="{{$dstok}}" class="qtystok"/>
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <p>{{ number_format($dqtymove,2) }}</p>
                                    <input type="hidden" name="qtymove[]" value="{{$dqtymove}}">
                                </td>
                                <!-- <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"> -->
                                <input type="hidden" class="forn-control" name="whsconf[]" value="{{$whsconf}}" />
                                @if($whsconf == 1)
                                    <td style="vertical-align:middle;text-align:right;">
                                        {{ number_format($dconf,2) }}
                                        <input type="hidden" class="form-control qtyconf" name="qtyconf[]" value="{{$dconf}}" />
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <textarea rows="1" class="form-control" name="note_release[]" id="note_release[]" readonly >{{ $note_release }}</textarea>
                                    </td>
                                    <td style="vertical-align:middle;text-align:center;">    
                                        {{date('Y-m-d', strtotime($whsdate))}}
                                        <input type="hidden" class="tick" name="tick[]" value="1" />
                                    </td>
                                @else
                                    @if($ccek == 0)
                                        <td>
                                            <input type="number" class="form-control qtyconf" step="1" min="0" name="qtyconf[]" value="{{$dconf}}" required />
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <textarea rows="1" class="form-control" name="note_release[]" id="note_release[]" readonly >{{ $note_release }}</textarea>
                                        </td>
                                        <td style="vertical-align:middle;text-align:center;">    
                                            <input type="checkbox" class="qaddel" name="qaddel[]" value="" checked>
                                            <input type="hidden" class="tick" name="tick[]" value="1" />
                                        </td>
                                    @else
                                        <td>
                                            <input type="number" class="form-control qtyconf" step="1" min="0" name="qtyconf[]" value="{{$dconf}}" required />
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <textarea rows="1" class="form-control" name="note_release[]" id="note_release[]" readonly >{{ $note_release }}</textarea>
                                        </td>
                                        <td style="vertical-align:middle;text-align:center;">
                                            <input type="checkbox" class="qaddel" name="qaddel[]" value="">
                                            <input type="hidden" class="tick" name="tick[]" value="0" />
                                        </td>
                                    @endif
                                @endif
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