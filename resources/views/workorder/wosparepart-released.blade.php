@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Spare Part Detail</h1>
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
            <input type="text" class="form-control" id="asset" name="asset" value="{{$data->asset_code}} - {{$data->asset_desc}}" readonly>
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
    <form action="/submitrelease" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <input type="hidden" name="hide_wonum" value="{{$data->wo_number}}" />
        <input type="hidden" class="form-control" id="hiddenasset" name="assetcode" value="{{$data->asset_code}}" readonly>
        <input type="hidden" name="assetsite" value="{{$data->wo_site}}" />
        <div class="modal-header">
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Required</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Status Spare Part</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @forelse ( $wo_sp as $datas )

                            <tr>
                                <td style="vertical-align:middle;text-align:left;">
                                    {{$datas->spm_code}} -- {{$datas->spm_desc}}
                                </td>
                                <td style="vertical-align:middle;text-align:right;">
                                    {{number_format($datas->wd_sp_required,2)}}
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    @if ($datas->wd_sp_flag == 1)
                                        not ready
                                    @else
                                        ready
                                    @endif
                                </td>
                            </tr>
                            
                            @empty
                            <tr>
                                <td colspan="7" style="color:red;">
                                    <center>No Data Available</center>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/wojoblist" id="btnback">Back</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
 
</script>
@endsection