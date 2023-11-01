@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Master Asset View</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/viewasset" method="GET">
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
                    <label for="s_per1" class="col-md-1 col-form-label text-md-right">{{ __('') }}</label>
                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                        <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                    </div>
                    <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
                        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                        <input type="button" class="btn btn-block btn-primary" id="btnexcel" value="Export to Excel" style="float:right" />
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
            @include('report.table-viewasset')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asset_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Detail Asset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editasset" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <label for="te_code" class="col-md-2 col-form-label text-md-right">Code</label>
                    <div class="col-md-4">
                        <input id="te_code" type="text" class="form-control" name="te_code" readonly/>
                        <input id="te_assetid" type="hidden" name="te_assetid"/>
                    </div>
                    <label for="te_site" class="col-md-2 col-form-label text-md-right">Site</label>
                    <div class="col-md-4">
                        <input id="te_site" type="text" class="form-control" name="te_site" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_desc" class="col-md-2 col-form-label text-md-right">Desc</label>
                    <div class="col-md-4">
                        <input id="te_desc" type="text" class="form-control" name="te_desc" readonly/>
                    </div>
                    <label for="te_loc" class="col-md-2 col-form-label text-md-right">Location</label>
                    <div class="col-md-4">
                        <input id="te_loc" type="text" class="form-control" name="te_loc" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_um" class="col-md-2 col-form-label text-md-right">UM </label>
                    <div class="col-md-4">
                        <input id="te_um" type="text" class="form-control" name="te_um" readonly/>
                    </div>
                    <label for="te_type" class="col-md-2 col-form-label text-md-right">Type</label>
                    <div class="col-md-4">
                        <input id="te_type" type="text" class="form-control" name="te_type" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_sn" class="col-md-2 col-form-label text-md-right">Serial Number</label>
                    <div class="col-md-4">
                        <input id="te_sn" type="text" class="form-control" name="te_sn" readonly />
                    </div>
                    <label for="te_group" class="col-md-2 col-form-label text-md-right">Group</label>
                    <div class="col-md-4">
                        <input id="te_group" type="text" class="form-control" name="te_group" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_date" class="col-md-2 col-form-label text-md-right">Purchase Date</label>
                    <div class="col-md-4">
                        <input id="te_prc_date" type="text" class="form-control" name="te_prc_date" readonly >
                    </div>
                    <label for="te_qad" class="col-md-2 col-form-label text-md-right">Asset Accounting</label>
                    <div class="col-md-4">
                      <input id="te_qad" type="text" class="form-control" name="te_qad" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_prc_price" class="col-md-2 col-form-label text-md-right">Purchase Price</label>
                    <div class="col-md-4">
                        <input id="te_prc_price" type="number" class="form-control" name="te_prc_price" readonly  />
                    </div>
                    <label for="te_supp" class="col-md-2 col-form-label text-md-right">Supplier</label>
                    <div class="col-md-4">
                        <input id="te_supp" type="text" class="form-control" name="te_supp" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_renew" class="col-md-2 col-form-label text-md-right">Asset Renewal Date</label>
                    <div class="col-md-4">
                        <input id="te_renew" type="text" class="form-control" name="te_renew" readonly >
                    </div>
                    <label for="te_active" class="col-md-2 col-form-label text-md-right">Active</label>
                    <div class="col-md-4">
                        <input id="te_active" type="text" class="form-control" name="te_active" readonly/>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_note" class="col-md-2 col-form-label text-md-right">Note</label>
                    <div class="col-md-8">
                        <textarea id="te_note" type="text" class="form-control" name="te_note" readonly  />
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="te_file" class="col-md-2 col-form-label text-md-right">Current File</label>
                    <div class="col-md-8">
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
                <div class="form-group row divefoto1">
                    <label class="col-md-2 col-form-label text-md-right"></label>
                    <div class="col-md-8">
                        <img src="" class="rounded" width="150px" id="foto1">
                    </div>
                </div>
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

           var code         = $(this).data('code');
           var desc         = $(this).data('desc');
           var site         = $(this).data('site');
           var loc          = $(this).data('loc');
           var locdesc      = $(this).data('locdesc');
           var um           = $(this).data('um');
           var sn           = $(this).data('sn');
           var prc_date     = $(this).data('prc_date');
           var prc_price    = $(this).data('prc_price');
           var type         = $(this).data('type');
           var typedesc         = $(this).data('typedesc');
           var group        = $(this).data('group');
           var groupdesc        = $(this).data('groupdesc');
           var supp         = $(this).data('supp');
           var note         = $(this).data('note');
           var active       = $(this).data('active');
           var renew       = $(this).data('renew');
           var upload 		= $(this).data('upload');
           var qad 		= $(this).data('qad');
           var assetid 		= $(this).data('assetid');
           var assetimg    = '/uploadassetimage/' +$(this).data('assetimg');
           var uploadname = upload.substring(upload.lastIndexOf('/') + 1,upload.length);
            //   console.log(uploadname);
            
            $.ajax({
                url:"/assetfile/" + code,
                success: function(data) {
                    console.log(data);
                    $('#listupload').html('').append(data); 
                }
            })

           document.getElementById('te_code').value         = code;
           document.getElementById('te_desc').value         = desc;
           document.getElementById('te_site').value         = site;
           document.getElementById('te_loc').value         = loc + " : " + locdesc  ;
           document.getElementById('te_um').value           = um;
           document.getElementById('te_sn').value           = sn;
           document.getElementById('te_prc_date').value     = prc_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
           document.getElementById('te_prc_price').value    = prc_price;
           document.getElementById('te_type').value         = type + " : " + typedesc  ;
           document.getElementById('te_group').value        = group + " : " + groupdesc  ;
           document.getElementById('te_supp').value         = supp;
           document.getElementById('te_note').value         = note;
           document.getElementById('te_active').value       = active;
           document.getElementById('te_renew').value       = renew.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3-$2-$1");
           document.getElementById('foto1').src       = assetimg;
           document.getElementById('te_qad').value          = qad;
           document.getElementById('te_assetid').value          = assetid;

       });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

        $(document).on('click', '#btnexcel', function() {
            var sasset = $('#s_code').val();
            var loc = $('#s_loc').val();
            var group = $('#s_group').val();
            var type = $('#s_type').val();
            
            window.open("/excelasset?sasset=" + sasset + "&sloc=" + loc + "&sgroup=" + group + "&stype=" + type , '_blank'); 
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