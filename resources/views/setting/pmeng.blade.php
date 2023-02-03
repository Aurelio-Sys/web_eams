@extends('layout.newlayout')
@section('content-header')
	  
	  	  <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Engineer PM Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Engineer PM Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Code</label>
                <div class="col-md-4 mb-2 input-group">
                    <select id="s_code" class="form-control" name="s_code">
                        <option value=""></option>
                        {{--  @foreach($datasearch as $sdata)
                            <option value="{{$sdata->astype_code}}">{{$sdata->astype_code}} - {{$sdata->astype_desc}}</option>
                        @endforeach  --}}
                    </select>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Description</label>
                <div class="col-md-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="" autofocus autocomplete="off"/>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search"/> 
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                </div>
                <input type="hidden" id="tmpcode"/>
                <input type="hidden" id="tmpdesc"/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                {{--  <th>Asset Type</th>  --}}
                <th>Asset Group</th>
                {{--  <th>Asset</th>  --}}
                <th>Engineer 1</th>
                <th>Engineer 2</th>
                <th>Engineer 3</th>
                <th>Engineer 4</th>
                <th>Engineer 5</th>
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-pmeng')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="astype_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Engineer For PM Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createapmeng">
                {{ csrf_field() }}
                <div class="modal-body">
                    {{--  <div class="form-group row">
                        <label for="t_type" class="col-md-4 col-form-label text-md-right">Asset Type</label>
                        <div class="col-md-6">
                            <select id="t_type" class="form-control" name="t_type">
                                <option value="">--Select--</option>
                                @foreach($datatype as $dt)
                                    <option value="{{$dt->astype_code}}">{{$dt->astype_code}} - {{$dt->astype_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  --}}
                    <div class="form-group row">
                        <label for="t_group" class="col-md-4 col-form-label text-md-right">Asset Group</label>
                        <div class="col-md-6">
                            <select id="t_group" class="form-control" name="t_group">
                                <option value="">--Select--</option>
                                @foreach($datagroup as $dg)
                                    <option value="{{$dg->asgroup_code}}">{{$dg->asgroup_code}} - {{$dg->asgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{--  <div class="form-group row">
                        <label for="t_asset" class="col-md-4 col-form-label text-md-right">Asset</label>
                        <div class="col-md-6">
                            <select id="t_asset" class="form-control" name="t_asset">
                                <option value="">--Select--</option>
                                @foreach($dataasset as $da)
                                    <option value="{{$da->asset_code}}">{{$da->asset_code}} - {{$da->asset_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  --}}
                    <div class="form-group row">
                        <label for="t_eng" class="col-md-4 col-form-label text-md-right">Engineer (Max. 5) <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_eng" name="t_eng[]" class="form-control" multiple="multiple" required>
                                <option value="">--Select Engineer--</option>
                            </select>
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Engineer for PM Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editpmeng">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Description</label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_eng" class="col-md-4 col-form-label text-md-right">Engineer Skills</label>
                    <div class="col-md-6">
                        <select class="form-select" multiple="multiple" size="3" id="te_eng" name="te_eng[]" >

                        </select>
                        <input type="hidden" id="te_deng" name="te_deng">
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Asset Type Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deletepmeng">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Delete Asset Type <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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
       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var code = $(this).data('code');
           var desc = $(this).data('desc');
           var eng = $(this).data('eng');

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;
           document.getElementById('te_deng').value = eng;

           ambilenjiner();

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');

            document.getElementById('d_code').value          = code;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"assettypemaster/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
                success:function(data){
                    console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

       $(document).on('click', '.sorting', function(){
			var column_name = $(this).data('column_name');
			var order_type = $(this).data('sorting_type');
			var reverse_order = '';
			if(order_type == 'asc')
			{
			$(this).data('sorting_type', 'desc');
			reverse_order = 'desc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
			}
			if(order_type == 'desc')
			{
			$(this).data('sorting_type', 'asc');
			reverse_order = 'asc';
			clear_icon();
			$('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
			}
			$('#hidden_column_name').val(column_name);
			$('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
			fetch_data(page, reverse_order, column_name, code, desc);
     	});
       
       
       $(document).on('click', '.pagination a', function(event){
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

            var code  = ''; 
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;

            fetch_data(page, sort_type, column_name, code, desc);

            $("#s_code").select2({
                width : '100%',
                theme : 'bootstrap4',
                
            });
        });

        $("#t_eng").select2({
            width : '100%',
            placeholder : "Select Engineer",
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            multiple : true,
            // theme : 'bootstrap4'
        });

        function ambilenjiner(){

            var eng = $('#te_deng').val();
            var a = eng.split(";");

            $.ajax({
                url:"/searcheng",
                success: function(data) {
                    var jmldata = data.length;

                    var eng_code = [];
                    var eng_desc = [];
                    var test = [];

                    test += '<option value="">--Select Engineer--</option>';

                    for(i = 0; i < jmldata; i++){
                        eng_code.push(data[i].eng_code);
                        eng_desc.push(data[i].eng_desc);

                        if (a.includes(eng_code[i])) {
                            test += '<option value=' + eng_code[i] + ' selected>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + eng_code[i] + '>' + eng_code[i] + '--' + eng_desc[i] + '</option>';
                        }                        
                    }

                    $('#te_eng').html('').append(test); 
                }
            })
        }

        $("#te_eng").select2({
            width : '100%',
            maximumSelectionLength : 5,
            closeOnSelect : false,
            allowClear : true,
            // theme : 'bootstrap4'
        });

        $("#t_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
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