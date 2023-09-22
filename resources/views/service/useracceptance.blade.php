@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9">
      <h1 class="m-0 text-dark">User Acceptance</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan pengecekan Service Request yang sudah selesai dikerjakan</p>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<style>
  /* img {
  width: 25%;
  margin: 10px;
  cursor: pointer;
} */

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

<!-- Daftar perubahan :

A210927 : status approval user acceptance, jika reject statusnya incomplete, jadi dibedakan status close dan reject. kode status reject = 6 
A2110114 : menampilkan data detail SR dan WO sebelum user accept
-->


<!-- modal picking warehouse -->
<!-- <input type="hidden" id="sessionusernow" name="sessionusernow" value="{{Session::get('username')}}"> -->
<!-- <form action="/useracceptance/search" method="GET"> -->
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

          <!--FORM Search Disini-->
          <label for="s_nomorsr" class="col-md-3 col-form-label text-md-left">{{ __('SR Number') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <input id="s_nomorsr" type="text" class="form-control" name="s_nomorsr" value="" autofocus autocomplete="off" placeholder="Search SR Number">
          </div>
          <label for="s_nomorwo" class="col-md-2 col-form-label text-md-right">{{ __('WO Number') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <input id="s_nomorwo" type="text" class="form-control" name="s_nomorwo" value="" autofocus autocomplete="off" placeholder="Search WO Number">
          </div>
          <label for="s_status" class="col-md-2 col-form-label text-md-right" style="display: none;">{{ __('Status') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group" style="display: none;">
            <select id="s_status" type="text" class="form-control" name="s_status">
              <option value="">--Select Status--</option>
              <option value="waiting for acceptance">acceptance</option>
              <option value="acceptance approved">closed</option>
              <option value="acceptance revision">revision</option>
            </select>
          </div>
          <div class="col-md-1"></div>
          <label for="s_datefrom" class="col-md-3 col-form-label text-md-left">{{ __('Needed Date From') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <input id="s_datefrom" type="date" class="form-control" name="s_datefrom" value="" autofocus autocomplete="off">
          </div>
          <label for="s_daeto" class="col-md-2 col-form-label text-md-right">{{ __('Needed Date To') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <input id="s_dateto" type="date" class="form-control" name="s_dateto" value="" autofocus autocomplete="off">
          </div>
          <div class="col-md-1"></div>
          <label for="s_asset" class="col-md-3 col-form-label text-md-left">{{ __('Asset') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <input id="s_asset" type="text" class="form-control" name="s_asset" value="" autofocus autocomplete="off" placeholder="Search Asset">
          </div>
          <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" id="btnsearch" style="float:right" />Search</button>
          </div>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="tmpsrnumber" />
  <input type="hidden" id="tmpwonumber" />
  <input type="hidden" id="tmpasset" />
  <input type="hidden" id="tmpstatus" />
  <input type="hidden" id="tmpdatefrom" />
  <input type="hidden" id="tmpdateto" />
<!-- </form> -->

<div class="table-responsive col-12">
  <table class="table table-bordered mt-4 no-footer mini-table" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="so_nbr" width="8%">SR Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust" width="8%">WO Number<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="so_cust" width="30%">Asset<span id="username_icon"></span></th>
        <!-- <th class="sorting" data-sorting_type="asc" data-column_name="so_cust"  width="10%">Status<span id="username_icon"></span></th> -->
        <th width="5%">Status</th>
        <th width="5%">Priority</th>
        <th width="8%">Requested Date</th>
        <th width="5%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('service.table-ua')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>
<!-- Flash Menu -->

<!-- Modal SR View -->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">User Acceptance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="approval" method="post" action="/acceptance" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <input type="hidden" id="hiddenreq" name="hiddenreq" />
          <div class="form-group row">
            <label for="srnumber" class="col-md-2 col-form-label">SR Number</label>
            <div class="col-md-4">
              <input id="srnumber" type="text" class="form-control" name="srnumber" readonly />
            </div>
            <label for="assetcode" class="col-md-2 col-form-label">Asset Code</label>
            <div class="col-md-4">
              <input id="assetcode" type="text" class="form-control" name="assetcode" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label for="wonumber" class="col-md-2 col-form-label">WO Number</label>
            <div class="col-md-4">
              <input id="wonumber" type="text" class="form-control" name="wonumber" readonly />
            </div>
            <label for="assetdesc" class="col-md-2 col-form-label">Asset Desc</label>
            <div class="col-md-4">
              <textarea id="assetdesc" type="text" class="form-control" name="assetdesc" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="dept" class="col-md-2 col-form-label">Department</label>
            <div class="col-md-4">
              <input id="dept" type="text" class="form-control" name="dept" readonly />
            </div>
            <label for="assetloc" class="col-md-2 col-form-label">Asset Location</label>
            <div class="col-md-4">
              <input id="assetloc" type="text" class="form-control" name="assetloc" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label for="reqbyname" class="col-md-2 col-form-label">Requested by</label>
            <div class="col-md-4">
              <input id="reqbyname" name="reqbyname" type="text" class="form-control" readonly />
            </div>
            <label for="failtype" class="col-md-2 col-form-label">Failure Type</label>
            <div class="col-md-4">
              <input id="failtype" type="text" class="form-control" name="failtype" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label for="srnote" class="col-md-2 col-form-label">SR Note</label>
            <div class="col-md-4">
              <textarea id="srnote" type="text" class="form-control" name="srnote" rows="3" readonly></textarea>
            </div>
            <label for="sr_failcode" class="col-md-2 col-form-label">Failure Code</label>
            <div class="col-md-4">
              <textarea id="sr_failcode" type="text" class="form-control" name="sr_failcode" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="wostatus" class="col-md-2 col-form-label">SR Status</label>
            <div class="col-md-4">
              <input id="wostatus" type="text" class="form-control" name="wostatus" style="font-weight: bold;" readonly />
            </div>
            <label for="sr_impact" class="col-md-2 col-form-label">Impact</label>
            <div class="col-md-4">
              <textarea id="sr_impact" type="text" class="form-control" name="sr_impact" autocomplete="off" rows="3" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="approver" class="col-md-2 col-form-label">Engineer Approver</label>
            <div class="col-md-4">
              <input id="approver" type="text" class="form-control" name="approver" readonly />
            </div>
            <label for="priority" class="col-md-2 col-form-label">Priority</label>
            <div class="col-md-4">
              <input id="priority" type="text" class="form-control" name="priority" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="startwo" class="col-md-2 col-form-label">WO Start Date</label>
            <div class="col-md-4">
              <input id="startwo" readonly type="text" class="form-control" name="startwo">
            </div>
            <label for="srdate" class="col-md-2 col-form-label">Request Date</label>
            <div class="col-md-4">
              <input id="srdate" type="text" class="form-control" name="srdate" autocomplete="off" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label for="endwo" class="col-md-2 col-form-label">WO Finish Date</label>
            <div class="col-md-4">
              <input id="endwo" type="text" class="form-control" name="endwo" readonly>
            </div>
            <label for="srtime" class="col-md-2 col-form-label">Request Time</label>
            <div class="col-md-4">
              <input id="srtime" type="text" class="form-control" name="srtime" autocomplete="off" readonly />
            </div>
          </div>
          <div class="form-group row">
            <label for="englist" class="col-md-2 col-form-label">Engineer List</label>
            <div class="col-md-4">
              <textarea id="englist" type="text" class="form-control" name="englist" rows="3" readonly></textarea>
            </div>
            <label for="file" class="col-md-2 col-form-label">Current File</label>
            <div class="col-md-4">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Name</th>
                  </tr>
                </thead>
                <tbody id="srlistupload">

                </tbody>
              </table>
            </div>
            <!-- <label for="rejectnote" class="col-md-2 col-form-label">Reject Note</label>
          <div class="col-md-4">
            <textarea id="rejectnote" type="text" class="form-control" name="rejectnote" readonly></textarea>
          </div> -->
          </div>
          <div class="form-group row">
            <label for="woreportnote" class="col-md-2 col-form-label">WO Reporting Note</label>
            <div class="col-md-10">
              <textarea id="woreportnote" type="text" class="form-control" name="woreportnote" rows="3" readonly></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="sracceptance" class="col-md-2 col-form-label">Acceptance Reason</label>
            <div class="col-md-10">
              <textarea id="sracceptance" type="text" class="form-control" name="sracceptance" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" name="action" value="incomplete" id="btnreject">Reject</button>
            <button type="submit" class="btn btn-success" name="action" value="complete" id="btnapprove">Approve</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection


@section('scripts')
<script type="text/javascript">
  $("#acceptance").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });

  $(document).on('click', '.view', function() {

    $('#viewModal').modal('show');

    var srnumber = $(this).data('srnumber');
    var assetcode = $(this).data('assetcode');
    var assetdesc = $(this).data('assetdesc');
    var dept = $(this).data('dept');
    var assetloc = $(this).data('assetloc');
    var astype = $(this).data('astypedesc');
    var srnote = $(this).data('srnote');
    var reqby = $(this).data('reqby');
    var priority = $(this).data('priority');
    var rejectnote = $(this).data('rejectnote');
    var reqbyname = $(this).data('reqbyname');
    var wotype = $(this).data('wotypedesc');
    var impact = $(this).data('impactcode');
    var wonumber = $(this).data('wonumber');
    var startwo = $(this).data('startwo');
    var endwo = $(this).data('endwo');
    var action = $(this).data('action');
    var wostatus = $(this).data('wostatus');
    var statusapproval = $(this).data('statusapproval');
    var failtype = $(this).data('failtype');
    var failcode = $(this).data('failcode');
    var approver = $(this).data('approver');
    var reason = $(this).data('reason');
    var engineer = $(this).data('engineer');
    var reportnote = $(this).data('reportnote');

    var srdate = $(this).data('srdate');
    document.getElementById('srdate').value = srdate;
    var srtime = $(this).data('srtime');
    document.getElementById('srtime').value = srtime;

    var eng1 = $(this).data('eng1');
    var eng2 = $(this).data('eng2');
    var eng3 = $(this).data('eng3');
    var eng4 = $(this).data('eng4');
    var eng5 = $(this).data('eng5');

    var englist = eng1 + '\n' + eng2 + '\n' + eng3 + '\n' + eng4 + '\n' + eng5;

    var fail1 = $(this).data('faildesc1');
    var fail2 = $(this).data('faildesc2');
    var fail3 = $(this).data('faildesc3');

    var faildesclist = fail1 + '\n' + fail2 + '\n' + fail3;

    // console.log(englist);

    var eng = engineer.replaceAll(";", "\n");

    document.getElementById('englist').value = eng;
    document.getElementById('reqbyname').value = reqby;
    document.getElementById('srnote').value = srnote;
    document.getElementById('wonumber').value = wonumber;
    if (startwo != '01-01-1970') {
      document.getElementById('startwo').value = startwo;
    } else {
      document.getElementById('startwo').value = '';
    }
    if (endwo != '01-01-1970') {
      document.getElementById('endwo').value = endwo;
    } else {
      document.getElementById('endwo').value = '';
    }
    document.getElementById('wostatus').value = wostatus;
    document.getElementById('approver').value = approver;
    document.getElementById('woreportnote').value = reportnote;

    if (wostatus == 'Open') {
      document.getElementById("wostatus").style.color = 'green';
    } else if (wostatus == 'Inprocess') {
      document.getElementById("wostatus").style.color = 'orange';
    } else if (wostatus == 'Revise') {
      document.getElementById("wostatus").style.color = 'red';
    } else {
      document.getElementById("wostatus").style.color = 'black';
    }

    $.ajax({
      url: "/searchimpactdesc",
      data: {
        impact: impact,
      },
      success: function(data) {
        // console.log(data);

        var imp_desc = data;
        var imp_code = impact;
        var delimiter = ",";

        var desc = imp_desc.split(delimiter);
        var coded = imp_code.split(delimiter);

        let results = "";

        for (let i = 0; i < Math.min(desc.length, coded.length); i++) {
          results += coded[i] + ' -- ' + desc[i] + '\n';
        }

        document.getElementById('sr_impact').value = results;
        // }

      },
      statusCode: {
        500: function() {
          document.getElementById('sr_impact').value = "";
        }
      }
    })

    $.ajax({
      url: "/searchfailcode",
      data: {
        failcode: failcode,
      },
      success: function(data) {
        // console.log(data);

        var fail_desc = data;
        var fail_code = failcode;
        var delimiter = ",";

        var desc = fail_desc.split(delimiter);
        var coded = fail_code.split(delimiter);

        let results = "";

        for (let i = 0; i < Math.min(desc.length, coded.length); i++) {
          results += coded[i] + ' -- ' + desc[i] + '\n';
        }

        document.getElementById('sr_failcode').value = results;

      },
      statusCode: {
        500: function() {
          document.getElementById('sr_failcode').value = "";
        }
      }
    })

    $.ajax({
      url: "/listuploadview/" + srnumber,
      success: function(data) {
        // console.log(data);
        $('#srlistupload').html('').append(data);
      }
    })

    $.ajax({
      url: "/searchfailtype",
      data: {
        failtype: failtype,
      },
      success: function(data) {

        document.getElementById('failtype').value = failtype + ' -- ' + data;
        // }

      },
      statusCode: {
        500: function() {
          document.getElementById('failtype').value = "";
        }
      }
    })


    document.getElementById('srnumber').value = srnumber;
    document.getElementById('assetcode').value = assetcode;
    document.getElementById('assetdesc').value = assetdesc;
    document.getElementById('dept').value = dept;
    document.getElementById('assetloc').value = assetloc;

    document.getElementById('hiddenreq').value = reqby;
    document.getElementById('priority').value = priority;

  });

  $(document).on('click', '#btnreject', function(event) {
    var uncompleted = document.getElementById('uncompletenote').value;

    // event.preventDefault();
    // $('#approval')

    if (uncompleted == "") {
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: "Reason cannot be empty",
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })

      // event.preventDefault();
      // $("#t_photo").attr('required', false);
      $("#uncompletenote").attr('required', true);
      event.preventDefault();
    } else {
      // alert('masuk sini');
      // $("#t_photo").attr('required', false);
      $("#uncompletenote").attr(' ', true);
      $('#acceptance').submit();

    }

  });

  $(document).on('click', '#btnapprove', function(event) {
    // var photo = document.getElementById('t_photo').value;
    // console.log(photo);
    // event.preventDefault();
    // confirmPhoto();
    // var validasi = document.getElementById('hidden_var').value;
    // var validasi2 = document.getElementById('img');


    // if(validasi2 === null){
    //   swal.fire({
    //               position: 'top-end',
    //               icon: 'error',
    //               title: "Please Upload Photo",
    //               toast: true,
    //               showConfirmButton: false,
    //               timer: 2000,
    //   })

    //   event.preventDefault();
    // }else{
    //   $("#rejectreason").attr('required', false);
    //   $('#acceptance').submit();
    // }

    $("#rejectreason").attr('required', false);
    $('#acceptance').submit();
  });

  function uploadImage() {
    var button = $('.images .pic')
    var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
    var images = $('.images')
    var potoArr = [];
    var initest = $('.images .img span #imgname')

    button.on('click', function() {
      uploader.click();
    })

    uploader.on('change', function() {
      var reader = new FileReader();
      i = 0;
      reader.onload = function(event) {
        //tampilakn photo
        images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="' + event.target.result + '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
        // alert(JSON.stringify(uploader));
        document.getElementById('imgname').value = uploader[0].files.item(0).name + ',' + event.target.result;
        // document.getElementById('hidden_var').value = 1;
      }
      reader.readAsDataURL(uploader[0].files[0])
      // potoArr.push(uploader[0].files[0]);

      // console.log(potoArr);
    })


    images.on('click', '.img', function() {
      $(this).remove(); //hapus foto
    })

    // confirmPhoto(potoArr);
  }



  $(document).ready(function() {
    // submit();

    // $("#s_asset").select2({
    //   width: '100%',
    //   placeholder: "Select Asset",
    //   theme: 'bootstrap4',
    // });

    function fetch_data(page, srnumber, wonumber, asset, status, datefrom, dateto) {
      $.ajax({
        url: "/useracceptance/search?page=" + page + "&srnumber=" + srnumber + "&wonumber=" + wonumber + "&asset=" + asset + "&status=" + status + "&datefrom =" + datefrom + "&dateto=" + dateto, 
        success: function(data) {
          // console.log(data);
          $('tbody').html('');
          $('tbody').html(data);
        }
      })
    }


    $(document).on('click', '#btnsearch', function() {
      var srnumber = $('#s_nomorsr').val();
      var wonumber = $('#s_nomorwo').val();
      var asset = $('#s_asset').val();
      var status = $('#s_status').val();
      var datefrom = $('#s_datefrom').val();
      var dateto = $('#s_dateto').val();

      // var column_name = $('#hidden_column_name').val();
      // var sort_type = $('#hidden_sort_type').val();
      var page = 1;

      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpwonumber').value = wonumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpdatefrom').value = datefrom;
      document.getElementById('tmpdateto').value = dateto;


      fetch_data(page, srnumber, wonumber, asset, status, datefrom, dateto);
    });


    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var srnumber = $('#s_nomorsr').val();
      var wonumber = $('#s_nomorwo').val();
      var asset = $('#s_asset').val();
      var status = $('#s_status').val();
      var datefrom = $('#s_datefrom').val();
      var dateto = $('#s_dateto').val();

      fetch_data(page, srnumber, wonumber, asset, status, datefrom, dateto);
    });

    $(document).on('click', '#btnrefresh', function() {
      var srnumber = '';
      var wonumber = '';
      var asset = '';
      var status = '';
      var datefrom = '';
      var dateto = '';
      var page = 1;

      document.getElementById('s_nomorsr').value = ''; 
      document.getElementById('s_nomorwo').value = ''; 
      document.getElementById('s_asset').value = '';
      document.getElementById('s_status').value = '';
      document.getElementById('s_datefrom').value = '';
      document.getElementById('s_dateto').value = '';

      document.getElementById('tmpsrnumber').value = srnumber;
      document.getElementById('tmpwonumber').value = wonumber;
      document.getElementById('tmpasset').value = asset;
      document.getElementById('tmpstatus').value = status;
      document.getElementById('tmpdatefrom').value = datefrom;
      document.getElementById('tmpdateto').value = dateto;


      fetch_data(page, srnumber, wonumber, asset, status, datefrom, dateto);

      // $("#s_asset").select2({
      //   width: '100%',
      //   placeholder: "Select Asset",
      //   theme: 'bootstrap4',
      //   asset,
      // });
    });



    // $('#file-input').on('change', function(){ //on file input change
    //   if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    //   {

    //       var data = $(this)[0].files; //this file data
    //       console.log(data);
    //       $.each(data, function(index, file){ //loop though each file
    //           if(/(\.|\/)(jpe?g|png)$/i.test(file.type)){ //check supported file type
    //               var fRead = new FileReader(); //new filereader
    //               fRead.onload = (function(file){ //trigger function on successful read
    //               return function(e) {
    //                   var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
    //                   $('#thumb-output').append(img); //append image to output element
    //               };
    //               })(file);
    //               fRead.readAsDataURL(file); //URL representing the file's data.
    //           }
    //       });

    //       $("#thumb-output").on('click', '.thumb', function () {
    //         $(this).remove();
    //       })

    //   }else{
    //       // alert("Your browser doesn't support File API!");
    //       swal.fire({
    //                     position: 'top-end',
    //                     icon: 'error',
    //                     title: "Your browser doesn't support File API!",
    //                     toast: true,
    //                     showConfirmButton: false,
    //                     timer: 2000,
    //       }) //if File API is absent
    //   }
    // });
  });
</script>
@endsection