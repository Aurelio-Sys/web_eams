@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Inventory Supply Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="row">                 
          <div class="col-sm-2">    
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#createModal">Inventory Supply Create</button>
          </div><!-- /.col -->  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/invsu" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Site</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Sparepart Supply Site</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_loc" type="text" class="form-control" name="s_loc"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
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
                <th width="20%">Asset Site</th>
                <th width="20%">Sparepart Supply Site</th>
                <th width="30%">Location</th>
                <th width="15%">Available</th>
                <th width="15%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('setting.table-invsu')
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Supply Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createinvsu">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_code" class="col-md-3 col-form-label text-md-right">Asset Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-8">
                           <select class="form-control" id="t_code" name="t_code" required>
                              <option value=""></option>
                              @foreach($dataassite as $da)
                              <option value="{{$da->assite_code}}">{{$da->assite_code}} -- {{$da->assite_desc}}</option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_desc" class="col-md-3 col-form-label text-md-right">Sparepart Supply Site <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-8">
                           <select class="form-control" id="t_desc" name="t_desc" required>
                              <option value=""></option>
                              @foreach($dataspsite as $ds)
                              <option value="{{$ds->site_code}}">{{$ds->site_code}} -- {{$ds->site_desc}}</option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-3 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-8">
                            <select id="t_loc" class="form-control" name="t_loc" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_avail" class="col-md-3 col-form-label text-md-right">Available <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-2">
                           <select class="form-control" id="t_avail" name="t_avail" required>
                              <option value="Yes" selected>Yes</option>
                              <option value="No">No</option>
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
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Supply Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editinvsu">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="form-group row">
                  <label for="te_code" class="col-md-3 col-form-label text-md-right">Asset Site</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="tv_code" name="tv_code" readonly>
                    <input type="hidden" class="form-control" id="te_code" name="te_code" readonly>
                    <input type="hidden" class="form-control" id="te_transid" name="te_transid" readonly>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="te_desc" class="col-md-3 col-form-label text-md-right">Sparepart Supply Site</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="tv_desc" name="tv_desc" readonly>
                    <input type="hidden" class="form-control" id="te_desc" name="te_desc" readonly>
                  </div>
              </div>
              <div class="form-group row">
                <label for="te_loc" class="col-md-3 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-8">
                    <select id="te_loc" class="form-control te_loc" name="te_loc" required>
                        
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="te_avail" class="col-md-3 col-form-label text-md-right">Available <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-2">
                   <select class="form-control" id="te_avail" name="te_avail" required>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                   </select>
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Inventory Supply Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/delinvsu">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    <input type="hidden" id="d_desc" name="d_desc">
                    <input type="hidden" id="d_transid" name="d_transid">
                    Delete Inventory Supply from <b> Asset Site : <span id="td_code"></span> , Supply Site : <span id="td_desc"></span></b> ?
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
        var counter = 1;

        function selectPicker() {
            $('.selectpicker').selectpicker().focus();
        }

       $(document).on('click', '#editdata', function(e){
           $('#editModal').modal('show');

           var code = $(this).data('code');
           var desc = $(this).data('desc');
           var loc = $(this).data('loc');
           var dasset = $(this).data('dasset')
           var dsource = $(this).data('dsource')
           var dloc = $(this).data('dloc')
           var transid = $(this).data('transid')
           var avail = $(this).data('avail')

           document.getElementById('te_code').value = code;
           document.getElementById('te_desc').value = desc;
           document.getElementById('te_transid').value = transid;
           document.getElementById('te_avail').value = avail;
           document.getElementById('tv_code').value = code + " -- " + dasset;
           document.getElementById('tv_desc').value = desc + " -- " + dsource;

            // Menampilkan data lokasi saat menu edit
            $.ajax({
                url:"/locsp2?site="+desc + "&&loc=" + loc ,
                success:function(data){
                    console.log(data);
                    $('#te_loc').html('').append(data);
                }
            }) 

            $("#te_loc").select2({
                width : '100%',
                theme : 'bootstrap4',
            });

       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var code = $(this).data('code');
            var desc = $(this).data('desc');
            var dasset = $(this).data('dasset')
            var dsource = $(this).data('dsource')
            var transid = $(this).data('transid')

            document.getElementById('d_code').value          = code;
            document.getElementById('d_desc').value          = desc;
            document.getElementById('d_transid').value          = transid;
            document.getElementById('td_code').innerHTML = code + "(" + dasset + ")" ;
            document.getElementById('td_desc').innerHTML = desc + "(" + dsource + ")" ;
       });

        $("#addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";
          var site = document.getElementById('t_desc').value;

          cols += '<td width="25%"><input type="number" class="form-control" name="t_step[]" min="1" autofocus=”autofocus” autocomplete="off" required></td>'
          cols += '<td width="20%">';
          cols += '<select id="a_code" class="form-control selectpicker a_code" name="a_code[]" data-live-search="true" required>';
          cols += '<option value = ""> -- Select Data -- </option>'  
          @foreach($dataloc as $dl)
          cols += '<option value="{{$dl->loc_code}}"> {{$dl->loc_code}} -- {{$dl->loc_desc}} </option>';
          @endforeach
          cols += '</td>';
          cols += '<td width="20%">';
          cols += '<select id="a_avail" class="form-control selectPicker a_avail" name="a_avail[]" required>';
          cols += '<option value = "Yes">Yes</option>'  
          cols += '<option value = "No">No</option>'  
          cols += '</td>';
          cols += '<td width="15%"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#detailapp").append(newRow);
          counter++;

          selectPicker();
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counter -= 1
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td width="25%"><input type="number" class="form-control" name="te_step[]" min="1"  autocomplete="off" required></td>'
          cols += '<td width="20%">';
          cols += '<select id="te_loc" class="form-control selectpicker te_loc" name="te_loc[]" data-live-search="true" required>';
          cols += '<option value = ""> -- Select Data -- </option>'  
          @foreach($dataloc as $dl)
          cols += '<option value="{{$dl->loc_code}}"> {{$dl->loc_code}} -- {{$dl->loc_desc}} </option>';
          @endforeach
          cols += '</td>';
          cols += '<td width="20%">';
          cols += '<select id="te_avail" class="form-control selectPicker te_avail" name="te_avail[]" required>';
          cols += '<option value = "Yes">Yes</option>'  
          cols += '<option value = "No">No</option>'  
          cols += '</td>';
          cols += '<td width="15%"><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
          cols += '<input type="hidden" name="tick[]" id="tick" class="tick" value="0"></td>';
          cols += '</tr>'
          newRow.append(cols);
          $("#ed_detailapp").append(newRow);
          counter++;

          selectPicker();
        });

        $(document).on('change','#cek',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox


            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.tick').val(1);
            } else
            {
                $(this).closest("tr").find('.tick').val(0);
            }        
        });

        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
        });   

        $("#t_code").select2({
         width : '100%',
         theme : 'bootstrap4',
        });

        $("#t_desc").select2({
         width : '100%',
         theme : 'bootstrap4',
        });

        $("#t_loc").select2({
            width : '100%',
            theme : 'bootstrap4',
        });

        // Menampilkan data lokasi saat menu create
        $(document).on('change', '#t_desc', function() {
            var site = $('#t_desc').val();
  
              $.ajax({
                  url:"/locsp?site="+site,
                  success:function(data){
                      console.log(data);
                      $('#t_loc').html('').append(data);
                  }
              }) 
          });

    </script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection