@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Approval WO Maintenance</h1>
          </div>    
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<div class="col-md-12"><hr></div>
<form class="form-horizontal" method="post" action="/createappwo">
   {{ csrf_field() }}
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
         <th width="15%">Sequence</th>
         <th width="70%">Role</th>
         <th width="15%">Delete</th>
      </thead>
      <tbody id='ed_detailapp'></tbody>
      <tfoot>
         <tr>
            <td colspan="3">
               <input type="button" class="btn btn-lg btn-block btn-focus" id="ed_addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
            </td>
         </tr>
      </tfoot>
    </table>
    <div class="modal-footer">
      <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-success bt-action" id="btnedit">Save</button>
    </div>
</div>
</form>
@endsection

@section('scripts')
    <script>
        var counter = 1;

        function selectPicker() {
            $('.selectpicker').selectpicker().focus();
        }

         function getApp() {
            $.ajax({
                  url:"getApp",
                  success: function(data) {
                  console.log(data);
                  $('#ed_detailapp').html('').append(data);
               }
            })
         }

         getApp();

        $("table.order-list").on("click", ".ibtnDel", function(event) {
          $(this).closest("tr").remove();
          counter -= 1
        });

        $("#ed_addrow").on("click", function() {

          var newRow = $("<tr>");
          var cols = "";

          cols += '<td width="30%"><input type="hidden" name="te_id[]"><input type="number" class="form-control" name="te_seq[]" min="0" required></td>';
          cols += '<td width="50%">';
          cols += '<select id="te_role" class="form-control selectpicker te_role" name="te_role[]" data-live-search="true" required>';
          cols += '<option value = ""> -- Select Data -- </option>'  
          @foreach($datarole as $dr)
          cols += '<option value="{{$dr->role_code}}"> {{$dr->role_code}} -- {{$dr->role_desc}} </option>';
          @endforeach
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

    </script>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script> -->

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection