@extends('layout.newlayout')
@section('content-header')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Site Maintenance</h1>
        </div>
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    
    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Asset Site Create</button>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-md-2">
            <form action="/loadsite" method="post" id="submit">
                {{ method_field('post') }}
                {{ csrf_field() }}
                
                    <input type="submit" class="btn btn-block btn-primary" id="btnload" value="Load Data" />
                    <button type="button" class="btn btn-info" id="s_btnloading" style="display:none;">
                        <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
                    </button>
                
            </form>
        </div>
    </div>
    -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/assetsite" method="GET">
<!-- Bagian Searching -->
<div class="container-fluid mb-2">
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="btn btn-block bg-black rounded-0" data-toggle="collapse" data-target="#collapseExample">Click Here To Search</button>
      </div>  
    </div>
    <!-- Element div yang akan collapse atau expand -->
    <div class="collapse" id="collapseExample">
        <!-- Isi element div dengan konten yang ingin ditampilkan saat collapse diaktifkan -->
        <div class="card card-body bg-black rounded-0">
            <div class="col-12 form-group row">
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Site Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off" />
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Site Description</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off" />
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                </div>
                <input type="hidden" id="tmpcode" />
                <input type="hidden" id="tmpdesc" />
            </div>
        </div>
    </div>
</div>
</form>
<div class="col-md-12">
    <hr>
</div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="30%">Code<span id="location_id_icon"></span></th>
                <th width="60%">Description</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-asset-site')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="site_code" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Site Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createaassetsite" onsubmit="return validateInput()">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_sitecode" class="col-md-4 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_sitecode" type="text" class="form-control" name="site_code" autocomplete="off" autofocus maxlength="10" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_sitedesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_sitedesc" type="text" class="form-control" name="site_desc" autocomplete="off" autofocus maxlength="50" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Site Modify</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/editassetsite">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_sitecode" class="col-md-4 col-form-label text-md-right">Code</label>
                        <div class="col-md-6">
                            <input id="te_sitecode" type="text" class="form-control" name="te_sitecode" autocomplete="off" autofocus readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_sitedesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="te_sitedesc" type="text" class="form-control" name="te_sitedesc" autocomplete="off" autofocus maxlength="50" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Site Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteassetsite">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_sitecode" name="d_sitecode">
                    Delete Site <b><span id="td_sitecode"></span> -- <span id="td_sitedesc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#submit').submit(function(event) {
        document.getElementById('btnload').style.display = 'none';
        document.getElementById('s_btnloading').style.display = '';
    });
    $(document).on('click', '#editdata', function(e) {
        $('#editModal').modal('show');

        var sitecode = $(this).data('sitecode');
        var desc = $(this).data('desc');

        document.getElementById('te_sitecode').value = sitecode;
        document.getElementById('te_sitedesc').value = desc;
    });

    $(document).on('click', '.deletedata', function(e) {
        $('#deleteModal').modal('show');

        var sitecode = $(this).data('sitecode');
        var desc = $(this).data('desc');

        document.getElementById('d_sitecode').value = sitecode;
        document.getElementById('td_sitecode').innerHTML = sitecode;
        document.getElementById('td_sitedesc').innerHTML = desc;
    });

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }


    $(document).on('click', '#btnrefresh', function() {

        var code = '';
        var desc = '';

        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = 1;

        document.getElementById('tmpcode').value = code;
        document.getElementById('tmpdesc').value = desc;
        document.getElementById('s_code').value = code;
        document.getElementById('s_desc').value = desc;

        fetch_data(page, sort_type, column_name, code, desc);
    });

    $(document).on('change', '#t_sitecode', function() {

        var code = $('#t_sitecode').val();
        var desc = $('#t_sitedesc').val();

        $.ajax({
            url: "/cekasitecode?code=" + code + "&desc=" + desc,
            success: function(data) {
              console.log(data);
              if (data == "ada") {
                alert("Code is Already Registerd!!");
                document.getElementById('t_sitecode').value = '';
                document.getElementById('t_sitecode').focus();
              }
            }
          })
    });

    $(document).on('change', '#t_sitedesc', function() {

        var code = $('#t_sitecode').val();
        var desc = $('#t_sitedesc').val();

        $.ajax({
            url: "/cekasitecode?code=" + code + "&desc=" + desc,
            success: function(data) {

                if (data == "ada") {
                    alert("Description Site Already Regitered!!");
                    document.getElementById('t_sitedesc').value = '';
                    document.getElementById('t_sitedesc').focus();
                }
                console.log(data);

            }
        })
    });

    function validateInput() {
        var t_code = document.getElementById("t_sitecode").value;
  
        // Regular expression to match only letters and numbers
        var pattern = /^[a-zsA-Z0-9-_]*$/;
  
        if (!pattern.test(t_code)) {
            alert("The User Code must consist of alphanumeric characters without spaces or special characters.");
            return false;
        }
  
        return true;
    }
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script>
    // $('#t_groupidtype').select2({
    //     width: '100%'
    // });
    // $('#te_groupidtype').select2({
    //     width: '100%'
    // });
</script>
@endsection