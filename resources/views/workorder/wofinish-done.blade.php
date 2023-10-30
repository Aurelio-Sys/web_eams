@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Report Detail</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<style type="text/css">
    .bootstrap-select .dropdown-menu {
        width: 350px !important;
        min-width: 350px !important;
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

    input::placeholder {
        font-weight: bold;
    }
</style>
<div class="row">
    <form class="form-horizontal" id="newedit" method="post" action="/reportingwo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <input type="hidden" name="repairtype" id="repairtype" value="">
            <input type="hidden" id="v_counter">
            <input type="hidden" name="statuswo" id="statuswo">
            <div class="form-group row col-md-12">
                <div class="col-md-3 h-50">
                    <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_assetcode" class="col-md-12 col-form-label text-md-left p-0">Asset Code</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_assetdesc" class="col-md-12 col-form-label text-md-left p-0">Asset Desc</label>
                </div>
                <div class="col-md-3">
                    <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" value="{{$header->wo_number}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" value="{{$header->wo_sr_number}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetcode" type="text" class="form-control pl-0 col-md-12 c_assetcode" style="background:transparent;border:none;text-align:left" name="c_assetcode" value="{{$header->asset_code}}" readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_assetdesc" type="text" class="form-control pl-0 col-md-12 c_assetdesc" style="background:transparent;border:none;text-align:left" name="c_assetdesc" value="{{$header->asset_desc}}" readonly />
                </div>
            </div>
            <div class="form-group row col-md-12">
                <div class="col-md-3 h-50">
                    <label for="c_startdate" class="col-md-12 col-form-label text-md-left p-0">Start Date WO</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_duedate" class="col-md-12 col-form-label text-md-left p-0">Due Date WO</label>
                </div>
                <div class="col-md-6 h-50">

                </div>
                <div class="col-md-3 h-50">
                    <input id="c_startdate" type="text" class="form-control pl-0 col-md-12 c_startdate" style="background:transparent;border:none;text-align:left" name="c_startdate" value="{{$header->wo_start_date}}" readonly />
                </div>
                <div class="col-md-3 h-50">
                    <input id="c_duedate" type="text" class="form-control pl-0 col-md-12 c_duedate" style="background:transparent;border:none;text-align:left" name="c_duedate" value="{{$header->wo_due_date}}" readonly />
                    <input type="hidden" id="hidden_assetsite" name="hidden_assetsite" value="{{$header->wo_site}}" />
                </div>
            </div>

            <!-- Spare Part -->

            <div style="border: 1px solid black; padding-top: 5%; padding-bottom: 5%; padding-left: 2%; padding-right: 2%;">
                <div class="table-responsive tag-container" style="overflow-x: auto; overflow-y: hidden; width: 53rem;">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0" style="width: 75rem !important; max-width: none !important;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Required</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Issued</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Issue</th>
                                <th style="text-align: center; width: 18% !important; font-weight: bold;">Location & Lot</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">GL Account</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Cost Center</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $sparepart as $datas )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                    <input type="hidden" class="hidden_sp" name="hidden_sp[]" value="{{$datas->spm_code}}" />
                                </td>
                                @php
                                $difference = number_format($datas->wd_sp_required - $datas->wd_sp_issued, 2, '.', '');
                                if ($difference < 0) { $difference=0; } @endphp <td style="vertical-align:middle;text-align:right;">
                                    {{$datas->wd_sp_required}}
                                    <input type="hidden" name="qtyrequired[]" value="{{$datas->wd_sp_required}}" />
                                    </td>
                                    <td style="vertical-align:middle;text-align:right;">
                                        {{$datas->wd_sp_issued}}
                                        <input type="hidden" class="qtyissued" name="qtyissued[]" value="{{$datas->wd_sp_issued}}" />
                                    </td>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <input type="number" class="form-control qtypotong" step="0.01" min="{{ $datas->wd_sp_issued == 0 ? 0 : -$datas->wd_sp_issued }}" max="{{$datas->wd_sp_whtf}}" name="qtypotong[]" value="{{$datas->wd_sp_whtf}}" required />
                                    </td>
                                    <td style="vertical-align: middle; text-align: left;">
                                        <input type="text" id="loclotfrom" class="form-control loclotfrom" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off" readonly placeholder="Click Here">
                                        <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                        <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                        <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />
                                    </td>
                                    <td style="vertical-align: middle; text-align: left;">
                                        <select style="display: inline-block !important;" class="form-control selectpicker glacc" name="glacc[]" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px">
                                            <option value=""> -- Select GL Account --</option>
                                            @foreach (  $glacc as $glaccount )
                                            <option value="{{$glaccount->acc_code}}" >{{$glaccount->acc_code}} -- {{$glaccount->acc_desc}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="vertical-align: middle; text-align: left;">
                                        <select style="display: inline-block !important;" class="form-control selectpicker ccenter" name="costcenter[]" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px">
                                            <option value=""> -- Select Cost Center --</option>
                                            @foreach (  $costcenter as $cc )
                                            <option value="{{$cc->cc_code}}" >{{$cc->cc_code}} -- {{$cc->cc_desc}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;text-align:center;">

                                    </td>
                            </tr>

                            @empty
                            <!--
                            <tr>
                                <td>
                                    <select style="display: inline-block !important;" class="form-control selectpicker spreq" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px">
                                        <option value=""> -- Select Spare Part -- </option>
                                        @foreach($newsparepart as $da)
                                        <option data-spsite="{{$da->spm_site}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="hidden_sp" name="hidden_sp[]" />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <input type="number" class="form-control qtypotong" min="0" step="0.01" name="qtypotong[]" value="0" required />
                                </td>
                                <td>
                                    <input type="hidden" name="qtyrequired[]" value="0" />
                                </td>
                                <td>
                                    <input type="hidden" class="qtyissued" name="qtyissued[]" value="0" />
                                </td>
                                <td>
                                    <input type="text" id="loclotfrom" class="form-control loclotfrom readonly" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off">
                                    <input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />
                                    <input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />
                                    <input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />
                                </td>
                                <td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>
                                <input type="hidden" class="op" name="op[]" value="A" />
                            </tr>

                            -->

                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add New Spare Part" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- End Spare Part -->



            <!-- Instruction WO -->

            <div style="border: 1px solid black; margin-top: 5% !important; padding-top: 5%; padding-bottom: 5%; padding-left: 2%; padding-right: 2%;">
                <div class="table-responsive tag-container" style="overflow-x: auto; overflow-y: hidden; width: 53rem;">
                    <table id="createTableIns" class="table table-bordered order-list" width="100%" cellspacing="0" style="width: 75rem !important; max-width: none !important;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 6% !important; font-weight: bold;">Step</th>
                                <th style="text-align: center; width: 25% !important; font-weight: bold;">Deskripsi</th>
                                <th style="text-align: center; width: 16% !important; font-weight: bold;">Duration</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Engineer</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Note</th>
                                <th style="text-align: center; width: 6% !important; font-weight: bold;">Do</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp_ins'>
                            @forelse ( $instruction as $index => $datains )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    <input type="number" min="0" step="1" class="form-control stepnumber" name="stepnumber[]" value="{{$datains->wd_ins_step}}" readonly />
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    {{$datains->wd_ins_stepdesc}}
                                    <input type="hidden" class="stepdesc" name="stepdesc[]" value="{{$datains->wd_ins_stepdesc}}" />
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    <div class="input-group">
                                        <input type="number" min="0" step="0.01" class="form-control ins_duration" name="ins_duration[]" value="{{$datains->wd_ins_duration != null ? $datains->wd_ins_duration : ''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"> {{$datains->um_desc}} </span>
                                            <input type="hidden" name="durationum[]" value="{{$datains->um_code}}" />
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align:middle;text-align:right; max-width: 100px !important;">
                                    <select class="form-control selectpicker ins_list_eng" name="ins_list_eng[{{$index}}][option][]" style="max-width: 100px !important;" multiple data-live-search="true" data-max-options="5" data-size="3" data-dropup-auto="false">
                                        @foreach ($engineers as $dataeng)
                                        @php
                                        $engCode = $dataeng['eng_code'];
                                        $engDesc = $dataeng['eng_desc'];
                                        $selected = in_array($engCode, explode(';', $datains->wd_ins_engineer)) ? 'selected' : '';
                                        @endphp
                                        <option value="{{$engCode}}" {{$selected}}>{{$engCode}} -- {{$engDesc}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="vertical-align:middle;text-align:right; max-width: 100px !important;">
                                    <textarea class="form-control ins_note" name="ins_note[]" rows="2" maxlength="250">{{ $datains->wd_ins_insnote }}</textarea>
                                </td>
                                <td style="vertical-align:middle;text-align:center; max-width: 100px !important;">
                                    <input type="checkbox" class="ins_check" name="ins_check[]" value="0" {{ $datains->wd_ins_do ? 'checked="checked"' : '' }}>
                                    <input type="hidden" class="ins_check_hidden" name="ins_check_hidden[]" value="{{$datains->wd_ins_do}}">
                                </td>
                                <td style="vertical-align:middle;text-align:center;">

                                </td>
                            </tr>

                            @empty



                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow_ins" value="Add New Step" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- End Instruction WO -->

            <!-- Qc Spec -->

            <div style="border: 1px solid black; margin-top: 5% !important; padding-top: 5%; padding-bottom: 5%; padding-left: 2%; padding-right: 2%;">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTableQc" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 15% !important; font-weight: bold;">QC Parameter</th>
                                <th style="text-align: center; width: 20% !important; font-weight: bold;">Result</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">UM</th>
                                <th style="text-align: center; width: 5% !important; font-weight: bold;">Action</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp_qc'>
                            @forelse ( $qcparam as $dataqc )
                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$dataqc->wd_qc_qcparam}}
                                    <input type="hidden" class="qcparam" name="qcparam[]" value="{{$dataqc->wd_qc_qcparam}}" />
                                    <input type="hidden" class="qcoperator" name="qcoperator[]" value="{{$dataqc->wd_qc_qcoperator}}" />
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <input type="{{ in_array($dataqc->wd_qc_qcoperator, ['<', '>', '=', '<=', '>=']) ? 'number' : 'text' }}" class="form-control resultqc1" name="resultqc1[]" value="{{$dataqc->wd_qc_result1 != null ? $dataqc->wd_qc_result1 : ''}}" maxlength="250" autocomplete="off" />
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <input type="text" class="form-control qcum" name="qcum[]" value="{{$dataqc->wd_qc_qcum != null ? $dataqc->wd_qc_qcum : ''}}" maxlength="250" readonly />
                                </td>
                                <td style="vertical-align:middle;text-align:center;">

                                </td>
                            </tr>

                            @empty



                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow_qc" value="Add New QC Parameter" style="background-color:#1234A5; color:white; font-size:16px" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- End Qc Spec -->

            <!-- Footer Reporting -->

            <div style="border: 1px solid black; margin-top: 5% !important; padding-top: 5%; padding-bottom: 5%; padding-left: 5%; padding-right: 5%;">
                <div class="form-group row col-md-12">
                    <label for="c_finishdate" class="col-md-4 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-3">
                        <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" value="{{($header->wo_job_finishdate != null) ? $header->wo_job_finishdate : \Carbon\Carbon::now()->format('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <label for="c_finishtime" class="col-md-4 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-3">
                        <input type="time" class="form-control" name="c_finishtime" value="{{($header->wo_job_finishtime != null) ? $header->wo_job_finishtime : \Carbon\Carbon::now()->format('H:i')}}" required />
                    </div>
                </div>

                <div class="form-group row col-md-12">
                    <label for="failurecode" class="col-md-4 col-form-label my-auto">Failure Code</label>
                    <div class="col-md-5 col-sm-12">

                        <select class="form-control" id="failurecode" name="failurecode[]" multiple="multiple">
                            <option></option>
                            @foreach ( $failure as $fc )
                            @php
                            $fncode = $fc->fn_code;
                            $fndesc = $fc->fn_desc;
                            $thisselected = in_array($fncode, explode(';', $header->wo_failure_code)) ? 'selected' : '';
                            @endphp
                            <option value="{{$fc->fn_code}}" {{$thisselected}}>{{$fc->fn_code}} -- {{$fc->fn_desc}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="form-group row col-md-12">
                    <label for="downtime" class="col-md-4 col-form-label text-md-left">Downtime <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-3">
                        <input type="number" id="downtime" min="0" class="form-control" name="downtime" value="{{$header->wo_downtime != null ? $header->wo_downtime : 0}}" required />
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="downtime_um" name="downtime_um">
                            <option value="Minute" {{$header->wo_downtime_um == 'Minute' ? 'selected' : ''}}>Minute</option>
                            <option value="Hour" {{$header->wo_downtime_um == 'Hour' ? 'selected' : ''}}>Hour</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row col-md-12">
                    <label for="c_note" class="col-md-4 col-form-label text-md-left">Reporting Note <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <textarea id="c_note" class="form-control c_note" name="c_note" maxlength="250" required>{{($header->wo_report_note != null) ? $header->wo_report_note  : ''}}</textarea>
                    </div>
                </div>

                <div class="form-group row col-md-12" id="photodiv">
                    <label class="col-md-4 col-form-label text-md-left">SR Uploaded File</label>
                    <div class="col-md-7">
                        <!-- <div id="munculgambar_sr">

                        </div> -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                </tr>
                            </thead>
                            <tbody id="munculgambar_sr">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row col-md-12" id="photodiv">
                    <label class="col-md-4 col-form-label text-md-left">WO Uploaded File</label>
                    <div class="col-md-7">
                        <div id="munculgambar">

                        </div>
                    </div>
                </div>
                <div class="form-group row col-md-12">
                    <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
                    <label class="col-md-4 col-form-label text-md-left">Upload</label>
                    <div class="col-md-5 input-file-container">
                        <input type="file" class="form-control" id="filenamewo" name="filenamewo[]" multiple>
                    </div>
                </div>
            </div>

            <!-- End Footer Reporting -->

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
            </div>

            <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
            <input type="hidden" id="repairtypenow" name="repairpartnow" />
        </div>

        <div class="container" style="text-align: center;">
            <input type="hidden" name="btnconf" value="reportwo">
            <input type="checkbox" id="finishCheckbox" value="reportwo">
            <label for="finishCheckbox">Finish Report?</label>
        </div>

        <div class="modal-footer">
            <a id="btnclose" class="btn btn-danger" href="/woreport" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf-submit">Submit</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none; width: 150px !important;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>

<!-- pop up untuk menampilkan location from data qad -->
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

        $('.selectpicker').selectpicker();

    }

    $(document).ready(function() {
        $(document).on('change','.ins_check',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.ins_check_hidden').val(1).trigger('change');
            } else
            {
                $(this).closest("tr").find('.ins_check_hidden').val(0).trigger('change');
            }        
        });

        $('#finishCheckbox').change(function() {
            // Mengubah nilai elemen hidden berdasarkan status checkbox
            if ($(this).is(':checked')) {
                $('input[name="btnconf"]').val('closewo');
            } else {
                $('input[name="btnconf"]').val('reportwo');
            }
        });


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

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<select style="display: inline-block !important;" class="form-control selectpicker spreq" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="300px">';
            cols += '<option value = ""> -- Select Spare Part -- </option>';
            @foreach($newsparepart as $da)
            cols += '<option data-spsite="{{$da->spm_site}}" data-glaccount="{{$da->spm_account}}" value="{{$da->spm_code}}"> {{$da->spm_code}} -- {{$da->spm_desc}} </option>';
            @endforeach
            cols += '</select>';
            cols += '<input type="hidden" class="hidden_sp" name="hidden_sp[]" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="hidden" name="qtyrequired[]" value="0" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="hidden" class="qtyissued" name="qtyissued[]" value="0" />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="number" class="form-control qtypotong" min="0" step="0.01" name="qtypotong[]" value="0" required />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="text" id="loclotfrom" class="form-control loclotfrom" name="loclotfrom[]" data-toggle="tooltip" autocomplete="off" readonly placeholder="Click Here">';
            cols += '<input type="hidden" class="hidden_sitefrom" name="hidden_sitefrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_locfrom" name="hidden_locfrom[]" value="" />';
            cols += '<input type="hidden" class="hidden_lotfrom" name="hidden_lotfrom[]" value="" />';
            cols += '</td>';

            cols += '<td style="vertical-align: middle; text-align:center;">';
            cols += '<select style="display: inline-block !important;" class="form-control selectpicker ccenter" name="costcenter[]" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px">';
            cols += '<option value=""> -- Select Cost Center --</option>'
            @foreach (  $costcenter as $cc )
            cols += '<option value="{{$cc->cc_code}}" >{{$cc->cc_code}} -- {{$cc->cc_desc}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td style="vertical-align: middle; text-align:center;">';
            cols += '<select style="display: inline-block !important;" class="form-control selectpicker glacc" name="glacc[]" data-live-search="true" data-dropup-auto="false" data-size="4" data-width="150px">';
            cols += '<option value=""> -- Select GL Account --</option>';
            @foreach (  $glacc as $glaccount )
            cols += '<option value="{{$glaccount->acc_code}}" >{{$glaccount->acc_code}} -- {{$glaccount->acc_desc}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            cols += '<input type="hidden" class="op" name="op[]" value="A" />';
            counter++;

            newRow.append(cols);
            $("#detailapp").append(newRow);

            // selectRefresh();

            selectPicker();
        });

        $("#addrow_ins").on("click", function() {

            // var line = document.getElementById('line').value;

            var rowCount = $('#createTableIns tr').length;

            var currow = rowCount - 2;

            // alert(currow);

            var lastline = parseInt($('#createTableIns tr:eq(' + currow + ') td:eq(0) input[type="number"]').val()) + 1;

            if (lastline !== lastline) {
                // check apa NaN
                lastline = 1;
            }

            // alert(lastline);

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<input type="number" min="0" step="1" class="form-control stepnumber" name="stepnumber[]" value="' + lastline + '" readonly />';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<textarea type="text" class="form-control stepdesc" name="stepdesc[]" maxlength="250">';
            cols += '</textarea>';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:center;">';
            cols += '<div class="input-group">';
            cols += '<input type="number" min="0" step="0.01" class="form-control ins_duration" id="input-with-select" name="ins_duration[]" value="0.00"/>';
            cols += '<div class="input-group-append">';
            cols += '<select class="form-control durationum" name="durationum[]">';
            @foreach($um as $dataum)
            cols += '<option value="{{$dataum->um_code}}">{{$dataum->um_desc}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</div>';
            cols += '</div>';
            cols += '</td>';

            cols += '<td style="max-width: 100px !important; vertical-align:middle;text-align:center;">';
            cols += '<select class="form-control selectpicker ins_list_eng" name="ins_list_eng[' + (lastline - 1) + '][option][]" style="max-width: 100px !important;" multiple="multiple" data-live-search="true" data-max-options="5" data-size="3" data-dropup-auto="false">';
            @foreach($engineers as $dataeng)
            cols += '<option value="{{$dataeng["eng_code"]}}">{{$dataeng["eng_code"]}} -- {{$dataeng["eng_desc"]}}</option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';

            cols += '<td style="vertical-align:middle;text-align:right; max-width: 100px !important;">';
            cols += '<textarea class="form-control ins_note" name="ins_note[]" rows="2" maxlength="250"></textarea>';
            cols += '</td>';
            cols += '<td style="vertical-align:middle;text-align:center; max-width: 100px !important;">';
            cols += '<input type="checkbox" class="ins_check" name="ins_check[]" value="0">';
            cols += '<input type="hidden" class="ins_check_hidden" name="ins_check_hidden[]" value="0">';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            counter++;

            newRow.append(cols);
            $("#detailapp_ins").append(newRow);

            // selectRefresh();

            selectPicker();
        });

        $("#addrow_qc").on("click", function() {

            // var line = document.getElementById('line').value;

            var rowCount = $('#createTableQc tr').length;

            var currow = rowCount - 2;

            // alert(currow);

            var lastline = parseInt($('#createTableQc tr:eq(' + currow + ') td:eq(0) input[type="number"]').val()) + 1;

            if (lastline !== lastline) {
                // check apa NaN
                lastline = 1;
            }

            // alert(lastline);

            var newRow = $("<tr>");
            var cols = "";

            cols += '<td>';
            cols += '<input type="text" class="form-control qcparam" name="qcparam[]" maxlength="250" required autocomplete="off" />';
            cols += '</td>';

            cols += '<input type="hidden" class="qcoperator" name="qcoperator[]" value="free" />';

            cols += '<td>';
            cols += '<input type="text" class="form-control resultqc1" name="resultqc1[]" value="" maxlength="250" autocomplete="off" />';
            cols += '</td>';

            cols += '<td>';
            cols += '<input type="text" class="form-control qcum" name="qcum[]" maxlength="250" autocomplete="off" />';
            cols += '</td>';

            cols += '<td data-title="Action" style="vertical-align:middle;text-align:center;"><input type="button" class="ibtnDel btn btn-danger btn-focus" value="Delete"></td>';
            counter++;

            newRow.append(cols);
            $("#detailapp_qc").append(newRow);

            // selectRefresh();

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

        $('#newedit').submit(function(event) {
            document.getElementById('btnconf-submit').style.display = 'none';
            document.getElementById('btnclose').style.display = 'none';
            document.getElementById('btnloading').style.display = '';
        });

        $(document).on('keyup', '.qtypotong', function() {
            var thisrow = $(this);
            var valueinput = thisrow.val();

            if (valueinput !== '0') {
                // console.log('add required');
                thisrow.closest('tr').find('.loclotfrom').attr('required', 'required');
            } else {
                // console.log('hapus required');
                thisrow.closest('tr').find('.loclotfrom').removeAttr('required');
            }
        });

        // console.log(wonbr);
        var wonbr = document.getElementById('c_wonbr').value;
        var srnumber = document.getElementById('c_srnbr').value;

        $.ajax({
            url: "/imageview",
            data: {
                wonumber: wonbr,
            },
            success: function(data) {

                /* coding asli ada di backup-20211026 sblm PM attach file, coding aslinya nampilin gambar*/
                //alert('test');

                $('#munculgambar').html('').append(data);
            }
        })

        $.ajax({
            url: "/listuploadview/" + srnumber,
            success: function(data) {
                // console.log(data);
                $('#munculgambar_sr').html('').append(data);
            }
        })

        $(document).on('change', 'select.spreq', function() {
            var row = $(this).closest("tr");
            const spreqOption = $(this).val();

            var selectedOption = $(this).find('option:selected');
            // var glAccount = selectedOption.attr('data-glaccount');


            row.find(".hidden_sp").val(spreqOption);
            // row.find(".glacc").val(glAccount);

        });

        $(document).on('click', '.loclotfrom', function() {
            
            var row = $(this).closest("tr");
            const spcode = row.find(".hidden_sp").val();
            const qtypotong = row.find(".qtypotong").val();
            const getassetsite = document.getElementById('hidden_assetsite').value;

            if (qtypotong > 0) {
                $('#loadingtable').modal('show');
                //jika qty yang mau diissue bernilai positif
                $.ajax({
                    url: '/getwsasupply',
                    method: 'GET',
                    data: {
                        assetsite: getassetsite,
                        spcode: spcode,
                    },
                    success: function(vamp) {
                        // console.log(vamp);

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
                                let qtyoh = record.t_qtyoh;

                                
                                row.find(".hidden_sitefrom").val(site);
                                row.find(".hidden_locfrom").val(loc);
                                row.find(".hidden_lotfrom").val(lot);

                                const loclot = `site: ${site} & loc: ${loc} & lot: ${lot}`;

                                row.find(".loclotfrom").val(loclot);
                                row.find(".loclotfrom").attr('title', loclot);

                                const qtyohold = row.find(".qtypotong").val();

                                //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                if (parseFloat(qtyohold.replace(/,/g, '')) > parseFloat(qtyoh.replace(/,/g, ''))) {
                                    row.find(".qtypotong").attr("max", qtyoh);
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
                        // $('#myModal').modal('show');


                    },
                    complete: function(vamp) {
                        //  $('.modal-backdrop').modal('hide');
                        // alert($('.modal-backdrop').hasClass('in'));

                        setTimeout(function() {
                            $('#loadingtable').modal('hide');
                        }, 500);

                        setTimeout(function() {
                            $('#myModal').modal('show');
                        }, 1000);

                    }
                })

            } else if (qtypotong < 0) {
                //jika qty yang mau dissue bernilai negatif menandakan bahwa yang sudah diissued ingin dikembalikan lagi dengan receipt unplanned
                const wonumber = $('#c_wonbr').val();

                $.ajax({
                    url: '/getwodetsp',
                    method: 'GET',
                    data: {
                        spcode: spcode,
                        wonumber: wonumber,
                    },
                    success: function(vimp) {

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
                        vimp.forEach((record) => {
                            const rowtable = document.createElement("tr");
                            const columns = ["wd_sp_spcode", "wd_sp_site_issued", "wd_sp_loc_issued", "wd_sp_lot_issued", "wd_sp_issued"];
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
                                const site = (record.wd_sp_site_issued != null) ? record.wd_sp_site_issued : '';
                                const loc = (record.wd_sp_loc_issued != null) ? record.wd_sp_loc_issued : '';
                                const lot = (record.wd_sp_lot_issued != null) ? record.wd_sp_lot_issued : '';

                                let qtyoh = record.wd_sp_issued;
                                row.find(".hidden_sitefrom").val(site);
                                row.find(".hidden_locfrom").val(loc);
                                row.find(".hidden_lotfrom").val(lot);

                                const loclot = `${site}, ${loc}, ${lot}`;

                                row.find(".loclotfrom").val(loclot);
                                row.find(".loclotfrom").attr('title', loclot);

                                const qtyohold = row.find(".qtypotong").val();

                                //jika lebih besar yang diminta dari pada yg dimiliki di inventory supply maka qty to transfer maks = qty onhand di inv source
                                if (parseFloat(qtyohold.replace(/,/g, '')) < parseFloat(qtyoh.replace(/,/g, ''))) {
                                    row.find(".qtypotong").attr("min", -qtyoh);
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
                        // $('#myModal').modal('show');


                    },
                    complete: function(vimp) {
                        //  $('.modal-backdrop').modal('hide');
                        // alert($('.modal-backdrop').hasClass('in'));

                        setTimeout(function() {
                            $('#loadingtable').modal('hide');
                        }, 500);

                        setTimeout(function() {
                            $('#myModal').modal('show');
                        }, 1000);

                    }
                })
            }
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
    });
</script>
@endsection