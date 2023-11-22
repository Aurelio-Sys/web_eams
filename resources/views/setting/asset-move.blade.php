@extends('layout.newlayout')
@section('content-header')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Movement Maintenance</h1>
        </div>
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    <div class="row">                 
        <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Asset Movement Create</button>
        </div>
    </div>
    <br>
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Bagian Searching -->
<form action="/assetmove" method="GET">
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
        <!--FORM Search Disini-->
        <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
        <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
            <option value="">--Select Asset--</option>
            @foreach($asset as $assetsearch)
                <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
            @endforeach
            </select>
        </div>
        <label for="s_eng" class="col-md-6 col-form-label text-md-right">{{ __('') }}</label>
        <label for="s_locfrom" class="col-md-2 col-form-label text-md-right">{{ __('Location From') }}</label>
        <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_locfrom" class="form-control" style="color:black" name="s_locfrom" autofocus autocomplete="off">
            <option value="">--Select Location--</option>
            @foreach($fromLoc as $dl)
                <option value="{{$dl->asloc_code}}" {{$dl->asloc_code === $slocfrom ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
            @endforeach
            </select>
        </div>
        <label for="s_locto" class="col-md-2 col-form-label text-md-right">{{ __('Location To') }}</label>
        <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_locto" class="form-control" style="color:black" name="s_locto" autofocus autocomplete="off">
            <option value="">--Select Location--</option>
            @foreach($toLoc as $dlt)
                <option value="{{$dlt->asloc_code}}" {{$dlt->asloc_code === $slocto ? "selected" : ""}}>{{$dlt->asloc_code}} -- {{$dlt->asloc_desc}}</option>
            @endforeach
            </select>
        </div>
        <label for="s_per1" class="col-md-2 col-form-label text-md-right">{{ __('WO Date') }}</label>
        <div class="col-md-4 col-sm-12 mb-2 input-group">
            <input type="date" name="s_per1" id="s_per1" class="form-control" value="{{$sper1}}">
        </div>
        <label for="s_per2" class="col-md-2 col-form-label text-md-right">{{ __('s/d') }}</label>
        <div class="col-md-4 col-sm-12 mb-2 input-group">
            <input type="date" name="s_per2" id="s_per2" class="form-control" value="{{$sper2}}">
        </div>
        <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
        </div>
        <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-left">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
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
                <th>Asset Code</th>
                <th>Description</th>
                <th>Site From</th>
                <th>Location From</th>
                <th>Location From Desc</th>
                <th>Site To</th>
                <th>Location To</th>
                <th>Location To Desc</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-asset-move')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asmove_code" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Movement Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createaassetmove">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_asset" class="col-md-4 col-form-label text-md-right">Asset <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_asset" class="form-control" name="t_asset" required>
                                <option value="">--Select Data--</option>
                                @foreach($asset as $da)
                                <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_fromsite" class="col-md-4 col-form-label text-md-right">Site From<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="t_fromsite" name="t_fromsite" readonly>
                            <!-- <select id="t_fromsite" class="form-control" name="t_fromsite" required>
                                <option value="">--Select Data--</option>
                                @foreach($fromSite as $s)
                                <option value="{{$s->assite_code}}">{{$s->assite_code}} -- {{$s->assite_desc}}</option>
                                @endforeach
                            </select> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_fromloc" class="col-md-4 col-form-label text-md-right">Location From<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="t_fromloc" name="t_fromloc" readonly>
                            <!-- <select id="t_fromloc" class="form-control" name="t_fromloc" required>
                                
                            </select> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_date" class="col-md-4 col-form-label text-md-right">Movement Date</label>
                        <div class="col-md-6">
                            <input id="t_date" type="date" class="form-control" name="t_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_tosite" class="col-md-4 col-form-label text-md-right">Site To<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_tosite" class="form-control" name="t_tosite" required>
                                <option value="">--Select Data--</option>
                                @foreach($fromSite as $s)
                                <option value="{{$s->assite_code}}">{{$s->assite_code}} -- {{$s->assite_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_toloc" class="col-md-4 col-form-label text-md-right">Location To<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_toloc" class="form-control" name="t_toloc" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_note" class="col-md-4 col-form-label text-md-right">Note</label>
                        <div class="col-md-6">
                            <textarea id="t_note" class="form-control" name="t_note" ></textarea>
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

@php($descSite = '')
<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Location Modify</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/editassetloc">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="te_dsite" class="col-md-4 col-form-label text-md-right">Site</label>
                        <div class="col-md-6">
                            <input id="te_dsite" type="text" class="form-control" name="te_dsite" readonly />
                            <input type="hidden" id="te_site" name="te_site">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_locationid" class="col-md-4 col-form-label text-md-right">Code</label>
                        <div class="col-md-6">
                            <input id="te_locationid" type="text" class="form-control" name="te_locationid" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="te_locationdesc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="te_locationdesc" type="text" class="form-control" name="te_locationdesc" autocomplete="off" autofocus maxlength="50" />
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

<!-- Modal View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">View Asset Movement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="v_asset" class="col-md-4 col-form-label text-md-right">Asset </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_asset" name="v_asset" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_fromsite" class="col-md-4 col-form-label text-md-right">Site From</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_fromsite" name="v_fromsite" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_fromloc" class="col-md-4 col-form-label text-md-right">Location From</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_fromloc" name="v_fromloc" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_date" class="col-md-4 col-form-label text-md-right">Movement Date</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_date" name="v_date" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_tosite" class="col-md-4 col-form-label text-md-right">Site To</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_tosite" name="v_tosite" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_toloc" class="col-md-4 col-form-label text-md-right">Location To</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="v_toloc" name="v_toloc" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_note" class="col-md-4 col-form-label text-md-right">Note</label>
                    <div class="col-md-6">
                        <textarea id="v_note" class="form-control" name="v_note" readonly ></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Location Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteassetloc">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_locationid" name="d_locationid">
                    <input type="hidden" id="d_site" name="d_site">
                    Delete Location <b><span id="td_locationid"></span> -- <span id="td_locationdesc"></span></b> For Site <b><span id="td_site"></span></b> ?
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
    $(document).on('click', '#editarea', function(e) {
        $('#editModal').modal('show');

        var locationid = $(this).data('locationid');
        var desc = $(this).data('desc');
        var site = $(this).data('site');
        var dsite = $(this).data('dsite');

        document.getElementById('te_locationid').value = locationid;
        document.getElementById('te_locationdesc').value = desc;
        document.getElementById('te_site').value = site
        document.getElementById('te_dsite').value = site + " - " + dsite;
    });

    $(document).on('click', '#viewdata', function(e) {
        $('#viewModal').modal('show');

        var asset = $(this).data('asset');
        var desc = $(this).data('desc');
        var fromsite = $(this).data('fromsite');
        var fromloc = $(this).data('fromloc');
        var descfrom = $(this).data('descfrom');
        var tosite = $(this).data('tosite');
        var toloc = $(this).data('toloc');
        var descto = $(this).data('descto');
        var ddate = $(this).data('ddate');
        ddate = new Date(ddate).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        var note = $(this).data('note');

        document.getElementById('v_asset').value = asset + " -- " + desc;
        document.getElementById('v_fromsite').value = fromsite;
        document.getElementById('v_fromloc').value = fromloc + " -- " + descfrom;
        document.getElementById('v_tosite').value = tosite;
        document.getElementById('v_toloc').value = toloc + " -- " + descto;
        document.getElementById('v_date').value = ddate;
        document.getElementById('v_note').value = note;
    });

    $(document).on('click', '.deletearea', function(e) {
        $('#deleteModal').modal('show');

        var locationid = $(this).data('locationid');
        var desc = $(this).data('desc');
        var site = $(this).data('site');

        document.getElementById('d_locationid').value = locationid;
        document.getElementById('d_site').value = site;
        document.getElementById('td_locationid').innerHTML = locationid;
        document.getElementById('td_locationdesc').innerHTML = desc;
        document.getElementById('td_site').innerHTML = site;
    });

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    function resetSearch() {
        $('#s_asset').val('');
        $('#s_per1').val('');
        $('#s_per2').val('');
        $('#s_locfrom').val('');
        $('#s_locto').val('');
      }

    $(document).on('click', '#btnrefresh', function() {

        document.getElementById('s_per1').required = false;
        document.getElementById('s_per2').required = false;
    
        resetSearch();

    });

    $(document).on('change', '#t_locationid', function() {

        var site = $('#t_site').val();
        var code = $('#t_locationid').val();
        var desc = $('#t_locationdesc').val();

        $.ajax({
            url: "/cekarea?code=" + code + "&desc=" + desc + "&site=" + site,
            success: function(data) {

                if (data == "ada") {
                    alert("Location Already Regitered!!");
                    document.getElementById('t_locationid').value = '';
                    document.getElementById('t_locationid').focus();
                }
                console.log(data);

            }
        })
    });

    $(document).on('change', '#t_locationdesc', function() {

        var site = $('#t_site').val();
        var code = $('#t_locationid').val();
        var desc = $('#t_locationdesc').val();

        $.ajax({
            url: "/cekarea?code=" + code + "&desc=" + desc + "&site=" + site,
            success: function(data) {

                if (data == "ada") {
                    alert("Description Location Already Regitered!!");
                    document.getElementById('t_locationdesc').value = '';
                    document.getElementById('t_locationdesc').focus();
                }
                console.log(data);

            }
        })
    });

    $(document).on('change', '#t_asset', function(){
        var asset = $('#t_asset').val();
        var hasil;

        $.ajax({
            url: "/cekassetloc?asset=" + asset,
            success: function(data) {
                console.log(data);
                hasil = data.split(",");
                document.getElementById('t_fromsite').value = hasil[0];
                document.getElementById('t_fromloc').value = hasil[1];
            }
        })
    });

    $("#t_asset").select2({
        width : '100%',
        theme : 'bootstrap4',
        
    });

    $("#t_tosite").select2({
        width : '100%',
        theme : 'bootstrap4',
        
    });
    $("#t_toloc").select2({
        width : '100%',
        theme : 'bootstrap4',
        
    });

    $('#s_asset').select2({
        width: '100%',
        theme: 'bootstrap4',
    });

    $('#s_asset').select2({
        width: '100%',
        theme: 'bootstrap4',
    });

    $('#s_locfrom').select2({
        width: '100%',
        theme: 'bootstrap4',
    });

    $('#s_locto').select2({
        width: '100%',
        theme: 'bootstrap4',
    });

    $(document).on('change', '#t_fromsite', function() {
    var site = $('#t_fromsite').val();

        $.ajax({
            url:"/locasset?t_site="+site,
            success:function(data){
                console.log(data);
                $('#t_fromloc').html('').append(data);
            }
        }) 
    });

    $(document).on('change', '#t_tosite', function() {
        var site = $('#t_tosite').val();
    
            $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#t_toloc').html('').append(data);
                }
            }) 
        });

    function fper() {
        var start_date = new Date($("#s_per1").val());
        var due_date = new Date($("#s_per2").val());
        var today = new Date();
        var min_date = start_date.toJSON().slice(0, 10);
    
    
        $("#s_per2").prop("min", min_date);
    
    
        if (start_date > due_date) {
            $("#s_per2").val($("#s_per1").val());
        }
    }

    $("#s_per1").change(function() {
        document.getElementById('s_per2').required = true;
        fper();
    });

    $("#s_per2").change(function() {
        document.getElementById('s_per1').required = true;
        fper();
    });

    $(document).ready(function() {
        fper();
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