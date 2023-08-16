@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Spareparts Planning</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 m-0 p-0">
        <form action="/worelease" method="GET">
            <div class="container-fluid mb-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview bg-black">
                        <a href="#" class="nav-link mb-0 p-0">
                            <p>
                                <label class="col-md-2 col-form-label text-md-left" style="color:white;">{{ __('Click here to search') }}</label>
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <div class="col-12 form-group row">

                                    <!--FORM Search Disini-->
                                    <label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Number') }}</label>
                                    <div class="col-md-4 col-sm-12 mb-2 input-group">
                                        <input id="s_nomorwo" type="text" class="form-control" name="s_nomorwo" value="" autofocus autocomplete="off">
                                    </div>
                                    <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
                                    <div class="col-md-4 col-sm-12 mb-2 input-group">
                                        <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
                                            <option value="">--Select Asset--</option>
                                            @foreach($asset as $assetsearch)
                                            <option value="{{$assetsearch->asset_code}}">{{$assetsearch->asset_desc}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label for="s_priority" class="col-md-2 col-form-label text-md-right">{{ __('Priority') }}</label>
                                    <div class="col-md-4 col-sm-12 mb-2 input-group">
                                        <select id="s_priority" type="text" class="form-control" name="s_priority">
                                            <option value="">--Select Priority--</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
                                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                                        <button class="btn btn-block btn-primary" id="btnsearch" style="float:right" />Search</button>
                                    </div>
                                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                                        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 m-0 p-0">
        <div class="table-responsive col-12 mt-0 pt-0 align-top" style="overflow-x: auto; display: block;white-space: nowrap;">
            <table class="table table-bordered mt-0" id="dataTable" cellspacing="0">
                <thead>
                    <tr style="text-align: center;">
                        <th width="8%">WO Number</th>
                        <th width="8%">Status</th>
                        <th width="8%">Schedule Date</th>
                        <th width="8%">Due Date</th>
                        <th width="8%">Priority</th>
                        <th width="20%">Asset</th>
                        <th width="20%">Sparepart</th>
                        <th width="8%">Qty Req</th>
                        <th width="8%">Qty Conf Whs</th>
                        <th width="8%">Qty Needed</th>
                    </tr>
                </thead>
                <tbody>
                    @include('schedule.table-kebutuhansp-browse')
                </tbody>
            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    function resetSearch() {
        $('#s_nomorwo').val('');
        $('#s_asset').val('');
        $('#s_priority').val('');
    }

    $(document).ready(function() {
        var cur_url = window.location.href;

        let paramString = cur_url.split('?')[1];
        let queryString = new URLSearchParams(paramString);

        let asset = queryString.get('s_asset');
        let priority = queryString.get('s_priority');

        $('#s_asset').val(asset).trigger('change');
        $('#s_priority').val(priority).trigger('change');
    });

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });
</script>
@endsection