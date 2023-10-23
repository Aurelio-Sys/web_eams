@extends('layout.newlayout')
@section('content-header')
	  
<div class="container-fluid">
    <div class="row">          
        <div class="col-sm-4">
            <h1 class="m-0 text-dark">Account Maintenance</h1>
        </div>    
    </div><!-- /.row -->
    <div class="col-md-12">
        <hr>
    </div>
    <form action="/addacc" method="post" id="submit">
        {{ method_field('post') }}
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-4">
                <select class="form-control" id="t_code" name="t_code">
                    <option> -- Select Data -- </option>
                    @foreach ($datamstr as $ds)
                        <option value="{{$ds->temp_code}}" data-desc="{{$ds->temp_desc}}" data-cc="{{$ds->temp_cc}}">
                            {{$ds->temp_code}} -- {{$ds->temp_desc}}
                        </option>    
                    @endforeach
                </select>
                <input type="hidden" name="t_desc" id="t_desc" />                          
                <input type="hidden" name="t_cc" id="t_cc" />                          
            </div>
            <div class="col-md-2">
                <input type="submit" class="btn btn-block btn-primary" id="btnload" value="Add to eAMS" />
            </div>
        </div>
    </form>
</div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/accmstr" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Account Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Account Description</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
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
</form>

<div class="col-md-12"><hr></div>
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
                @include('setting.table-accmstr')
            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="supp_code"/>
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Account Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form class="form-horizontal" method="post" action="/deleteacc">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="d_code" name="d_code">
                        Delete Account <b><span id="td_code"></span> -- <span id="td_desc"></span></b> ?
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

        $('#t_code').select2({
            width: '100%',
            theme: 'bootstrap4',
        });

        /* Fungsi untuk menampung nama supplier yang akan dilempar ke controller */
        $(document).on('change', '#t_code', function() {
            var select = document.getElementById('t_code');
            var selectedOption = select.options[select.selectedIndex];
    
            var desc = selectedOption.getAttribute("data-desc");
    
            document.getElementById('t_desc').value = desc;
            document.getElementById('t_cc').value = cc;
        });
    
      $(document).on('click', '#btnrefresh', function() {
         $('#s_code').val('');
         $('#s_desc').val('');
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