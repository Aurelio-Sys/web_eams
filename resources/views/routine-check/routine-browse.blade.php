@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">Routine Check Browse</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active">Work Order Reporting</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
  .swal-popup {
    font-size: 2rem !important;
  }

  hr.new1 {
    border-top: 1px solid red !important;
  }

  .images {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
  }

  .images .img,
  .images .pic {
    flex-basis: 31%;
    margin-bottom: 10px;
    border-radius: 4px;
  }

  .images .img {
    width: 112px;
    height: 93px;
    background-size: cover;
    margin-right: 10px;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .images .img:nth-child(3n) {
    margin-right: 0;
  }

  .images .img span {
    display: none;
    text-transform: capitalize;
    z-index: 2;
  }

  .images .img::after {
    content: '';
    width: 100%;
    height: 100%;
    transition: opacity .1s ease-in;
    border-radius: 4px;
    opacity: 0;
    position: absolute;
  }

  .images .img:hover::after {
    display: block;
    background-color: #000;
    opacity: .5;
  }

  .images .img:hover span {
    display: block;
    color: #fff;
  }

  .images .pic {
    background-color: #F5F7FA;
    align-self: center;
    text-align: center;
    padding: 40px 0;
    text-transform: uppercase;
    color: #848EA1;
    font-size: 12px;
    cursor: pointer;
  }
</style>

<input type="hidden" id="tmpwo" value="" />
<input type="hidden" id="tmpasset" value="" />
<input type="hidden" id="tmpstatus" value="" />
<input type="hidden" id="tmppriority" value="" />
<input type="hidden" id="tmpperiod" value="" />


<div class="col-md-2">

</div>

<hr>

  <div class=""table-responsive col-12 mt-0 pt-0" style="overflow-x: auto;overflow-y: hidden ;display: inline-block;white-space: nowrap; position:relative;">
    <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr style="text-align: center;">
          <th style="width: 10%;">Work Order Number</th>
          <th style="width: 35%;">Asset</th>
          <th style="width: 15%;">WO type</th>
          <th style="width: 10%;">Status</th>
          <th style="width: 25%;">Action</th>
        </tr>
      </thead>
      <tbody>
        @include('workorder.table-woclose')
      </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
  </div>

  <!--Modal view-->
  <div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" id="newedit" method="post" action="/reportingwo">
          {{ csrf_field() }}
          <div class="modal-body">
            <input type="hidden" name="repairtype" id="repairtype">
            <input type="hidden" id="v_counter">
            <input type="hidden" name="statuswo" id="statuswo">
            <div class="form-group row col-md-12">
              <div class="col-md-3 h-50">
                <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
              </div>
              <div class="col-md-3 h-50">
                <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
              </div>
              <div class="col-md-6 h-50">
                <label for="c_asset" class="col-md-12 col-form-label text-md-left p-0">Asset</label>
              </div>
              <div class="col-md-3">
                <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" autofocus readonly>
              </div>
              <div class="col-md-3">
                <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" autofocus readonly>
              </div>
              <div class="col-md-6">
                <input id="c_asset" type="text" class="form-control pl-0 col-md-12 c_asset" style="background:transparent;border:none;text-align:left" name="c_asset" autofocus readonly>
                <input id="c_assethid" type="hidden" class="form-control c_asset" name="c_assethidden">
              </div>

            </div>

            <div id="divrepairtype">
              <div class="form-group row col-md-12 ">
                <label for="repaircode" class="col-md-4 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                <div class="col-md-6" style="vertical-align:middle;">
                  <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group">
                  <label class="form-check-label" for="argcheck">
                    Repair Group
                  </label>

                  <input class="d-inline ml-5" type="radio" name="repairtype" id="arccheck" value="code">
                  <label class="form-check-label" for="arccheck">
                    Repair Code
                  </label>
                  <input class="d-inline ml-5" type="radio" name="repairtype" id="arcmanual" value="manual">
                  <label class="form-check-label" for="arcmanual">
                    Manual
                  </label>
                </div>
              </div>

              <!-- jika pilih group -->
              <div class="col-md-12 p-0" id="divgroup" style="display: none;">
                <div class="form-group row col-md-12 divrepgroup">
                  <label for="repairgroup" class="col-md-4 col-form-label text-md-left">Repair Group <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                  <div class="col-md-6">
                    <input type="hidden" id="inputgroup1">
                    <select id="repairgroup" type="text" class="form-control repairgroup" name="repairgroup[]" autofocus>
                      <option value="" selected disabled>--Select Repair Group--</option>
                    </select>
                  </div>
                </div>
                <div id="testdivgroup">

                </div>
              </div>
              <!-- group -->

              <!-- jika pilih manual -->
              <div class="col-md-12 p-0" id="divmanual" style="display: none;">
                <div class="form-group row col-md-12 divrepgroup">
                  <label for="manualcount" class="col-md-4 col-form-label text-md-left">Number of part repaired <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                  <div class="col-md-6">
                    <input type="hidden" id="inputgroup1">
                    <select id="manualcount" type="text" class="form-control repairgroup" name="manualcount" autofocus>
                      <option value="" selected disabled>--Number of part repaired--</option>

                  </div>
                </div>
                <div id="testmanual">

                </div>
              </div>
              <!-- manual -->

              <!-- jika pilih repair code -->
              <!-- repair code 1 -->
              <div class="col-md-12 p-0" id="divrepair" style="display: none;">
                <div class="form-group row col-md-12 divrepcode">
                  <label for="repaircode1" class="col-md-4 col-form-label text-md-left">Repair Code 1 <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
                  <div class="col-md-6">
                    <input type="hidden" id="inputrepair1">
                    <select id="repaircode1" type="text" class="form-control repaircode1" name="repaircode1[]" autofocus>
                      <option value="" selected disabled>--Select Repair Code--</option>
                    </select>
                  </div>
                </div>
                <div id="testdiv">

                </div>

                <!-- repair code 2 -->
                <div class="form-group row col-md-12 divrepcode">
                  <label for="repaircode2" class="col-md-4 col-form-label text-md-left">Repair Code 2</label>
                  <div class="col-md-6">
                    <input type="hidden" id="inputrepair2">
                    <select id="repaircode2" type="text" class="form-control repaircode2" name="repaircode2[]" autofocus>
                      <option value="" selected disabled>--Select Repair Code--</option>
                    </select>
                  </div>
                </div>
                <div id="testdiv2">

                </div>

                <!-- repair code 3 -->
                <div class="form-group row col-md-12 divrepcode">
                  <label for="repaircode3" class="col-md-4 col-form-label text-md-left">Repair Code 3</label>
                  <div class="col-md-6">
                    <input type="hidden" id="inputrepair3">
                    <select id="repaircode3" type="text" class="form-control repaircode3" name="repaircode3[]" autofocus>
                      <option value="" selected disabled>--Select Repair Code--</option>
                    </select>
                  </div>
                </div>
                <div id="testdiv3">

                </div>
              </div>
            </div>

            <!-- hanya muncul jika WO PM -->
            <div id="preventiveonly" style="display:none">

              <div class="form-group row col-md-12 c_lastmeasurement">
                <label for="c_repairhour" class="col-md-4 col-form-label text-md-left">Last Measurement</label>
                <div class="col-md-6">
                  <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01">
                </div>
              </div>
              <div class="form-group row col-md-12 c_engineerdiv">
                <label for="c_lastmeasurementdate" class="col-md-4 col-form-label text-md-left">Last Maintenance</label>
                <div class="col-md-6">
                  <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate" readonly>
                </div>
              </div>
              <input type="hidden" name="assettype" id="assettype">
              <!-- <div class="form-group row col-md-12 c_lastmeasurement">
              <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Last Measurement</label>
              <div class="col-md-7">
                <input id="c_lastmeasurement" type="number" class="form-control c_repairhour" name="c_lastmeasurement" min='1' step="0.01" readonly>
              </div>
            </div>
            <div class="form-group row col-md-12 c_engineerdiv">
              <label for="c_lastmeasurementdate" class="col-md-5 col-form-label text-md-left">Last Maintenance</label>
              <div class="col-md-7">
                <input id="c_lastmeasurementdate" type="date" class="form-control c_lastmeasureentdate" name="c_lastmeasurementdate"  readonly>
              </div>
            </div> -->
            </div>


            <div class="form-group row col-md-12">
              <label for="c_finishdate" class="col-md-4 col-form-label text-md-left">Finish Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-6">
                <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus required>
              </div>
            </div>
            <div class="form-group row col-md-12">
              <label for="c_finishtime" class="col-md-4 col-form-label text-md-left">Finish Time <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-6">
                <select id="c_finishtime" class="form-select c_finishtime" name="c_finishtime" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
                  <option value='00'>00</option>
                  <option value='01'>01</option>
                  <option value='02'>02</option>
                  <option value='03'>03</option>
                  <option value='04'>04</option>
                  <option value='05'>05</option>
                  <option value='06'>06</option>
                  <option value='07'>07</option>
                  <option value='08'>08</option>
                  <option value='09'>09</option>
                  <option value='10'>10</option>
                  <option value='11'>11</option>
                  <option value='12'>12</option>
                  <option value='13'>13</option>
                  <option value='14'>14</option>
                  <option value='15'>15</option>
                  <option value='16'>16</option>
                  <option value='17'>17</option>
                  <option value='18'>18</option>
                  <option value='19'>19</option>
                  <option value='20'>20</option>
                  <option value='21'>21</option>
                  <option value='22'>22</option>
                  <option value='23'>23</option>
                </select>
                :
                <select id="c_finishtimeminute" class="form-select c_finishtime" name="c_finishtimeminute" style="border:2px solid #ced4da;border-radius:.25rem" autofocus required>
                  <option value='00'>00</option>
                  <option value='01'>01</option>
                  <option value='02'>02</option>
                  <option value='03'>03</option>
                  <option value='04'>04</option>
                  <option value='05'>05</option>
                  <option value='06'>06</option>
                  <option value='07'>07</option>
                  <option value='08'>08</option>
                  <option value='09'>09</option>
                  @for ($i = 10; $i < 60; $i++) <option value='{{$i}}'>{{$i}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="form-group row col-md-12">
              <label for="c_note" class="col-md-4 col-form-label text-md-left">Reporting Note <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
              <div class="col-md-6">
                <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <!-- <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label> -->
              <label class="col-md-12 col-form-label text-md-left">Photo Upload : </label>
            </div>
            <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images">
                <div class="pic">
                  add
                </div>
              </div>
            </div>
            <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
            <input type="hidden" id="repairtypenow" name="repairpartnow" />
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>
    </div>
  </div>


  <!--Modal Delete-->
  <div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Close</h5>
          <button type="button" class="close" id='deletequit' data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form class="form-horizontal" id="delete" method="post" action="reopenwo">
          {{ csrf_field() }}

          <div class="modal-body">
            <input type="hidden" name="tmp_wonbr" id="tmp_wonbr">
            Do you want to reopen this <i>Work Order</i> <b> <span id="d_wonbr"></span></b> ?
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="d_btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success bt-action" id="d_btnconf">Confirm</button>
            <button type="button" class="btn btn-block btn-info" id="d_btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endsection

  @section('scripts')
  <script>
    $("#s_asset").select2({
      width: '100%',

      closeOnSelect: true,
      theme: 'bootstrap4'
    });

    $(document).on('change', '#arccheck', function(e) {
      // alert('aaa');
      document.getElementById('divrepair').style.display = '';
      document.getElementById('divgroup').style.display = 'none';
      document.getElementById('divmanual').style.display = 'none';
      // alert('aaa');
      $("#manualcount").val(null).trigger('change');
      $("#repairgroup").val(null).trigger('change');
      $("#repaircode1").val(null).trigger('change');
      $("#repaircode2").val(null).trigger('change');
      $("#repaircode3").val(null).trigger('change');

      document.getElementById('repairtype').value = 'code';
    });

    $(document).on('change', '#argcheck', function(e) {
      document.getElementById('divgroup').style.display = '';
      document.getElementById('divrepair').style.display = 'none';
      document.getElementById('divmanual').style.display = 'none';
      $("#manualcount").val(null).trigger('change');
      $("#repairgroup").val(null).trigger('change');
      $("#repaircode1").val(null).trigger('change');
      $("#repaircode2").val(null).trigger('change');
      $("#repaircode3").val(null).trigger('change');
      document.getElementById('repairtype').value = 'group';
    });

    $(document).on('change', '#arcmanual', function(e) {
      document.getElementById('divmanual').style.display = '';
      document.getElementById('divgroup').style.display = 'none';
      document.getElementById('divrepair').style.display = 'none';
      $("#manualcount").val(null).trigger('change');
      $("#repairgroup").val(null).trigger('change');
      $("#repaircode1").val(null).trigger('change');
      $("#repaircode2").val(null).trigger('change');
      $("#repaircode3").val(null).trigger('change');
      document.getElementById('repairtype').value = 'manual';
    });

    $('#repairgroup').select2({
      placeholder: "Select Data",
      width: '100%',
      theme: 'bootstrap4',
    });
    $('#repaircode1').select2({
      placeholder: "Select Data",
      width: '100%',
      theme: 'bootstrap4',
    });
    $('#repaircode2').select2({
      placeholder: "Select Data",
      width: '100%',
      theme: 'bootstrap4',
    });
    $('#repaircode3').select2({
      placeholder: "Select Data",
      width: '100%',
      theme: 'bootstrap4',
    });
    var object = {
      spare1: 0,
      spare2: 0,
      spare3: 0
    }

    $(document).on('submit', '#newedit', function(event) {
      event.preventDefault();

      rptype1 = document.getElementById('repairtype').value;

      val1 = document.getElementById('repaircode1').value;
      val2 = document.getElementById('repaircode2').value;
      val3 = document.getElementById('repaircode3').value;
      valgroup = document.getElementById('repairgroup').value;
      if (rptype1 == 'code') {
        if (val1 == '' && val2 == '' && val3 == '') {
          swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Enter minimum 1 repair code',
            toast: true,
            showConfirmButton: false,
            timer: 2000,
          })
          event.preventDefault();
        } else {
          document.getElementById('btnconf').style.display = 'none';
          document.getElementById('btnclose').style.display = 'none';
          document.getElementById('btnloading').style.display = '';
          document.getElementById('deletequit').style.display = 'none';
          document.getElementById('newedit').submit();
        }
      } else if (rptype1 == 'group') {
        if (repairgroup == '' || repairgroup == null) {
          swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Enter minimum 1 repair group',
            toast: true,
            showConfirmButton: false,
            timer: 2000,
          })
          event.preventDefault();
        } else {

          document.getElementById('btnconf').style.display = 'none';
          document.getElementById('btnclose').style.display = 'none';
          document.getElementById('btnloading').style.display = '';
          document.getElementById('deletequit').style.display = 'none';
          document.getElementById('newedit').submit();
        }
      } else {
        document.getElementById('btnconf').style.display = 'none';
        document.getElementById('btnclose').style.display = 'none';
        document.getElementById('btnloading').style.display = '';
        document.getElementById('deletequit').style.display = 'none';
        document.getElementById('newedit').submit();
      }
    });
    $(document).on('click', '.reopen', function() {

      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      document.getElementById('d_wonbr').textContent = wonbr;
      document.getElementById('tmp_wonbr').value = wonbr;
      $('#deleteModal').modal('show');

    });

    function clear_icon() {
      $('#id_icon').html('');
      $('#post_title_icon').html('');
    }

    function fetch_data(page, sort_type, sort_by, wonumber, woasset, wostatus) {
      $.ajax({
        url: "/woreport/pagination?page=" + page + "&sorttype=" + sort_type + "&sortby=" + sort_by + "&wonumber=" + wonumber + "&woasset=" + woasset + "&wostatus=" + wostatus,
        success: function(data) {
          // console.log(data);
          $('tbody').html('');
          $('tbody').html(data);
        }
      })
    }

    $(document).on('click', '.jobview', function() {
      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      // $('#loadingtable').modal('hide');
      $('#loadingtable').modal('show');
      var counter = document.getElementById('v_counter');

      $.ajax({
        url: '/womaint/getnowo?nomorwo=' + wonbr,
        success: function(vamp) {
          var tempres = JSON.stringify(vamp);
          var result = JSON.parse(tempres);
          // console.log(result);
          var wonbr = result[0].wo_nbr;
          var srnbr = result[0].wo_sr_nbr;
          var asset = result[0].asset_desc;
          var asscode = result[0].wo_asset;
          var wostatus = result[0].wo_status;
          var repair1 = result[0].rr11;
          var repair2 = result[0].rr22;
          var repair3 = result[0].rr33;
          var rprstatus = result[0].wo_repair_type;
          var rprgroup = result[0].wo_repair_group;
          var wotype = result[0].wo_type;
          var assetlastmt = result[0].asset_last_mtc;
          var assetlastus = result[0].asset_last_usage_mtc;
          var assettype = result[0].asset_measure;
          // alert(wotype);
          // alert(rprstatus);
          document.getElementById('repairtypenow').value = wotype;
          var event = new Event('change', {
            "bubbles": true
          });
          document.getElementById('statuswo').value = wostatus;
          // alert(repair1);
          document.getElementById('v_counter').value = counter;
          document.getElementById('c_wonbr').value = wonbr;
          document.getElementById('c_srnbr').value = srnbr;
          document.getElementById('c_asset').value = asscode + '-' + asset;
          document.getElementById('c_assethid').value = asscode;
          document.getElementById('repaircode1').value = repair1;
          document.getElementById('repaircode2').value = repair2;
          document.getElementById('repaircode3').value = repair3;
          if (wotype == 'auto') {
            document.getElementById('divrepairtype').style.display = 'none';
            document.getElementById('assettype').value = assettype;
            document.getElementById('c_lastmeasurement').value = assetlastus;
            document.getElementById('c_lastmeasurementdate').value = assetlastmt;
            document.getElementById('preventiveonly').style.display = '';
          } else {
            document.getElementById('divrepairtype').style.display = '';
            document.getElementById('preventiveonly').style.display = 'none';
            if (rprstatus == 'code') {

              document.getElementById('argcheck').checked = false;
              document.getElementById('arccheck').checked = true;
              document.getElementById('divrepair').style.display = '';
              document.getElementById('divgroup').style.display = 'none';
              document.getElementById('repairgroup').value = null;
              $("#repairgroup").val(null).trigger('change');
              document.getElementById('repairtype').value = 'code';
              if (repair1 != null) {
                document.getElementById('repaircode1').dispatchEvent(event);
              }
              if (repair2 != null) {
                document.getElementById('repaircode2').dispatchEvent(event);
              }
              if (repair3 != null) {
                document.getElementById('repaircode3').dispatchEvent(event);
              }
            } else if (rprstatus == 'group') {
              document.getElementById('argcheck').checked = true;
              document.getElementById('arccheck').checked = false;
              document.getElementById('divgroup').style.display = '';
              document.getElementById('divrepair').style.display = 'none';
              $("#repairgroup").val(rprgroup).trigger('change');
              $("#repaircode1").val(null).trigger('change');
              $("#repaircode2").val(null).trigger('change');
              $("#repaircode3").val(null).trigger('change');
              document.getElementById('repairtype').value = 'group';
            }
          }

          $('#repaircode1').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            repair1
          });
          $('#repaircode2').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            repair2
          });
          $('#repaircode3').select2({
            placeholder: "Select Data",
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            repair3

          });
          uploadImage();
          if ($('#loadingtable').hasClass('show')) {

            setTimeout(function() {
              $('#loadingtable').modal('hide');

            }, 500);
          }
          setTimeout(function() {
            $('#viewModal').modal('show');
          }, 1000);
        }
      })
    });

    $(document).on('change', '#repaircode1', function(event) {
      var rc1 = document.getElementById('repaircode1').value;
      // alert(rc1);
      $("#testdiv").html('');
      if (rc1 != '') {
        $.ajax({
          url: "/getrepair1/" + rc1,
          success: function(data) {

            var tempres = JSON.stringify(data);
            var result = JSON.parse(tempres);
            console.log(result[0]);
            console.log(result);
            var len = result.length;
            var col = '';
            var currenttype;
            var currentnum = 1;
            if (len > 0) {
              col += '<div class="form-group row col-md-12 divrepcode" >';
              col += '<label class="col-md-12 col-form-label text-md-left">Repair code : ' + result[0].repm_code + ' -- ' + result[0].repm_desc + '</label>';
              // col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
              col += '</div>';

              col += '<div class="table-responsive col-12">';
              col += '<table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
              col += '<thead>';
              col += '<tr style="text-align: center;style="border:2px solid"">';
              col += '<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:25%"><p style="height:100%">Instruksi</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col += '<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Do</p></th>';
              col += '<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
              col += '</tr>';
              col += '<tr style="text-align: center;">';
              col += '<th style="border:2px solid; width:10%;">Done</th>';
              col += '<th style="border:2px solid; width:10%;">Not Done</th>';
              col += '<th style="border:2px solid; width:10%;">OK</th>';
              col += '<th style="border:2px solid; width:10%;">Not OK</th>';
              col += '</tr>';
              col += '</thead>';
              col += '<tbody style="border:2px solid" >';

              for (i = 0; i < len; i++) {

                // alert(result[i].spm_desc);
                col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + (i + 1) + '</b></p></td>';
                if (result[i].ins_code == null) {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                  col += '<input type="hidden" name="ins1[]" value="">';
                } else {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].ins_desc + '</b></p></td>';
                  col += '<input type="hidden" name="ins1[]" value="' + result[i].ins_code + '">';
                }
                // if (result[i].spm_desc == null) {
                //   col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                //   col += '<input type="hidden" name="spm1[]" value="">';
                // } else {
                //   col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].spm_desc + '</b></p></td>';
                //   col += '<input type="hidden" name="spm1[]" value="' + result[i].spm_code + '">';
                // }


                if (result[i].ins_check == null) {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                  col += '<input type="hidden" name="std1[]" value="">';
                } else {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].ins_check + '</b></p></td>';
                  col += '<input type="hidden" name="std1[]" value="' + result[i].ins_check + '">';
                }

                col += '<input type="hidden" name="dook1[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="dook1[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';
                col += '<input type="hidden" name="donok11[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="donok11[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';


                col += '<input type="hidden" name="group1[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group1[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';
                col += '<input type="hidden" name="group11[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group11[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><textarea name="note1[' + i + ']" id="note' + i + '" style="border:0;width:100%"></textarea></td>';
                col += '</tr>';
              }
              col += '</tbody>';
              col += '</table>';
              col += '</div>';
              col += '<div class="form-group row col-md-12 divrepcode" >';
              col += '<label for="sparepartnum1" class="col-md-4 col-form-label text-md-left">Repair Code 1 New Instructions </label>';
              col += '<div class="col-md-6">';
              col += '<input id="sparepartnum1" type="number" class="form-control sparepartnum" name="sparepartnum1"  min ="0" max="100">';
              col += '</div>';
              col += '</div>';
              col += '<div class="divspare" id="divspare1">'
              col += '</div>';
              col += '<div class="hr">';
              col += '<hr class="new1">';
              col += '</div>';
              $("#testdiv").append(col);
              col = '';

            }
          }
        })
      }
    })
    $(document).on('change', '#repaircode2', function(event) {
      var rc2 = document.getElementById('repaircode2').value;
      $("#testdiv2").html('');
      if (rc2 != '') {
        $.ajax({
          url: "/getrepair1/" + rc2,
          success: function(data) {
            var tempres = JSON.stringify(data);
            var result = JSON.parse(tempres);
            var len = result.length;
            var col = '';
            var currenttype;
            var currentnum = 1;
            if (len > 0) {
              col += '<div class="form-group row col-md-12 divrepcode" >';

              col += '<div class="form-group row col-md-12 divrepcode" >';
              col += '<label class="col-md-12 col-form-label text-md-left">Repair code : ' + result[0].repm_code + ' -- ' + result[0].repm_desc + '</label>';
              // col +='<label class="col-md-5 col-form-label text-md-left">Instruction :</label>';
              col += '</div>';
              col += '<div class="table-responsive col-12">';
              col += '<table class="table table-borderless mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">';
              col += '<thead>';
              col += '<tr style="text-align: center;style="border:2px solid"">';
              col += '<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">No</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Instruksi</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:10%"><p style="height:100%">Sparepart</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Standard</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Qty</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:5%"><p style="height:100%">Hour(s)</p></th>';
              col += '<th colspan="2" style="border:2px solid;width:15%"><p style="height:50%">Result</p></th>';
              col += '<th rowspan="2" style="border:2px solid;width:20%"><p style="height:100%">Note</p></th>';
              col += '</tr>';
              col += '<tr style="text-align: center;">';
              col += '<th style="border:2px solid">OK</th>';
              col += '<th style="border:2px solid">F.U.</th>';
              col += '</tr>';
              col += '</thead>';
              col += '<tbody style="border:2px solid" >';

              for (i = 0; i < len; i++) {
                col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + (i + 1) + '</b></p></td>';

                if (result[i].ins_code == null) {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                  col += '<input type="hidden" name="ins2[]" value="">';
                } else {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].ins_desc + '</b></p></td>';
                  col += '<input type="hidden" name="ins2[]" value="' + result[i].ins_code + '">';
                }
                if (result[i].spm_desc == null) {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                  col += '<input type="hidden" name="spm2[]" value="">';
                } else {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].spm_desc + '</b></p></td>';
                  col += '<input type="hidden" name="spm2[]" value="' + result[i].spm_code + '">';
                }


                if (result[i].ins_check == null) {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>-</b></p></td>';
                  col += '<input type="hidden" name="std2[]" value="">';
                } else {
                  col += '<td style="margin-top:0;height:40px;border:2px solid"><p style="margin:0px;"><b>' + result[i].ins_check + '</b></p></td>';
                  col += '<input type="hidden" name="std2[]" value="' + result[i].ins_check + '">';
                }
                col += '<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="qty2[]" min=0 value=1 style="border:0px;width:100%;height:100%"></td>';
                col += '<td style="margin-top:0;height:40px;border:2px solid"><input type="number" name="rph2[]" min=1 value=1 step="0.1" style="border:0px;width:100%;height:100%"></td>';

                col += '<input type="hidden" name="group2[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group2[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';
                col += '<input type="hidden" name="group21[' + i + ']" value="n' + i + '">';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><input type="checkbox" name="group21[' + i + ']" id="item' + i + '" value="y' + i + '"></td>';
                col += '<td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid"><textarea name="note2[' + i + ']" id="note' + i + '" style="border:0;width:100%"></textarea></td>';
                col += '</tr>';
              }
              col += '</tbody>';
              col += '</table>';
              col += '</div>';
              col += '<div class="form-group row col-md-12 divrepcode" >';
              col += '<label for="sparepartnum2" class="col-md-4 col-form-label text-md-left">Repair Code 2 New Instructions </label>';
              col += '<div class="col-md-6">';
              col += '<input id="sparepartnum2" type="number" class="form-control sparepartnum" name="sparepartnum2"  min ="0" max="100">';
              col += '</div>';
              col += '</div>';
              col += '<div class="divspare" id="divspare2">'
              col += '</div>';
              col += '<div class="hr">';
              col += '<hr class="new1">';
              col += '</div>';
              $("#testdiv2").append(col);
              col = '';

            }
          }
        })
      }
    })



    $(document).on('click', '.aprint', function(event) {
      var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
      var url = "{{url('openprint2','id')}}";
      // var newo = JSON.stringify(wonbr);
      url = url.replace('id', wonbr);
      // alert(url);
      window.open(url, '_blank')
      // document.getElementsByClassName('aprint').href=url;
      // alert('aa');
    });

    function uploadImage() {
      var button = $('.images .pic')
      var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
      var images = $('.images')
      var potoArr = [];
      var initest = $('.images .img span #imgname')

      button.on('click', function() {
        // alert('aaa');
        uploader.click();
      })

      uploader.on('change', function() {
        var reader = new FileReader();
        i = 0;
        reader.onload = function(event) {
          images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="' + event.target.result + '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
          // alert(JSON.stringify(uploader));
          document.getElementById('imgname').value = uploader[0].files.item(0).name + ',' + event.target.result;
          document.getElementById('hidden_var').value = 1;
        }
        reader.readAsDataURL(uploader[0].files[0])
        // potoArr.push(uploader[0].files[0]);

        // console.log(potoArr);
      })


      images.on('click', '.img', function() {
        $(this).remove();
      })

      // confirmPhoto(potoArr);
    }



    $(document).ready(function() {
      // submit();
      $('#file-input').on('change', function() { //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {

          var data = $(this)[0].files; //this file data
          // console.log(data);
          $.each(data, function(index, file) { //loop though each file
            if (/(\.|\/)(jpe?g|png)$/i.test(file.type)) { //check supported file type
              var fRead = new FileReader(); //new filereader
              fRead.onload = (function(file) { //trigger function on successful read
                return function(e) {
                  var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                  $('#thumb-output').append(img); //append image to output element
                };
              })(file);
              fRead.readAsDataURL(file); //URL representing the file's data.
            }
          });

          $("#thumb-output").on('click', '.thumb', function() {
            $(this).remove();
          })

        } else {
          // alert("Your browser doesn't support File API!");
          swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "Your browser doesn't support File API!",
            toast: true,
            showConfirmButton: false,
            timer: 2000,
          }) //if File API is absent
        }
      });
    });

    function resetSearch() {
        $('#s_nomorwo').val('');
        $('#s_asset').val('');
        $('#s_priority').val('');
    }

    $(document).on('click', '#btnrefresh', function() {
        resetSearch();
    });
  </script>
  @endsection