@extends('layout.newlayout')
@section('content-header')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Sparepart Site Maintenance</h1>
        </div>
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    <!--
    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Site Create</button>
        </div>
    </div>
    -->
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
</div><!-- /.container-fluid -->
@endsection
@section('content')
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code" value="" autofocus autocomplete="off" />
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Site Description</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off" />
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
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
<div class="col-md-12">
    <hr>
</div>
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="20%">Code<span id="location_id_icon"></span></th>
                <th width="50%">Description</th>
                <th width="10%">Active</th>
                {{--  <th width="20%">Active for eAMS</th>
                <th width="10%">Action</th>  --}}
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-site')
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Site Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createsite">
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Site Modify</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/editsite">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_sitecode" class="col-md-4 col-form-label text-md-right">Code</label>
                        <div class="col-md-6">
                            <input id="te_sitecode" type="text" class="form-control" name="te_sitecode" autofocus readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_sitedesc" class="col-md-4 col-form-label text-md-right">Description</label>
                        <div class="col-md-6">
                            <input id="te_sitedesc" type="text" class="form-control" name="te_sitedesc" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_cek" class="col-md-4 col-form-label text-md-right">Active for eAMS</label>
                        <div class="form-check">
                            <input class="form-control" type="checkbox" value="cek" id="te_cek" name="te_cek" >
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
            <form class="form-horizontal" method="post" action="/deletesite">
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

<div class="modal" id="loadingtable" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered d-flex align-items-center justify-content-center" role="document">
      <div class="spinner-grow text-danger">LOADING</div>
      <div class="spinner-grow text-warning" style="animation-delay:0.2s;"></div>
      <div class="spinner-grow text-success" style="animation-delay:0.45s;"></div>
      <div class="spinner-grow text-info"style="animation-delay:0.65s;"></div>
      <div class="spinner-grow text-primary"style="animation-delay:0.85s;"></div>
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
        var flag = $(this).data('flag');

        document.getElementById('te_sitecode').value = sitecode;
        document.getElementById('te_sitedesc').value = desc;

        if (flag == "yes") {
            document.getElementById('te_cek').checked = true; 
        } else {
            document.getElementById('te_cek').checked = false; 
        }
        
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

    function fetch_data(page, sort_type, sort_by, code, desc) {
        $.ajax({
            url: "sitemaster/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&code=" + code + "&desc=" + desc,
            success: function(data) {
                console.log(data);
                $('tbody').html('');
                $('tbody').html(data);
            }
        })
    }

    $(document).on('click', '#btnsearch', function() {

        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = 1;

        document.getElementById('tmpcode').value = code;
        document.getElementById('tmpdesc').value = desc;

        fetch_data(page, sort_type, column_name, code, desc);
    });

    $(document).on('click', '.sorting', function() {
        var column_name = $(this).data('column_name');
        var order_type = $(this).data('sorting_type');
        var reverse_order = '';
        if (order_type == 'asc') {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            clear_icon();
            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
        }
        if (order_type == 'desc') {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            clear_icon();
            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
        }
        $('#hidden_column_name').val(column_name);
        $('#hidden_sort_type').val(reverse_order);
        var page = $('#hidden_page').val();
        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        fetch_data(page, sort_type, column_name, code, desc);
    });


    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var code = $('#s_code').val();
        var desc = $('#s_desc').val();
        fetch_data(page, sort_type, column_name, code, desc);
    });

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
            url: "/ceksite?code=" + code + "&desc=" + desc,
            success: function(data) {

                if (data == "ada") {
                    alert("Site Already Regitered!!");
                    document.getElementById('t_sitecode').value = '';
                    document.getElementById('t_sitecode').focus();
                }
                console.log(data);

            }
        })
    });

    $(document).on('change', '#t_sitedesc', function() {

        var code = $('#t_sitecode').val();
        var desc = $('#t_sitedesc').val();

        $.ajax({
            url: "/ceksite?code=" + code + "&desc=" + desc,
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

    $("#submit").submit(function(e) {
        $('#loadingtable').modal('show');
    });
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