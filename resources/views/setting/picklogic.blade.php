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
            <input type="hidden" name="hdlogic" id="hdlogic" value="{{$rsdata->pick_code}}">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdloc" value="loc" checked>
                <label class="form-check-label" for="rdloc">
                    Location
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdlot" value="lot">
                <label class="form-check-label" for="rdlot">
                    Lot/Serial
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rddate" value="date">
                <label class="form-check-label" for="rddate">
                    Date
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rdlogic" id="rdexp" value="exp">
                <label class="form-check-label" for="rdexp">
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

window.onload = function(){  
    var hdlogic = document.getElementById("hdlogic").value;
    
    switch(hdlogic) {
        case "loc":
            document.getElementById('rdloc').checked = true;
            break;
        case "lot":
            document.getElementById('rdlot').checked = true;
            break;
        case "date":
            document.getElementById('rddate').checked = true;
            break;
        case "exp":
            document.getElementById('rdexp').checked = true;
            break;
        default:
            document.getElementById('rdloc').checked = true;
      }
} 

</script>
@endsection