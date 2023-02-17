@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Spare Part Detail</h1>
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
            <input type="text" class="form-control" id="wo_num" name="wo_num" value="{{$detailmaster->wo_nbr}}" readonly>
        </div>
        <label class="col-md-1 col-form-label text-md-right">Asset</label>
        <div class="col-md-3">
            <input type="text" class="form-control" id="asset" name="asset" value="{{$detailmaster->asset_code}} -- {{$detailmaster->asset_desc}}" readonly>
        </div>
        <label class="col-md-2 col-form-label text-md-right">Finish Date</label>
        <div class="col-md-2">
            <input type="text" class="form-control" id="schedule_date" name="schedule_date" value="{{$detailmaster->wo_finish_date}} {{$detailmaster->wo_finish_time}}" readonly>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="row col-md-12">
        <h5 style="color: blue; font-weight: bold;">List of Spare Part</h5>
    </div>
</div>

<div class="table-responsive col-lg-12 col-md-12">
    <form action="/returnbacksp/submitdata" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <div class="modal-header">
        </div>

        <div class="modal-body">
            <div class="form-group row">
                <div class="table-responsive tag-container" style="overflow-x: auto; display:inline-block; white-space: nowrap; padding:0; text-align:center; position:relative">
                    <table id="createTable" class="table table-bordered order-list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 30% !important; font-weight: bold;">Spare Part</th>
                                <th style="text-align: center; width: 15% !important; font-weight: bold;">Site From</th>
                                <th style="text-align: center; width: 15% !important; font-weight: bold;">Loc From</th>
                                <th style="text-align: center; width: 15% !important; font-weight: bold;">Site To</th>
                                <th style="text-align: center; width: 15% !important; font-weight: bold;">Loc To</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Total</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Used</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Returned</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Qty Left</th>
                                <th style="text-align: center; width: 10% !important; font-weight: bold;">Confirm</th>
                            </tr>
                        </thead>
                        <tbody id='detailapp'>
                            @foreach ( $datadetail as $datas )
                                <tr>
                                    <input type="hidden" name="wonbr[]" value="{{$detailmaster->wo_nbr}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="spcode[]" value="{{$datas->rb_spcode}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="siteform[]" value="{{$datas->rb_siteto}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="locform[]" value="{{$datas->rb_locto}}"  {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="lotfrom[]" value="{{$datas->rb_lotfrom}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="siteto[]" value="{{$datas->rb_sitefrom}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
                                    <input type="hidden" name="locto[]" value="{{$datas->rb_locfrom}}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}/>
         
                                    <td>{{ $datas->rb_spcode }} -- {{ $datas->rb_spdesc}}</td>
                                    <td style="min-width: 100px !important;">{{ $datas->rb_siteto }}</td>
                                    <td style="min-width: 100px !important;">{{ $datas->rb_locto }}</td>
                                    <td style="min-width: 100px !important;">{{ $datas->rb_sitefrom }}</td>
                                    <td style="min-width: 100px !important;">{{ $datas->rb_locfrom }}</td>
                                    <td style="min-width: 120px !important;">{{ $datas->rb_qtyeng }}</td>
                                    <td style="min-width: 120px !important;">{{ $datas->rb_qtyactual }}</td>
                                    <td style="min-width: 120px !important;">{{ $datas->rb_qtyreturned }}</td>
                                    <td>
                                        <input type="number" class="form-control" name="qtyreturnback[]" style="width: 150px !important;" min="0" max="{{ $datas->rb_qtyreturnback }}" required value="{{ $datas->rb_qtyreturnback }}" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}} /> 
                                    </td>
                                    <td style="vertical-align: middle; text-align:center;">
                                        <input type="checkbox" class="qaddel" name="qaddel[]" value="" {{$datas->rb_qtyreturnback == 0 ? 'disabled':''}}>
                                        <input type="hidden" class="tick" name="tick[]" value="0" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="/returnbacksp" id="btnback">Back</a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf" disabled>Confirm & Transfer</button>
            <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

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

        $(document).on('change', '.qaddel', function(e) {
            var checkbox = $(this), // Selected or current checkbox
                value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked')) {
                $(this).closest("tr").find('.tick').val(1);
            } else {
                $(this).closest("tr").find('.tick').val(0);
            }
        });
    });
</script>
@endsection