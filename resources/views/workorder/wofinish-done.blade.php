@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Finish Detail</h1>
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
            <input type="hidden" name="repairtype" id="repairtype" value="{{$data->first()->wo_repair_type}}">
            <input type="hidden" id="v_counter">
            <input type="hidden" name="statuswo" id="statuswo">
            <div class="form-group row col-md-12">
                <div class="col-md-3 h-50">
                    <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
                </div>
                <div class="col-md-6 h-50">
                    <label for="c_asset" class="col-md-12 col-form-label text-md-left p-0">Asset</label>
                </div>
                <div class="col-md-3">
                    <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" value="{{$data->first()->wo_nbr}}" autofocus readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" value="{{$data->first()->wo_sr_nbr}}" autofocus readonly>
                </div>
                <div class="col-md-6">
                    <input id="c_asset" type="text" class="form-control pl-0 col-md-12 c_asset" style="background:transparent;border:none;text-align:left" name="c_asset" value="{{$data->first()->asset_desc}}" autofocus readonly>
                    <input id="c_assethid" type="hidden" class="form-control c_asset" name="c_assethidden">
                </div>

            </div>

            <div id="divrepairtype">
                <div id="testdiv">
                    @php
                        $inc = 0;
                    @endphp
                    @foreach ( $data_alldets as $alldetail )
                    <div class="form-group row col-md-12 divrepcode">
                        <label class="col-md-12 col-form-label text-md-left" style="color: blue; font-weight: bold;">Repair code : {{$alldetail->wo_dets_rc}} -- {{$alldetail->repm_desc}} </label>
                        <label class="col-md-5 col-form-label text-md-left">Instruction :</label>
                    </div>
                    <div class="table-responsive col-12">
                        <table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">
                            <thead>
                                <tr style="text-align: center;border:2px solid">
                                    <th rowspan="2" style="border:2px solid;width:5%;">
                                        <p style="height:100%">No</p>
                                    </th>
                                    <th rowspan="2" style="border:2px solid;width:25%">
                                        <p style="height:100%">Instruksi</p>
                                    </th>
                                    <th rowspan="2" style="border:2px solid;width:20%">
                                        <p style="height:100%">Standard</p>
                                    </th>
                                    <th colspan="2" style="border:2px solid;width:15%">
                                        <p style="height:50%">Do</p>
                                    </th>
                                    <th colspan="2" style="border:2px solid;width:15%">
                                        <p style="height:50%">Result</p>
                                    </th>
                                    <th rowspan="2" style="border:2px solid;width:20%">
                                        <p style="height:100%">Note</p>
                                    </th>
                                </tr>
                                <tr style="text-align: center;">
                                    <th style="border:2px solid; width:10%;">Done</th>
                                    <th style="border:2px solid; width:10%;">Not Done</th>
                                    <th style="border:2px solid; width:10%;">OK</th>
                                    <th style="border:2px solid; width:10%;">Not OK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @forelse ( $datadetail as $insdet )
                                @if ($insdet->wo_dets_rc == $alldetail->wo_dets_rc)
                                <tr>

                                    <td style="margin-top:0;height:40px;border:2px solid">
                                        {{$i++}}
                                    </td>
                                    <input type="hidden" name="wonbr_hidden1[]" value="{{$alldetail->wo_dets_nbr}}" />
                                    <input type="hidden" name="rc_hidden1[]" value="{{$alldetail->wo_dets_rc}}" />
                                    <td style="margin-top:0;height:40px;border:2px solid">
                                        {{$insdet->ins_desc}}
                                        <input type="hidden" name="inscode_hidden1[]" value="{{$insdet->ins_code}}" />
                                    </td>
                                    <td style="margin-top:0;height:40px;border:2px solid">
                                        {{$insdet->ins_check}}
                                    </td>
                                    <fieldset id="do">
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                            <input type="radio" value="y" name="do[0][{{$inc}}]" {{$alldetail->wo_dets_do_flag == 'y' ? 'checked':''}} required>
                                        </td>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                            <input type="radio" value="n" name="do[0][{{$inc}}]" {{$alldetail->wo_dets_do_flag == 'n' ? 'checked':''}}>
                                        </td>
                                    </fieldset>
                                    <fieldset id="result">
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                            <input type="radio" value="y" name="result[0][{{$inc}}]" {{$alldetail->wo_dets_flag == 'y' ? 'checked':''}} required>
                                        </td>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                            <input type="radio" value="n" name="result[0][{{$inc}}]" {{$alldetail->wo_dets_flag == 'n' ? 'checked':''}}>
                                        </td>
                                    </fieldset>
                                    <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                        <textarea name="note[]" id="note[]" style="border:0;width:100%"></textarea>
                                    </td>
                                </tr>

                                @php
                                $inc++;
                                @endphp


                                @endif
                                @empty
                                <tr>
                                    <td colspan="12" style="color: red; text-align: center;">
                                        No Data Available
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row col-md-12">
                        <label class="col-md-5 col-form-label text-md-left">Spare Part :</label>
                    </div>
                    <div class="table-responsive col-12">
                        <table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">
                            <thead>
                                <tr style="text-align: center;border:2px solid">
                                    <th style="border:2px solid;width:5%;">
                                        <p style="height:100%">No</p>
                                    </th>
                                    <th style="border:2px solid;width:10%">
                                        <p style="height:100%">Inst. Code</p>
                                    </th>
                                    <th style="border:2px solid;width:10%">
                                        <p style="height:100%">Spare Part</p>
                                    </th>
                                    <th style="border:2px solid;width:30%">
                                        <p style="height:100%">Description</p>
                                    </th>
                                    <th style="border:2px solid;width:5%">
                                        <p style="height:100%">UM</p>
                                    </th>
                                    <th style="border:2px solid;width:10%">
                                        <p style="height:100%">Qty Required</p>
                                    </th>
                                    <th style="border:2px solid; width: 10%;">
                                        <p style="height:100%">Qty Used</p>
                                    </th>
                                    <th style="border:2px solid; width: 10%;">
                                        <p style="height:100%">Qty Confirmed</p>
                                    </th>
                                    <th style="border:2px solid; width: 10%;">
                                        <p style="height:100%">Qty Already Issued</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @forelse ( $detailsp as $spdet )
                                @if($spdet->wo_dets_rc == $alldetail->wo_dets_rc)
                                <tr>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{$i++}}
                                        <input type="hidden" name="wonbr_hidden2[]" value="{{$spdet->wo_dets_nbr}}" />
                                        <input type="hidden" name="rc_hidden2[]" value="{{$spdet->wo_dets_rc}}" />
                                    </td>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{$spdet->wo_dets_ins}}
                                        <input type="hidden" name="inscode_hidden2[]" value="{{$spdet->wo_dets_ins}}" />
                                        <input type="hidden" name="spsite_hidden2[]" value="{{$spdet->spm_site}}" />
                                    </td>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{$spdet->wo_dets_sp}}
                                        <input type="hidden" name="spcode_hidden2[]" value="{{$spdet->wo_dets_sp}}" />
                                    </td>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{$spdet->spm_desc}}
                                    </td>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{($spdet->insd_um != null) ? $spdet->insd_um : $spdet->spm_um }}
                                    </td>
                                    <td style="margin-top:0;min-height:50px;border:2px solid">
                                        {{($spdet->insd_qty != null) ? $spdet->insd_qty : $spdet->wo_dets_wh_qty}}
                                    </td>
                                    <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                        <input type="number" step="1" min="0" max="{{($spdet->wo_dets_qty_used != null) ? ($spdet->wo_dets_wh_qty - $spdet->wo_dets_qty_used) : (($spdet->wo_dets_wh_qty != null) ? $spdet->wo_dets_wh_qty : '0')}}" class="form-control" name="qtyused[]" style="width: 100%;" value="{{($spdet->wo_dets_qty_used != null) ? ($spdet->wo_dets_wh_qty - $spdet->wo_dets_qty_used) : (($spdet->wo_dets_wh_qty != null) ? $spdet->wo_dets_wh_qty : '0')}}">
                                    </td>
                                    <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                        {{($spdet->wo_dets_wh_qty != null) ? $spdet->wo_dets_wh_qty : '0' }}
                                    </td>
                                    <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                        {{($spdet->wo_dets_qty_used != null) ? $spdet->wo_dets_qty_used : '0' }}
                                        <input type="hidden" name="qtyalreadyused[]" value"{{($spdet->wo_dets_qty_used != null) ? $spdet->wo_dets_qty_used : '0'}}"/>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="12" style="color: red; text-align: center;">
                                        No Data Available
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    @endforeach
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
                <!-- <div class="form-group row col-md-12 c_lastmeasurement">
              <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Last Measurement</label>
              <div class="col-md-7">
                <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01" readonly>
              </div>
            </div>
            <div class="form-group row col-md-12 c_engineerdiv">
              <label for="c_lastmeasurementdate" class="col-md-5 col-form-label text-md-left">Last Maintenance</label>
              <div class="col-md-7">
                <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate"  readonly>
              </div>
            </div> -->
            </div>


            <div class="form-group row col-md-12">
                <label for="c_finishdate" class="col-md-4 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-3">
                    <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" value="{{($data->first()->wo_finish_date != null) ? $data->first()->wo_finish_date : \Carbon\Carbon::now()->format('Y-m-d')}}" autofocus required>
                </div>
            </div>
            <div class="form-group row col-md-12">
                <label for="c_finishtime" class="col-md-4 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-3">
                    <input type="time" class="form-control" name="c_finishtime" value="{{($data->first()->wo_finish_time != null) ? $data->first()->wo_finish_time : \Carbon\Carbon::now()->format('H:i')}}" autofocus required/>
                </div>
            </div>

            <div class="form-group row col-md-12">
                <label for="failurecode" class="col-md-4 col-form-label my-auto">Failure Code</label>
                <div class="col-md-5 col-sm-12">
                    
                    <select class="form-control" id="failurecode" name="failurecode[]" multiple="multiple">
                        <option></option>
                        @foreach($fc as $fcshow)
                        <option value="{{$fcshow->fn_code}}"
                        @if(old('failurecode') ? in_array($fcshow->fn_code, old('failurecode')) : in_array($fcshow->fn_code, [$data->first()->wofc1, $data->first()->wofc2, $data->first()->wofc3]))
                        selected
                        @endif
                        >{{$fcshow->fn_code}} -- {{$fcshow->fn_desc}} -- {{$fcshow->fn_impact}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group row col-md-12">
                <label for="c_note" class="col-md-4 col-form-label text-md-left">Reporting Note <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6">
                    <textarea id="c_note" class="form-control c_note" name="c_note" maxlength="250" autofocus>{{($data->first()->wo_approval_note != null) ? $data->first()->wo_approval_note : ''}}</textarea>
                </div>
            </div>
            <div class="form-group row col-md-12" id="photodiv">
                <label class="col-md-4 col-form-label text-md-left">Uploaded File</label>
                <div class="col-md-7">
                <div id="munculgambar">

                </div>
                </div>
            </div>
            <div class="form-group row col-md-12">
                <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
                <label class="col-md-4 col-form-label text-md-left">Upload</label>
                <div class="col-md-5 input-file-container" style="margin-bottom: 10%;">
                    <input type="file" class="form-control" id="filenamewo" name="filenamewo[]" multiple>
                </div>
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

        $.ajax({
          url: "/imageview",
          data: {
            wonumber: wonbr,
          },
          success: function(data) {
            // console.log(data);

            /* coding asli ada di backup-20211026 sblm PM attach file, coding aslinya nampilin gambar*/
            //alert('test');

            $('#munculgambar').html('').append(data);
          }
        })


    
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