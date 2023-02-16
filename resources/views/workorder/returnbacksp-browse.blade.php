@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Back Spare Part Browse</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/worelease" method="GET">
    
</form>


<div class="table-responsive col-12 mt-0 pt-0">
    <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
        <thead>
            <tr style="text-align: center;">
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" width="10%">WO Number<span id="name_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="40%">Asset<span id="username_icon"></span></th>
                <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" width="10%">Finish Date<span id="name_icon"></span></th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            @include('workorder.table-returnbacksp')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
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

        $('#s_asset').select2({
            width : '100%',
            closeOnSelect : true,
            theme : 'bootstrap4',
        });
    });

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });    
</script>
@endsection