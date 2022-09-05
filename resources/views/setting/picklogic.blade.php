@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Picking Logic</h1>
            </div><!-- /.col -->
                <div class="col-sm-6">
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<div class="table-responsive col-lg-12 col-md-12">
    <form action="/picksave" method="post">
        {{ csrf_field() }}
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdlogic1" value="loc" checked>
                <label class="form-check-label" for="rdlogic1">
                    Location
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdlogic2" value="lot">
                <label class="form-check-label" for="rdlogic2">
                    Lot/Serial
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdlogic3" value="date">
                <label class="form-check-label" for="rdlogic3">
                    Date
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdlogic4" value="exp">
                <label class="form-check-label" for="rdlogic4">
                    Expired Date
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
            <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
            </button>
        </div>
</div>
@endsection

@section('scripts')
<script>
   
</script>
@endsection