@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Asset Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/assetmaster" method="GET">
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
                    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset</label>
                    <div class="col-md-4 col-sm-4 mb-2 input-group">
                        <input id="s_code" type="text" class="form-control" name="s_code"
                        value="{{$s_code}}" autofocus autocomplete="off"/>
                    </div>
                    <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
                    <div class="col-md-4 col-sm-4 mb-2 input-group">
                        <input id="s_loc" type="text" class="form-control" name="s_loc"
                        value="{{$s_loc}}" autofocus autocomplete="off"/>
                    </div>
                    <label for="s_type" class="col-md-2 col-sm-2 col-form-label text-md-right">Type</label>
                    <div class="col-md-4 col-sm-4 mb-2 input-group">
                        <input id="s_type" type="text" class="form-control" name="s_type"
                        value="{{$s_type}}" autofocus autocomplete="off"/>
                    </div>
                    <label for="s_group" class="col-md-2 col-sm-2 col-form-label text-md-right">Group</label>
                    <div class="col-md-4 col-sm-4 mb-2 input-group">
                        <input id="s_group" type="text" class="form-control" name="s_group"
                        value="{{$s_group}}" autofocus autocomplete="off"/>
                    </div>
                    <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                    <div class="col-md-8 col-sm-8 mb-8 input-group">
                        <button class="btn btn-block btn-primary  col-md-3" id="btnsearch" style="float:right"/>Search</button>
                        &nbsp;&nbsp;&nbsp;
                        <button class="btn btn-block btn-primary  col-md-1" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" class="btn btn-block btn-primary  col-md-3" id="btnexcel" value="Export to Excel" style="float:right" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Code</th>
                <th width="25%">Description</th>
                <th width="15%">Type</th>
                <th width="15%">Group</th>
                <th width="20%">Location</th>
                <th width="10%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-asset')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asset_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Asset Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createasset" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-4 col-form-label text-md-right">Code <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_code" type="text" class="form-control" name="t_code" autocomplete="off" autofocus maxlength="20" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <input id="t_desc" type="text" class="form-control" name="t_desc" autocomplete="off" autofocus maxlength="50" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_um" class="col-md-4 col-form-label text-md-right">UM </label>
                        <div class="col-md-6">
                            <select id="t_um" class="form-control" name="t_um" >
                                <option value="">--Select Data--</option>
                                @foreach($datameaum as $du)
                                    <option value="{{$du->um_code}}">{{$du->um_code}} -- {{$du->um_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_type" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-6">
                            <select id="t_type" class="form-control" name="t_type" >
                                <option value="">--Select Data--</option>
                                @foreach($dataastype as $t)
                                    <option value="{{$t->astype_code}}">{{$t->astype_code}} -- {{$t->astype_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_group" class="col-md-4 col-form-label text-md-right">Group</label>
                        <div class="col-md-6">
                            <select id="t_group" class="form-control" name="t_group" >
                                <option value="">--Select Data--</option>
                                @foreach($dataasgroup as $g)
                                    <option value="{{$g->asgroup_code}}">{{$g->asgroup_code}} -- {{$g->asgroup_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_site" class="col-md-4 col-form-label text-md-right">Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_site" class="form-control" name="t_site" required>
                                <option value="">--Select Data--</option>
                                @foreach($datasite as $s)
                                    <option value="{{$s->assite_code}}">{{$s->assite_code}} -- {{$s->assite_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-4 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-6">
                            <select id="t_loc" class="form-control" name="t_loc" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_sn" class="col-md-4 col-form-label text-md-right">Serial Number</label>
                        <div class="col-md-6">
                            <input id="t_sn" type="text" class="form-control" name="t_sn" autocomplete="off" autofocus maxlength="25" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_qad" class="col-md-4 col-form-label text-md-right">Asset Accounting</label>
                        <div class="col-md-6">
                            <select id="t_qad" class="form-control" name="t_qad" >
                                <option value="">--Select Data--</option>
                                @foreach($dataassetqad as $dq)
                                    <option value="{{$dq->temp_code}}">{{$dq->temp_code}} -- {{$dq->temp_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                        <div class="col-md-6">
                            <select id="t_supp" class="form-control" name="t_supp" >
                                <option value="">--Select Data--</option>
                                @foreach($datasupp as $p)
                                    <option value="{{$p->supp_code}}">{{$p->supp_code}} -- {{$p->supp_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_prc_date" class="col-md-4 col-form-label text-md-right">Purchase Date</label>
                        <div class="col-md-6">
                            <input id="t_prc_date" type="date" class="form-control" name="t_prc_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                        <div class="col-md-6">
                            <input id="t_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="t_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_note" class="col-md-4 col-form-label text-md-right">Note</label>
                        <div class="col-md-6">
                            <textarea id="t_note" type="text" class="form-control" name="t_note" autocomplete="off" autofocus maxlength="200" rows="5" /></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_active" class="col-md-4 col-form-label text-md-right">Active</label>
                        <div class="col-md-6">
                            <select id="t_active" class="form-control" name="t_active" required >
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
			            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Upload') }}</label>
			            <div class="col-md-6 input-file-container">  
			                <input type="file" class="form-control" name="filename[]" multiple>
			            </div>
			        </div>
                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                        <div class="col-md-6 input-file-container">  
                            <input type="file" class="form-control" name="t_image">
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
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editasset" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-6">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                        <input id="te_assetid" type="hidden" name="te_assetid"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-4 col-form-label text-md-right">Description <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
                    <div class="col-md-6">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" autocomplete="off" autofocus maxlength="50" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_um" class="col-md-4 col-form-label text-md-right">UM </label>
                    <div class="col-md-6">
                        <select id="te_um" class="form-control" name="te_um" >
                            <option value="">--Select Data--</option>
                            @foreach($datameaum as $du)
                                <option value="{{$du->um_code}}">{{$du->um_code}} -- {{$du->um_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_type" class="col-md-4 col-form-label text-md-right">Type</label>
                    <div class="col-md-6">
                        <select id="te_type" class="form-control" name="te_type" >
                            <option value="">--Select Data--</option>
                            @foreach($dataastype as $o)
                                <option value="{{$o->astype_code}}">{{$o->astype_code}} -- {{$o->astype_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_group" class="col-md-4 col-form-label text-md-right">Group</label>
                    <div class="col-md-6">
                        <select id="te_group" class="form-control" name="te_group" >
                            <option value="">--Select Data--</option>
                            @foreach($dataasgroup as $r)
                                <option value="{{$r->asgroup_code}}">{{$r->asgroup_code}} -- {{$r->asgroup_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_site" class="col-md-4 col-form-label text-md-right">Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_site" class="form-control" name="te_site" required>
                            <option value="">--Select Data--</option>
                            @foreach($datasite as $a)
                                <option value="{{$a->assite_code}}">{{$a->assite_code}} -- {{$a->assite_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_loc" class="col-md-4 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                    <div class="col-md-6">
                        <select id="te_loc" class="form-control te_loc" name="te_loc" required>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_sn" class="col-md-4 col-form-label text-md-right">Serial Number</label>
                    <div class="col-md-6">
                        <input id="te_sn" type="text" class="form-control" name="te_sn" autocomplete="off" autofocus maxlength="25" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_qad" class="col-md-4 col-form-label text-md-right">Asset Accounting</label>
                    <div class="col-md-6">
                        <select id="te_qad" class="form-control" name="te_qad" >
                            <option value="">--Select Data--</option>
                            @foreach($dataassetqad as $dq)
                                <option value="{{$dq->temp_code}}">{{$dq->temp_code}} -- {{$dq->temp_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_supp" class="col-md-4 col-form-label text-md-right">Supplier</label>
                    <div class="col-md-6">
                        <select id="te_supp" class="form-control" name="te_supp" >
                            <option value="">--Select Data--</option>
                            @foreach($datasupp as $u)
                                <option value="{{$u->supp_code}}">{{$u->supp_code}} -- {{$u->supp_desc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_date" class="col-md-4 col-form-label text-md-right">Purchase Date</label>
                    <div class="col-md-6">
                        <input id="te_prc_date" type="date" class="form-control" name="te_prc_date" placeholder="yy-mm-dd" autocomplete="off" autofocus >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_price" class="col-md-4 col-form-label text-md-right">Purchase Price</label>
                    <div class="col-md-6">
                        <input id="te_prc_price" type="number" step="0.01" placeholder="0.00" class="form-control" name="te_prc_price" autocomplete="off" autofocus max="99999999999.99"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_note" class="col-md-4 col-form-label text-md-right">Note</label>
                    <div class="col-md-6">
                        <textarea id="te_note" type="text" class="form-control" name="te_note" autocomplete="off" autofocus maxlength="200" />
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_active" class="col-md-4 col-form-label text-md-right">Active</label>
                    <div class="col-md-6">
                        <select id="te_active" class="form-control" name="te_active" >
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_file" class="col-md-4 col-form-label text-md-right">Current File</label>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                        	<thead>
                        		<tr>
                        			<th>File Name</th>
                        		</tr>
                        	</thead>
                        	<tbody id="listupload">
                        		
                        	</tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group row">
		            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Upload New') }}</label>
		            <div class="col-md-6 input-file-container">  
		                <input type="file" class="form-control" name="filename[]" multiple>
		            </div>
		        </div>
                <div class="form-group row divefoto">
                    <label for="te_image" class="col-md-4 col-form-label text-md-right">Image</label>
                    <div class="col-md-6">
                        <input id="te_image" name="te_image" type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <div class="form-group row divefoto1">
                    <label class="col-md-4 col-form-label text-md-right"></label>
                    <div class="col-md-6">
                        <img src="" class="rounded" width="150px" id="foto1">
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Asset Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/deleteasset">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_site" name="d_site">
                    <input type="hidden" id="d_loc" name="d_loc">
                    Delete Asset <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

    	$(document).on('click', '.deleterow', function(e){
    		var data = $(this).closest('tr').find('.rowval').val();

    		$.ajax({
                url:"/deleteupload/" + data,
                success: function(data) {
                
                    $('#listupload').html('').append(data); 
                }
            })
    	});
    	

       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var code         = $(this).data('code');
           var desc         = $(this).data('desc');
           var site         = $(this).data('site');
           var loc          = $(this).data('loc');
           var um           = $(this).data('um');
           var sn           = $(this).data('sn');
           var prc_date     = $(this).data('prc_date');
           var prc_price    = $(this).data('prc_price');
           var type         = $(this).data('type');
           var group        = $(this).data('group');
           var supp         = $(this).data('supp');
           var note         = $(this).data('note');
           var active       = $(this).data('active');
           var upload 		= $(this).data('upload');
           var qad 		= $(this).data('qad');
           var assetid 		= $(this).data('assetid');
           var assetimg    = '/uploadassetimage/' +$(this).data('assetimg');
           var uploadname = upload.substring(upload.lastIndexOf('/') + 1,upload.length);
            //   console.log(uploadname);
            
            $.ajax({
                url:"/setlistupload/" + code,
                success: function(data) {
                    console.log(data);
                    $('#listupload').html('').append(data); 
                }
            })

           document.getElementById('te_code').value         = code;
           document.getElementById('te_desc').value         = desc;
           document.getElementById('te_site').value         = site;
           document.getElementById('te_um').value           = um;
           document.getElementById('te_sn').value           = sn;
           document.getElementById('te_prc_date').value     = prc_date;
           document.getElementById('te_prc_price').value    = prc_price;
           document.getElementById('te_type').value         = type;
           document.getElementById('te_group').value        = group;
           document.getElementById('te_supp').value         = supp;
           document.getElementById('te_note').value         = note;
           document.getElementById('te_active').value       = active;
           document.getElementById('foto1').src       = assetimg;
           document.getElementById('te_qad').value          = qad;
           document.getElementById('te_assetid').value          = assetid;

            $.ajax({
                url:"/locasset2?site=" + site + "&&loc=" + loc ,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data); 
                }
            }) 

            $("#te_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
            });

            $("#te_site").select2({
                width : '100%',
                theme : 'bootstrap4',
                site
            });

            $("#te_supp").select2({
                width : '100%',
                theme : 'bootstrap4',
                supp
            });

            $("#te_qad").select2({
                width : '100%',
                theme : 'bootstrap4',
                qad
            });

            $("#te_type").select2({
                width : '100%',
                theme : 'bootstrap4',
                type
            });

            $("#te_group").select2({
                width : '100%',
                theme : 'bootstrap4',
                group
            });

            $("#te_um").select2({
                width : '100%',
                theme : 'bootstrap4',
                type
            });
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');
            var site = $(this).data('site');
            var loc = $(this).data('loc');

            document.getElementById('d_code').value      = code;
            document.getElementById('d_site').value      = site;
            document.getElementById('d_loc').value      = loc;
            document.getElementById('td_code').innerHTML = code;
            document.getElementById('td_desc').innerHTML = desc;
       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

        $(document).on('change', '#t_site', function() {
          var site = $('#t_site').val();

            $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#t_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#te_site', function() {
          var site = $('#te_site').val();

            $.ajax({
                url:"/locasset?t_site="+site,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 
        });

        $(document).on('change', '#t_code', function() {
          
            var code = $('#t_code').val();
            {{--  
                var desc = $('#t_desc').val();
                var site = $('#t_site').val();
                var loc = $('#t_loc').val();
            --}}

              $.ajax({
                {{--  url:"/cekasset?code="+code+"&site="+site+"&loc="+loc ,  --}}
                url:"/cekasset?code="+code ,
                success: function(data) {
                  
                  if (data == "ada") {
                    alert("Asset Already Registered!!");
                    document.getElementById('t_code').value = '';
                    document.getElementById('t_code').focus();
                  }
                  console.log(data);
                
                }
              })
          });

        {{--  kode asset tidak boleh sama meskipun beda site dan beda lokasi
          $(document).on('change', '#t_loc', function() {
          
          var code = $('#t_code').val();
          var desc = $('#t_desc').val();
          var site = $('#t_site').val();
          var loc = $('#t_loc').val();

            $.ajax({
              url:"/cekasset?code="+code+"&site="+site+"&loc="+loc ,
              success: function(data) {
                
                if (data == "ada") {
                  alert("Asset Already Registered!!");
                  document.getElementById('t_loc').value = '';
                  document.getElementById('t_loc').focus();
                }
                console.log(data);
              
              }
            })
        });  --}}

        {{--  $(document).on('change', '#te_loc', function() {
          
            var code = $('#te_code').val();
            var desc = $('#te_desc').val();
            var site = $('#te_site').val();
            var loc = $('#te_loc').val();
  
              $.ajax({
                url:"/cekasset?code="+code+"&site="+site+"&loc="+loc ,
                success: function(data) {
                  
                  if (data == "ada") {
                    alert("Asset Already Registered!!");
                    document.getElementById('te_loc').value = '';
                    document.getElementById('te_loc').focus();
                  }
                  console.log(data);
                
                }
              })
          });  --}}

        $(document).on('change', '#t_mea', function() {
          var mea = $('#t_mea').val();
          
          if (mea == "C") {
            document.getElementById('divcal').style.display='';
            document.getElementById('divmeter').style.display='none';
            document.getElementById('t_cal').focus();
          } else if (mea == "M") {
            document.getElementById('divmeter').style.display='';
            document.getElementById('divcal').style.display='none';
            document.getElementById('t_meter').focus();
          } else {
            document.getElementById('divmeter').style.display='none';
            document.getElementById('divcal').style.display='none';
          }
        });

        $(document).on('change', '#te_mea', function() {
          var mea = $('#te_mea').val();
          
            if (mea == "C") {
                document.getElementById('divecal').style.display='';
                document.getElementById('divemeter').style.display='none';
                document.getElementById('te_cal').focus();
            } else if (mea == "M") {
                document.getElementById('divemeter').style.display='';
                document.getElementById('divecal').style.display='none';
                document.getElementById('te_meter').focus();
            } else {
                document.getElementById('divemeter').style.display='none';
                document.getElementById('divecal').style.display='none';
            }
        });

        $("#t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_supp").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_type").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });

        $("#t_group").select2({
            width : '100%',
            theme : 'bootstrap4',
            
        });


        $(document).on('change','#carccheck',function(e){
          document.getElementById('crepaircodediv').style.display='';
          document.getElementById('crepairgroupdiv').style.display='none';
          $("#crepairgroup").val(null).trigger('change');
          $("#crepaircode").val(null).trigger('change');
          document.getElementById('crepairtypeedit').value = 'code';
        });

        $(document).on('change','#cargcheck',function(e){
          document.getElementById('crepairgroupdiv').style.display='';
          document.getElementById('crepaircodediv').style.display='none';
          $("#crepairgroup").val(null).trigger('change');
          $("#crepaircode").val(null).trigger('change');
          document.getElementById('crepairtypeedit').value = 'group';
        });

        $("#crepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
        });

        $(document).on('change','#arccheck',function(e){
          document.getElementById('repaircodediv').style.display='';
          document.getElementById('repaircodeselect').value=null;
          document.getElementById('repairgroupdiv').style.display='none';
          document.getElementById('repairgroup').value=null;  
          document.getElementById('repairtype').value= 'code';
        });
        $(document).on('change','#argcheck',function(e){
          document.getElementById('repairgroupdiv').style.display='';
          document.getElementById('repairgroup').value=null;
          document.getElementById('repaircodediv').style.display='none';
          document.getElementById('repaircodeselect').value=null;
          document.getElementById('repairtype').value= 'group';
        });

        $("#crepaircode").select2({
            width : '100%',
            placeholder : "Select Repair Code",
            maximumSelectionLength : 3,
            closeOnSelect : false,
            allowClear : true,
        });

        function ambilrepair(){
            var repair = $('#te_repair').val();
            var a = repair.split(",");

            $.ajax({
                url:"/repaircode",
                success: function(data) {
                    var jmldata = data.length;

                    var repm_code = [];
                    var repm_desc = [];
                    var test = [];

                    test += '<option value="">--Select Repair--</option>';

                    for(i = 0; i < jmldata; i++){
                        repm_code.push(data[i].repm_code);
                        repm_desc.push(data[i].repm_desc);

                        if (a.includes(repm_code[i])) {
                            test += '<option value=' + repm_code[i] + ' selected>' + repm_code[i] + '--' + repm_desc[i] + '</option>';
                        } else {    
                            test += '<option value=' + repm_code[i] + '>' + repm_code[i] + '--' + repm_desc[i] + '</option>';
                        }                        
                    }

                    $('#repaircodeselect').html('').append(test); 
                }
            })
        }

        $(document).on('click', '#btnexcel', function() {
            var sasset = $('#s_code').val();
            var loc = $('#s_loc').val();
            var group = $('#s_group').val();
            var type = $('#s_type').val();
            
            window.open("/excelasset?sasset=" + sasset + "&sloc=" + loc + "&sgroup=" + group + "&stype=" + type , '_blank'); 
        });

        $("#t_qad").select2({
            width : '100%',
            theme : 'bootstrap4',
        });
        $("#t_um").select2({
            width : '100%',
            theme : 'bootstrap4',
        });
        $("#te_um").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        $(document).on('click', '#btnrefresh', function() {
            document.getElementById('s_code').value  = '';
            document.getElementById('s_loc').value  = '';
            document.getElementById('s_type').value  = '';
            document.getElementById('s_group').value  = '';
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