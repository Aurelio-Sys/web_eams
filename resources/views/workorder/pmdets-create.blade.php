@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Asset PM Details</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<!-- Create -->
<form class="form-horizontal" method="post" action="/createapmdets">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="form-group row">
            <label for="t_code" class="col-md-2 col-form-label text-md-left">Asset Code</label>
            <div class="col-md-8">
                <select id="t_code" name="t_code" class="form-control selectpicker" required>
                    <option value="">-- Select Data --</option>
                    @foreach($dataasset as $da)
                    <option value="{{$da->asset_code}}">{{$da->asset_code}} -- {{$da->asset_desc}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                <thead>
                <tr id='full'>
                    <th>Detail PM</th>
                    <th>Measurement</th>
                    <th>Value</th>
                    <th>Measurement Tolerance</th>
                    <th>Measurement Start Date</th>
                    <th>Repair Code</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody id='detailapp'>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="7">
                    <input type="button" class="btn btn-lg btn-block btn-focus" id="addrow" value="Add Item" style="background-color:#1234A5; color:white; font-size:16px" />
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success bt-action" id="btncreate">Save</button> 
    </div>
</form>




@endsection

@section('scripts')
    <script>
        
        $("#t_code").select2({
            width: '100%',
            theme: 'bootstrap4',
        });

        $("#addrow").on("click", function() {

            var newRow = $("<tr>");
            var cols = "";
  
            cols += '<td><input type="text" class="form-control t_pmdet" name="t_pmdet[]" required></td>';
            cols += '<td><select clas="form-control t_mea" name="t_mea[]" required>' +
                      '<option value="">--Select--</option>' +
                      '<option value="C">Calender</option>' +
                      '<option value="M">Meter</option> ' +
                      '</select>' +
                      '</td>';
            cols += '<td><input type="number" class="form-control t_value" name="t_value[]" required></td>';
            cols += '<td><input type="number" class="form-control t_tol" name="t_tol[]" required></td>';
            cols += '<td><input type="date" class="form-control t_start" name="t_start[]" required></td>';
            {{--  cols += '<td><input type="text" class="form-control t_repcode" name="t_repcode[]" required></td>';  --}}
            cols += '<td><select clas="form-control t_repaircode" name="t_repcode[]" required>' +
                '<option value="">--Select--</option>' +
                '<option value="group">Repair Group</option>' +
                '<option value="code">Repair Code</option> ' +
                '</select>' +
                '</td>';
            cols += '<td><input type="button" class="ibtnDel btn btn-danger btn-focus"  value="Delete"></td>';
            cols += '</tr>'
            newRow.append(cols);
            $("#detailapp").append(newRow);
            counter++;
  
            {{--  selectRefresh();  --}}
            selectPicker();
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