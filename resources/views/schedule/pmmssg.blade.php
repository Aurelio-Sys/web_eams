@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">PM Action Message</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/pmmssg" method="GET">
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset Code</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code"
                    value="" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">PM Code</label>
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
            </div>
        </div>
    </div>
</div>
</form>
<div class="col-md-12"><hr></div>
<form action="/pmmssg" method="post" id="submit">
    {{ method_field('post') }}
    {{ csrf_field() }}
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                {{--  <th width="10%">Message Number</th>  --}}
                <th width="20%">Message Desc</th>
                <th width="10%">Asset Code</th>
                <th width="20%">Asset Desc</th>
                <th width="15%">PM Code</th>
                <th width="10%">WO Number</th>
                <th width="10%">WO Date</th>
                <th width="10%">Suggestion</th>  
                <th width="5%">Action</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            {{--  @include('schedule.table-pmconf')  --}}
            @forelse($data as $show)

                <tr>
                  {{--  <td>{{$show->pml_message}}</td>    --}}
                  <td>{{$show->msg_desc}} </td>  
                  <td>{{$show->pml_asset}} </td>  
                  <td>{{$show->asset_desc}} </td>  
                  <td>{{$show->pml_pmcode}} </td>   
                  <td>{{$show->pml_wo_number}} </td>  
                  <td>{{date('d-m-Y',strtotime($show->pml_wo_date))}} </td>  
                  <td>{{date('d-m-Y',strtotime($show->pml_pm_date))}} </td>  
                  <td>
                     @if($show->pml_message != 'NF004' && $show->pml_message != 'NF005' && $show->pml_message != 'NF006')
                     <a href="javascript:void(0)" class="deletedata btn btn-primary" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
                     data-transid="{{$show->id}}" data-wodate="{{ date("d-m-Y",strtotime($show->pml_wo_date)) }}" 
                     data-pmdate="{{ date("d-m-Y",strtotime($show->pml_pm_date))}}">Action</a>
                     @endif
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="color:red">
                        <center>No Data Available</center>
                    </td>
                </tr>
            @endforelse
            <tr>
            <td colspan="7" style="border: none !important;">
                {{ $data->appends($_GET)->links() }}
            </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <a class="btn btn-danger" href="/pmconf" id="btnback">Back</a>
    <!-- <button type="submit" class="btn btn-success bt-action" id="btnconf">Confirm</button> -->
    <button type="button" class="btn bt-action" id="btnloading" style="display:none">
        <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
    </button>
</div>

</form>

<!-- Modal Create -->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">PM Confirm Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="/createinvso">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="t_loc" class="col-md-3 col-form-label text-md-right">Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                        <div class="col-md-8">
                            <select id="t_loc" class="form-control" name="t_loc" required>
                                
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
        <h5 class="modal-title text-center" id="exampleModalLabel">PM Confirm Pick</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-horizontal" method="post" action="/editinvso">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="form-group row">
                  <div class="col-md-10 offset-md-1" id="thistablemodal">
                     {{--  <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                         <thead>
                            <th width="20%">Source</th>
                             <th width="20%">Number</th>
                             <th width="20%">Sch Date</th>
                             <th width="20%">Confirm</th>
                         </thead>
                         <tbody id='ed_detailapp'></tbody>
                     </table>
                     Which date do you want to proceed to create Work Order?  --}}
                  </div>
               </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
                {{--  <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>  --}}
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
            <h5 class="modal-title text-center" id="exampleModalLabel">Notification</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form class="form-horizontal" method="post" action="/chgdatewo">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" id="d_code" name="d_code">
                    Would you like to change the Work Order date <b><span id="td_code"></span></b> to the suggestion date <b><span id="td_desc"></span></b> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success bt-action" id="btndelete">Confirm</button>
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

            // Menampilkan data log
            $.ajax({
               url:"searchlog?code="+code,
               success: function(data) {
               console.log(data);
               $('#ed_detailapp').html('').append(data);
             }
           })
       });

       $(document).on('click', '.deletedata', function(e){
            $('#deleteModal').modal('show');

            var wodate = $(this).data('wodate');
            var pmdate = $(this).data('pmdate');
            var transid = $(this).data('transid');

            document.getElementById('d_code').value          = transid;
            document.getElementById('td_code').innerHTML = wodate;
            document.getElementById('td_desc').innerHTML = pmdate;
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