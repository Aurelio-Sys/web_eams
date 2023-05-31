@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Message Maintenance</h1>
          </div>    
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<div class="col-md-12"><hr></div>
<form class="form-horizontal" method="post" action="/createmsg">
   {{ csrf_field() }}
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
         <th width="35%">Condition</th>
         <th width="15%">Message Code</th>
         <th width="60%">Message Desc</th>
      </thead>
      <tbody>
         @forelse($data as $show)
            <tr>
               <td>{{$show->msg_condition}}</td>
               <td>{{$show->msg_code}}</td>
               <td>
                  <input type="text" class="form-control" name="t_desc" id="t_desc" value="{{$show->msg_desc}}">
                  <input type="hidden" name="t_id" id="t_id" value="{{$show->id}}">
               </td>
            </tr>
            @empty
            <tr>
               <td colspan="3" style="color:red">
                  <center>No Data Available</center>
               </td>
            </tr>
         @endforelse
         <tr>
         <td style="border: none !important;">
            {{ $data->appends($_GET)->links() }}
         </td>
         </tr>

      </tbody>
    </table>
    <div>
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