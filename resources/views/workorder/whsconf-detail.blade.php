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
                <div class="col-md-12">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Repair Code</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Instruction Code</td>
                                <td style="text-align: center; width: 20% !important; font-weight: bold;">Spare Part</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Required</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Request</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Site</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Location</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Stock</td>
                                <td style="text-align: center; width: 10% !important; font-weight: bold;">Qty Confirm</td>
                                <td style="text-align: center; width: 5% !important; font-weight: bold;">Confirm</td>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>

                            @forelse ( $combineSP as $datas )
                                <!-- qty required -->
                                @if($datas->insd_part == "")
                                    @php($cqty = 0)
                                @else
                                    @php($cqty = $datas->insd_qty)
                                @endif

                                <!-- qty request -->
                                @php($qqtyreq = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->count())
                                @if($qqtyreq == 0)
                                    @php($dqtyreq = 0)
                                @else
                                    @php($sqtyreq = $wodetdata->where('wo_dets_nbr','=',$data->wo_nbr)->where('wo_dets_rc','=',$datas->repair_code)->where('wo_dets_ins','=',$datas->ins_code)->where('wo_dets_sp','=',$datas->insd_part)->first())
                                    @php($dqtyreq = $sqtyreq->wo_dets_sp_qty)
                                @endif

                                <!-- default lokasi -->
                                @php($qsite = $spdata->where('spm_code','=',$datas->insd_part)->count())
                                @if($qsite == 0)
                                    @php($dsite = "")
                                    @php($dloc = "")
                                @else
                                    @php($ssite = $spdata->where('spm_code','=',$datas->insd_part)->first())
                                    @php($dsite = $ssite->spm_site)
                                    @php($dloc = $ssite->spm_loc)
                                @endif

                                <!-- stok -->
                                @php($cstok = $qstok->where('stok_site','=',$dsite)->where('stok_loc','=',$dloc)->where('stok_part','=',$datas->insd_part)->count())
                                @if($cstok == 0)
                                    @php($dstok = 0)
                                @else
                                    @php($rsstok = $qstok->where('stok_site','=',$dsite)->where('stok_loc','=',$dloc)->where('stok_part','=',$datas->insd_part)->first())
                                    @php($dstok = $rsstok->stok_qty)
                                @endif

                                <!-- Qty Confirm -->
                                @if($dqtyreq > $dstok)
                                    @php($dconf = $dstok)
                                @else
                                    @php($dconf = $dqtyreq)
                                @endif

                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->repair_code}}
                                    <input type="hidden" name="repcode[]" value="{{$datas->repair_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->ins_code}}
                                    <input type="hidden" name="inscode[]" value="{{$datas->ins_code}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->insd_part}} -- {{$datas->insd_part_desc}}
                                    <input type="hidden" name="partneed[]" value="{{$datas->insd_part}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{ $cqty }}
                                    <input type="hidden" name="qtyreq[]" value="{{$cqty}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{ $dqtyreq }}
                                    <input type="hidden" name="qtyrequest[]" value="{{ $dqtyreq }}" />
                                </td>
                                <td>
                                    <select name="t_site[]" class="form-control t_site">
                                        <option value="">-- Select --</option>
                                    @foreach($sitedata as $rssite)
                                        <option value="{{ $rssite->site_code }}" {{$dsite == $rssite->site_code ? "selected" : ""}}>{{ $rssite->site_code }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="t_loc[]" class="form-control t_loc">
                                        <option value="">-- Select --</option>
                                    @php($rsloc = $locdata->where('loc_site','=',$dsite))
                                    @foreach($rsloc as $rsloc)
                                        <option value="{{ $rsloc->loc_code }}" {{$dloc == $rsloc->loc_code ? "selected" : ""}}>{{ $rsloc->loc_code }} -- {{ $rsloc->loc_desc }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{$dstok}}
                                    <input type="hidden" name="qtystok[]" value="{{$dstok}}" class="qtystok"/>
                                </td>
                                <td>
                                    <input type="number" class="form-control qtyconf" step="1" min="0" name="qtyconf[]" value="{{$dconf}}" required />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <!-- <input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"> -->
                                    
                                    <input type="checkbox" class="qaddel" name="qaddel[]" value="">
                                    <input type="hidden" class="tick" name="tick[]" value="0" />
                                    
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
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Confirm</button>
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
        });

        $(".t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $(".t_site").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $(document).on('change', '.t_loc', function() {
            var qtystok = $(this).closest('tr').find('.qtystok');
            var loc = $(this).val();
            var site = $(this).closest('tr').find('.t_site').val();
            var part = $(this).closest('tr').find('.partneed').val();
            //var dsite = $(ssite).val()

                $.ajax({
                  url:"/cekstok?site="+site+",loc="+loc+",part="+part,
                  success:function(data){
                      console.log(data);
                      /* loc.html('').append(data);
                      loc.val(data); */
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