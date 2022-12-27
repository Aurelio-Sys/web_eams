@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order QC Approval Detail</h1>
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
<form method="post" action="{{route('woQCUpdate')}}" id='submit'>
    @method('POST')
    @csrf
    <input type="hidden" name="woid" value="{{$dataDetail->wo_id}}"/>
    
    <div class="form-group row">
        <label for="wonumber" class="col-form-label col-md-3 text-md-right">{{ __('Work Order Number') }}</label>
        <div class="col-md-3">
            <input id="wonumber" type="text" class="form-control" name="wonumber" value="{{$dataDetail->wo_nbr}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="srnumber" class="col-form-label col-md-3 text-md-right">{{ __('Service Request Number') }}</label>
        <div class="col-md-3">
            <input id="srnumber" type="text" class="form-control" name="srnumber" value="{{$dataDetail->wo_sr_nbr !== null ? $dataDetail->wo_sr_nbr:'-'}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="assetcode" class="col-form-label col-md-3 text-md-right">{{ __('Asset Code') }}</label>
        <div class="col-md-3">
            <input id="assetcode" type="text" class="form-control" name="assetcode" value="{{$dataDetail->wo_asset}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="assetdesc" class="col-form-label col-md-3 text-md-right">{{ __('Asset Desc') }}</label>
        <div class="col-md-5">
            <input id="assetdesc" type="text" class="form-control" name="assetdesc" value="{{$dataDetail->asset_desc}}" readonly>
        </div>
    </div>

    <div class="form-group row">
        <label for="assetdesc" class="col-form-label col-md-3 text-md-right">{{ __('Engineer List') }}</label>
        <div class="col-md-5">
            <textarea id="englist" class="form-control" rows="10" style="white-space: pre-wrap !important; line-height: 0.75;" readonly>{{$dataDetail->u1 !== null ? $dataDetail->u1:""}} 
                {{$dataDetail->u2 !== null ? "\n".$dataDetail->u2:""}} 
                {{$dataDetail->u3 !== null ? "\n".$dataDetail->u3:""}} 
                {{$dataDetail->u4 !== null ? "\n".$dataDetail->u4:""}} 
                {{$dataDetail->u5 !== null ? "\n".$dataDetail->u5:""}}
            </textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-3 text-md-right">{{ __('Failure Type') }}</label>
        <div class="col-md-5">
            <input type="text" class="form-control" value="{{$dataDetail->wo_new_type}} -- {{$dataDetail->wotyp_desc}}" readonly/>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-3 text-md-right">{{ __('Failure List') }}</label>
        <div class="col-md-5">
            <textarea id="englist" class="form-control" rows="6" style="white-space: pre-wrap !important; line-height: 0.75;" readonly>{{$dataDetail->wofc1 !== null ? $dataDetail->wofc1 .'--'. $dataDetail->fd1:""}} 
                {{$dataDetail->wofc2 !== null ? "\n".$dataDetail->wofc2 .'--'. $dataDetail->fd2:""}} 
                {{$dataDetail->wofc3 !== null ? "\n".$dataDetail->wofc3 .'--'. $dataDetail->fd3:""}} 
            </textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-3 text-md-right">{{ __('Repair List') }}</label>
        <div class="col-md-5">
            <textarea id="englist" class="form-control" rows="6" style="white-space: pre-wrap !important; line-height: 0.75;" readonly>{{$dataDetail->rr11 !== null ? $dataDetail->wo_repair_code1 .'--'. $dataDetail->r11:""}} 
                {{$dataDetail->rr22 !== null ? "\n".$dataDetail->wo_repair_code2 .'--'. $dataDetail->r22:""}} 
                {{$dataDetail->rr33 !== null ? "\n".$dataDetail->wo_repair_code3 .'--'. $dataDetail->r33:""}} 
            </textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-3 text-md-right">{{ __('WO Note') }}</label>
        <div class="col-md-5">
            <textarea class="form-control" rows="4" readonly>{{$dataDetail->wo_note}}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-3 text-md-right">{{ __('Qc Note') }}</label>
        <div class="col-md-5">
            <textarea id="qcnote" class="form-control" name="qcnote" rows="3" maxlength="100"></textarea>
        </div>
    </div>
    

    <!-- <div class="form-group row md-form">
        <div class="col-md-12" style="text-align: center;">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="cbsubmit" required>
                <label class="custom-control-label" for="cbsubmit">Confirm to submit</label>
            </div>
        </div>
    </div> -->

    <div class="form-group row justify-content-end" style="margin-top: 50px;">
        <div class="col-md-2">
            <a id="back_btn" class="btn btn-danger" style="width: 100%;" href="{{ route('woQCIndex') }}">Cancel</a>
        </div>
        <div class="col-md-2">
            <input type="submit" name="submit" id='s_btnconf' value='approve' class="btn btn-info" style="width: 100%;">
            <button type="button" class="btn btn-info float-right" id="s_btnloading" style="display:none;">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
        <div class="col-md-2">
            <input type="submit" name="submit" id='s_btnconf' value='reject' class="btn btn-info" style="width: 100%;">
        </div>
    </div>

</form>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        // document.getElementById('englist').value.replace(/\n/g, '<br>');
        // document.getElementById('englist').value.replace(/\t/g, '');
    });
</script>
@endsection