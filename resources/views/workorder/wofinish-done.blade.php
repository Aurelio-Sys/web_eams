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
    <form class="form-horizontal" id="newedit" method="post" action="/reportingwo">
        {{ csrf_field() }}
        <div class="modal-body">
            <input type="hidden" name="repairtype" id="repairtype">
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

                <!-- <div class="form-group row col-md-12 ">
                    <label for="repaircode" class="col-md-4 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6" style="vertical-align:middle;">
                        <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group" {{($data->first()->wo_repair_type == "group") ? "checked" : ""}}>
                        <label class="form-check-label" for="argcheck">
                            Repair Group
                        </label>

                        <input class="d-inline ml-5" type="radio" name="repairtype" id="arccheck" value="code" {{($data->first()->wo_repair_type == "code") ? "checked" : ""}}>
                        <label class="form-check-label" for="arccheck">
                            Repair Code
                        </label>
                    </div>
                </div> -->

                @if($data->first()->wo_repair_type == "group")
                <!-- jika pilih group -->
                <div class="col-md-12 p-0" id="divgroup">
                    <div class="form-group row col-md-12 divrepgroup">
                        <label for="repairgroup" class="col-md-4 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="inputgroup1">
                            <select id="repairgroup" type="text" class="form-control repairgroup" name="repairgroup[]" autofocus>
                                <option value="" selected disabled>--Select Repair Group--</option>
                                @foreach($repairgroup as $rp)
                                <option value="{{$rp->xxrepgroup_nbr}}">{{$rp->xxrepgroup_nbr}} -- {{$rp->xxrepgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="testdivgroup">

                    </div>
                </div>
                <!-- group -->
                @endif


                <!-- jika pilih manual -->
                <!-- <div class="col-md-12 p-0" id="divmanual" style="display: none;">
                    <div class="form-group row col-md-12 divrepgroup">
                        <label for="manualcount" class="col-md-4 col-form-label text-md-left">Number of part repaired <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="inputgroup1">
                            <select id="manualcount" type="text" class="form-control repairgroup" name="manualcount" autofocus>
                                <option value="" selected disabled>--Number of part repaired--</option>
                                @for($co = 1; $co<=50; $co++) <option value="{{$co}}">{{$co}}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div id="testmanual">

                    </div>
                </div> -->
                <!-- manual -->

                @if ($data->first()->wo_repair_type == "code")
                <!-- jika pilih repair code -->
                <!-- repair code 1 -->
                <div class="col-md-12 p-0" id="divrepair">
                    @if($data->first()->rr11 != null)
                    <!-- <div class="form-group row col-md-12 divrepcode">
                        <label for="repaircode1" class="col-md-4 col-form-label text-md-left">Repair Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" id="inputrepair1">
                            <select id="repaircode1" type="text" class="form-control repaircode1" name="repaircode1[]" autofocus>
                                <option value="" selected disabled>--Select Repair Code--</option>
                                @foreach ($repaircode as $repaircode2)
                                <option value="{{$repaircode2->repm_code}}" {{$repaircode2->repm_code == $data->first()->rr11 ? "selected" : ""}}>{{$repaircode2->repm_code}} -- {{$repaircode2->repm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div id="testdiv">
                        <div class="form-group row col-md-12 divrepcode">
                            <label class="col-md-12 col-form-label text-md-left">Repair code : {{$data->first()->rr11}} -- {{$data->first()->r11}} </label>
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
                                    @foreach ( $datadetail as $insdet )
                                    @if ($insdet->wo_dets_rc == $data->first()->rr11)
                                    <tr>
                                        <td style="margin-top:0;height:40px;border:2px solid">
                                            {{$i++}}
                                        </td>
                                        <td style="margin-top:0;height:40px;border:2px solid">
                                            {{$insdet->ins_desc}}
                                        </td>
                                        <td style="margin-top:0;height:40px;border:2px solid">
                                            {{$insdet->ins_check}}
                                        </td>
                                        <fieldset id="do">
                                            <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                                <input type="radio" value="y" name="do{{$i}}">
                                            </td>
                                            <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                                <input type="radio" value="n" name="do{{$i}}">
                                            </td>
                                        </fieldset>
                                        <fieldset id="result">
                                            <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                                <input type="radio" value="y" name="result{{$i}}">
                                            </td>
                                            <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                                <input type="radio" value="n" name="result{{$i}}">
                                            </td>
                                        </fieldset>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid">
                                            <textarea name="note1[]" id="note[]" style="border:0;width:100%"></textarea>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

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
                                        <th style="border:2px solid;width:20%">
                                            <p style="height:100%">Description</p>
                                        </th>
                                        <th style="border:2px solid;width:15%">
                                            <p style="height:100%">UM</p>
                                        </th>
                                        <th style="border:2px solid;width:10%">
                                            <p style="height:100%">Qty Required</p>
                                        </th>
                                        <th style="border:2px solid; width: 10%;">
                                            <p style="height:100%">Qty Used</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ( $detailsp as $spdet )
                                    <tr>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$i++}}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->wo_dets_ins}}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->wo_dets_sp}}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->spm_desc}}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{($spdet->insd_um != null) ? $spdet->insd_um : $spdet->spm_um }}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{($spdet->insd_qty != null) ? $spdet->insd_qty : $spdet->wo_dets_sp_qty}}
                                        </td>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                            <input type="number" step="1" min="0" class="form-control" style="width: 100%;" value="{{$spdet->wo_dets_sp_qty}}">
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- repair code 2 -->
                    @if ($data->first()->rr22 != null)
                    <!-- <div class="form-group row col-md-12 divrepcode">
                        <label for="repaircode2" class="col-md-4 col-form-label text-md-left">Repair Code 2</label>
                        <div class="col-md-6">
                            <input type="hidden" id="inputrepair2">
                            <select id="repaircode2" type="text" class="form-control repaircode2" name="repaircode2[]" autofocus>
                                <option value="" selected disabled>--Select Repair Code--</option>
                                @foreach ($repaircode as $repaircode3)
                                <option value="{{$repaircode3->repm_code}}" {{($repaircode3->repm_code == $data->first()->rr22) ? "selected" : ""}}>{{$repaircode3->repm_code}} -- {{$repaircode3->repm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div id="testdiv2">
                        <div class="form-group row col-md-12 divrepcode">
                            <label class="col-md-12 col-form-label text-md-left">Repair code : {{$data->first()->rr22}} -- {{$data->first()->r22}} </label>
                            <label class="col-md-5 col-form-label text-md-left">Instruction :</label>
                        </div>
                        <div class="table-responsive col-12">
                            <table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
                                <thead>
                                    <tr style="text-align: center;style=" border:2px solid"">
                                        <th rowspan="2" style="border:2px solid;width:5%">
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
                        </div>
                    </div>
                    @endif

                    <!-- repair code 3 -->
                    @if ($data->first()->rr33 != null)
                    <!-- <div class="form-group row col-md-12 divrepcode">
                        <label for="repaircode3" class="col-md-4 col-form-label text-md-left">Repair Code 3</label>
                        <div class="col-md-6">
                            <input type="hidden" id="inputrepair3">
                            <select id="repaircode3" type="text" class="form-control repaircode3" name="repaircode3[]" autofocus>
                                <option value="" selected disabled>--Select Repair Code--</option>
                                @foreach ($repaircode as $repaircode4)
                                <option value="{{$repaircode4->repm_code}}" {{($repaircode4->repm_code == $data->first()->rr33) ? "selected" : ""}} >{{$repaircode4->repm_code}} -- {{$repaircode4->repm_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div id="testdiv3">
                        <div class="form-group row col-md-12 divrepcode">
                            <label class="col-md-12 col-form-label text-md-left">Repair code : {{$data->first()->rr33}} -- {{$data->first()->r33}} </label>
                            <label class="col-md-5 col-form-label text-md-left">Instruction :</label>
                        </div>
                        <div class="table-responsive col-12">
                            <table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
                                <thead>
                                    <tr style="text-align: center;style=" border:2px solid"">
                                        <th rowspan="2" style="border:2px solid;width:5%">
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
                        </div>
                    </div>
                    @endif
                </div>
                @endif
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
                <div class="col-md-6">
                    <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
                </div>
            </div>
            <div class="form-group row col-md-12">
                <label for="c_finishtime" class="col-md-4 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6">
                    <select id="c_finishtime" class="form-select c_finishtime" name="c_finishtime" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                    </select>
                    :
                    <select id="c_finishtimeminute" class="form-select c_finishtime" name="c_finishtimeminute" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
                        <option value='00'>00</option>
                        <option value='01'>01</option>
                        <option value='02'>02</option>
                        <option value='03'>03</option>
                        <option value='04'>04</option>
                        <option value='05'>05</option>
                        <option value='06'>06</option>
                        <option value='07'>07</option>
                        <option value='08'>08</option>
                        <option value='09'>09</option>
                        @for ($i = 10; $i < 60; $i++) <option value='{{$i}}'>{{$i}}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="form-group row col-md-12">
                <label for="c_note" class="col-md-4 col-form-label text-md-left">Reporting Note <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6">
                    <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
                </div>
            </div>
            <div class="form-group row justify-content-center">
                <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
                <label class="col-md-12 col-form-label text-md-left">Photo Upload : </label>
            </div>
            <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
                <div class="col-md-12 images">
                    <div class="pic">
                        add
                    </div>
                </div>
            </div>
            <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
            <input type="hidden" id="repairtypenow" name="repairpartnow" />
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        console.log("ready!");

        // if (document.getElementById('argcheck').checked) {
        //     $('#argcheck').change();
        // }

        // if (document.getElementById('arccheck').checked) {
        //     $('#arccheck').change();
        // }



        uploadImage();

        $('#file-input').on('change', function() { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {

                var data = $(this)[0].files; //this file data
                // console.log(data);
                $.each(data, function(index, file) { //loop though each file
                    if (/(\.|\/)(jpe?g|png)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file) { //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                                $('#thumb-output').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

                $("#thumb-output").on('click', '.thumb', function() {
                    $(this).remove();
                })

            } else {
                // alert("Your browser doesn't support File API!");
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: "Your browser doesn't support File API!",
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000,
                }) //if File API is absent
            }
        });

    });

    function uploadImage() {
        var button = $('.images .pic')
        var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
        var images = $('.images')
        var potoArr = [];
        var initest = $('.images .img span #imgname')

        button.on('click', function() {
            // alert('aaa');
            uploader.click();
        })

        uploader.on('change', function() {
            var reader = new FileReader();
            i = 0;
            reader.onload = function(event) {
                images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="' + event.target.result + '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
                // alert(JSON.stringify(uploader));
                document.getElementById('imgname').value = uploader[0].files.item(0).name + ',' + event.target.result;
                document.getElementById('hidden_var').value = 1;
            }
            reader.readAsDataURL(uploader[0].files[0])
            // potoArr.push(uploader[0].files[0]);

            // console.log(potoArr);
        })


        images.on('click', '.img', function() {
            $(this).remove();
        })

        // confirmPhoto(potoArr);
    }

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

    // $(document).on('change', '#arccheck', function(e) {
    //     // alert('aaa');
    //     document.getElementById('divrepair').style.display = '';
    //     document.getElementById('divgroup').style.display = 'none';
    //     // alert('aaa');
    //     $("#repairgroup").val(null).trigger('change');
    //     //$("#repaircode1").val(null).trigger('change');
    //     $("#repaircode2").val(null).trigger('change');
    //     $("#repaircode3").val(null).trigger('change');

    //     document.getElementById('repairtype').value = 'code';
    // });

    // $(document).on('change', '#argcheck', function(e) {
    //     document.getElementById('divgroup').style.display = '';
    //     document.getElementById('divrepair').style.display = 'none';
    //     $("#repairgroup").val(null).trigger('change');
    //     //$("#repaircode1").val(null).trigger('change');
    //     $("#repaircode2").val(null).trigger('change');
    //     $("#repaircode3").val(null).trigger('change');
    //     document.getElementById('repairtype').value = 'group';
    // });
</script>
@endsection