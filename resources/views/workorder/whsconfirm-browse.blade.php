@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="m-0 text-dark">Work Order Transfer</h1>
            <p class="pb-0 m-0">Menu ini berfungsi untuk mencari work order number yang akan dilakukan transfer spare part</p>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h4>Search WO Number</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('search') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="wo_number" placeholder="WO Number" required autocomplete="off">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
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