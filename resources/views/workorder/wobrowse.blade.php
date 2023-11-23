@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-9">
      <h1 class="m-0 text-dark">Work Order Maintenance</h1>
      <p class="pb-0 m-0">Menu ini berfungsi untuk melakukan create, edit, view dan cancel Work Order</p>
    </div><!-- /.col -->
    <div class="col-sm-3">
      <button class="btn btn-block btn-primary createnewwo" data-toggle="modal" data-target="#createModal">
        Create WO</button>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<style>
  /*div #munculgambar .gambar{
  margin: 5px;
  border: 2px solid grey;
  border-radius: 5px;
}

div #munculgambar .gambar:hover{
  border: 2px solid red;
  border-radius: 5px;
}*/
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

  select[readonly].select2-hidden-accessible+.select2-container {
    pointer-events: none;
    touch-action: none;
  }

  select[readonly].select2-hidden-accessible+.select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
  }

  select[readonly].select2-hidden-accessible+.select2-container .select2-selection__arrow,
  select[readonly].select2-hidden-accessible+.select2-container .select2-selection__clear {
    display: none;
  }
</style>
<!--Table Menu-->

<!--
  Daftar Perubahan :
  A211019 : jika status reviewer Incomplete, maka tidak akan merubah status apapun di SR. Reviewer dapat melakukan complete WO ulang
  A211022 : file yang diupload bukan hanya berupa gambar
  A211101 : perubahan nama status incomplete menjadi reprocess pada approval spv
-->

<!-- <hr style="margin:0%"> -->
<div class="container-fluid mb-2">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-block bg-black rounded-0" data-toggle="collapse" data-target="#collapseExample">Click Here To Search</button>
    </div>
  </div>
  <!-- Element div yang akan collapse atau expand -->
  <div class="collapse" id="collapseExample">
    <form action="{{route('womaint')}}" method="get">
      <!-- Isi element div dengan konten yang ingin ditampilkan saat collapse diaktifkan -->
      <div class="card card-body bg-black rounded-0">
        <div class="col-12 form-group row">

          <!--FORM Search Disini-->
          <label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Number') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <input id="s_nomorwo" type="text" class="form-control" name="s_nomorwo" value="{{ request()->input('s_nomorwo') }}" autofocus autocomplete="off">
          </div>
          <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
              <option value="">--Select Asset--</option>
              @foreach ( $asset1 as $assetsearch )
              <option value="{{$assetsearch->asset_code}}">{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="s_status" class="col-md-2 col-form-label text-md-left">{{ __('Work Order Status') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <select id="s_status" type="text" class="form-control" name="s_status">
              <option value="">--Select Status--</option>
              <!-- <option value="plan">Plan</option> -->
              <option value="firm">Firm</option>
              <option value="released">Released</option>
              <option value="started">Started</option>
              <option value="finished">Finished</option>
              <option value="closed">Closed</option>
              <option value="canceled">Canceled</option>
              <option value="acceptance">Acceptance</option>
            </select>
          </div>
          <label for="" class="col-md-1 col-form-label text-md-left">{{ __('') }}</label>
          <label for="s_wotype" class="col-md-2 col-form-label text-md-right">{{ __('WO Type') }}</label>
          <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_wotype" type="text" class="form-control" name="s_wotype">
              <option value="">--Select Priority--</option>
              <option value="PM">Preventive Maintenance</option>
              <option value="CM">Corrective Maintenance</option>
            </select>
          </div>
          <label for="s_engineer" class="col-md-2 col-form-label text-md-left">{{ __('Engineer') }}</label>
          <div class="col-md-3 col-sm-12 mb-2 input-group">
            <select id="s_engineer" type="text" class="form-control" name="s_engineer">
              <option value="">--Select Engineer--</option>
              @foreach ( $user as $engineersearch )
              <option value="{{$engineersearch->eng_code}}">{{$engineersearch->eng_code}} -- {{$engineersearch->eng_desc}}</option>
              @endforeach
            </select>
          </div>
          <label for="" class="col-md-3 col-form-label text-md-right">{{ __('') }}</label>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" id="btnsearch" style="float:right">Search</button>
          </div>
          <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<input type="hidden" id="tmpwo" value="" />
<input type="hidden" id="tmpasset" value="" />
@if($fromhome == 'open')
<input type="hidden" id="tmpstatus" value="open" />
@else
<input type="hidden" id="tmpstatus" value="" />
@endif
<input type="hidden" id="tmppriority" value="" />
<input type="hidden" id="tmpengineer" value="" />

<div class="table-responsive col-lg-12 col-md-12 mt-4 tag-container" style="overflow-x: auto;overflow-y: hidden ;display: inline-block;white-space: nowrap; position:relative;">
  <table class="table table-bordered mt-0" id="dataTable" cellspacing="0">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_nbr" width="20%">WO Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_sr_number" width="20%">SR Number<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="25%">Asset<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_asset" width="50%">Desc<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_schedule" width="7%">Start Date<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_duedate" width="7%">Due Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_status" width="7%">Status<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_priority" width="7%">Type</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_created_at" width="7%">Req Date<span id="username_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="wo_creator" width="7%">Requested by</th>
        <th width="15%">Action</th>
      </tr>
    </thead>
    <tbody>
      @include('workorder.table-wobrowse')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="wo_created_at" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!--Modal Create-->
<div class="modal fade" id="createModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Create Work Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="new" method="post" action="createwo" autocomplete="off" enctype="multipart/form-data">
          {{ csrf_field()}}
          <div class="form-group row col-md-12">
            <label for="assetloc" class="col-md-5 col-form-label my-auto">Asset Location <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7 col-sm-12">
              <select id="assetloc" name="assetloc" class="form-control" required>
                <option value="">-- Select Asset Location--</option>
                @foreach($assetloc as $show)
                <option value="{{$show->asloc_code}}">{{$show->asloc_code.' -- '.$show->asloc_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="c_asset" class="col-md-5 col-form-label text-md-left">Asset<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="c_asset" type="text" class="form-control c_asset" name="c_asset" autofocus required>
                <option value="">--Select Asset--</option>
              </select>
            </div>
          </div>

          <input type="hidden" id="hide_site" name="hide_site" />
          <input type="hidden" id="hide_loc" name="hide_loc" />
          <input type="hidden" id="hide_assetgroup" />

          <div class="form-group row col-md-12" id="cdevwotype">
            <label for="cwotype" class="col-md-5 col-form-label text-md-left">WO Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7" style="vertical-align:middle;">
              <div class="row">
                <div class="col-md-12">
                  <input class=" d-inline" type="radio" name="cwotype" id="cpreventive" value="PM" required>
                  <label class="form-check-label" for="cpreventive" style="font-size:15px">
                    Preventive Maintenance
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input class="d-inline" type="radio" name="cwotype" id="cwomanual" value="CM">
                  <label class="form-check-label" for="cwomanual" style="font-size:15px">
                    Corrective Maintenance
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row col-md-12 ftypediv" id="ftypediv">
            <label for="c_failuretype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
            <div class="col-md-7 col-sm-12">
              <select class="form-control" id="c_failuretype" name="c_failuretype">
                <option></option>
                @foreach($wottype as $wotypeshow)
                <option value="{{$wotypeshow->wotyp_code}}">{{$wotypeshow->wotyp_code}} -- {{$wotypeshow->wotyp_desc}}</option>
                @endforeach
              </select>
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12 fcodediv" id="fcodediv">
            <label for="failurecode" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7 col-sm-12">
              <select class="form-control" id="failurecode" name="failurecode[]" multiple="multiple">
                <option></option>
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12 c_impactdiv" id="c_impactdiv">
            <label for="c_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <select id="c_impact" class="form-control c_impact" name="c_impact[]" multiple="multiple" autofocus>
                <!-- <option value="" selected>Select Impact</option> -->
                @foreach($impact as $c_impact)
                <option value="{{$c_impact->imp_code}}">{{$c_impact->imp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <input type="hidden" id="crepairtypeedit" name="crepairtypeedit" value=''>
          <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_listengineer" class="col-md-5 col-form-label text-md-left">Engineer List <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="c_listengineer" type="text" class="form-control c_listengineer" name="c_listengineer[]" autofocus required multiple="multiple">
                @foreach($user as $user2)
                <option value="{{$user2->eng_code}}">{{$user2->eng_code}} -- {{$user2->eng_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- <div id="testdiv">

          </div> -->

          <div class="form-group row col-md-12">
            <label for="c_startdate" class="col-md-5 col-form-label text-md-left">Start Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input type="date" id="c_startdate" class="form-control" name="c_startdate" value="{{ old('c_startdate') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input type="date" id="c_duedate" class="form-control" name="c_duedate" value="{{ old('duedate') }}" autocomplete="off" maxlength="24" autofocus required>
            </div>
          </div>
          <!-- <div class="form-group row col-md-12 c_departmentdiv">
            <label for="c_department" class="col-md-5 col-form-label text-md-left">Department</label>
            <div class="col-md-7">
              <select id="c_department"  class="form-control c_department" name="c_department"  autofocus required>
              <option value="" disabled selected>Select Department</option>
                @foreach ($dept as $cdept)
                <option value="{{$cdept->dept_code}}">{{$cdept->dept_desc}}</option>
                @endforeach
              </select>
            </div>
          </div> -->
          <div class="form-group row col-md-12">
            <label for="c_priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="c_priority" class="form-control" name="c_priority" autocomplete="off" autofocus required>
                <option value='' disabled selected>--select priority--</option>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
              <textarea id="c_note" class="form-control c_note" name="c_note" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_mtcode" class="col-md-5 col-form-label text-md-left">Maintenance Code</label>
            <div class="col-md-7">
              <select id="c_mtcode" name="c_mtcode" class="form-control">
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_inslist" class="col-md-5 col-form-label text-md-left">Instruction List</label>
            <div class="col-md-7">
              <select id="c_inslist" name="c_inslist" class="form-control">
                <option></option>
                @foreach ($inslist as $ins)
                <option value="{{$ins->ins_code}}">{{$ins->ins_code}} -- {{$ins->ins_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_splist" class="col-md-5 col-form-label text-md-left">Instruction Spare Part</label>
            <div class="col-md-7">
              <select id="c_splist" name="c_splist" class="form-control">
                <option></option>
                @foreach ($splist as $sp)
                <option value="{{$sp->spg_code}}">{{$sp->spg_code}} -- {{$sp->spg_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12">
            <label for="c_qclist" class="col-md-5 col-form-label text-md-left">Instruction QC</label>
            <div class="col-md-7">
              <select id="c_qclist" name="c_qclist" class="form-control">
                <option></option>
                @foreach ($qclist as $qc)
                <option value="{{$qc->qcs_code}}">{{$qc->qcs_code}} -- {{$qc->qcs_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row col-md-12" id="photodiv">
            <label for="c_uploadfile" class="col-md-5 col-form-label text-md-left">Upload File</label>
            <div class="col-md-7">
              <input type="file" class="form-control" id="c_uploadfile" name="c_uploadfile[]" multiple>
            </div>
          </div>
      </div>
      <!-- </div> -->
      <div class="modal-footer">
        <div class="container">
          <div class="row">
            <div class="col-4 pl-0">
              <button type="button" class="btn btn-dark maintcode" style="float:left"><b style="font-size: 13px;color:white">Maintenance Code</b></button>
            </div>
            <div class="col-8 text-right">
              <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
              <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
              </button>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!--Modal Edit-->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Modify</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="newedit" method="post" action="editwo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="counter" value=0>
        <input type="hidden" id="counterfail" value=0>
        <input type="hidden" id="repairtypeedit">
        <div class="modal-body">
          <div class="form-group row justify-content-center">
            <label for="e_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="e_nowo" type="text" class="form-control" name="e_nowo" autocomplete="off" maxlength="6" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_nosr" class="col-md-5 col-form-label text-md-left">Service Request Number</label>
            <div class="col-md-7">
              <input id="e_nosr" type="text" class="form-control" name="e_nosr" readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_engineerlist" class="col-md-5 col-form-label text-md-left">Engineer List<span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_engineerlist" class="form-control e_engineerlist" name="e_engineerlist[]" multiple required>
                <!-- <option value="" disabled>--select data--</option> -->
                @foreach ($engine as $engine1)
                <option value="{{$engine1->eng_code}}">{{$engine1->eng_code}} - {{$engine1->eng_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input id="e_asset" type="text" class="form-control e_asset" readonly>
              <input id="e_assetcode" type="hidden" class="form-control e_assetcode" name="e_assetcode" readonly>

            </div>
          </div>
          <div class="form-group row justify-content-center e_wottypediv" id="e_wottypediv">
            <label for="e_wottype" class="col-md-5 col-form-label text-md-left">Failure Type</label>
            <div class="col-md-7">
              <select name="e_wottype" class="form-control" id="e_wottype" autofocus>
                <option></option>
                @foreach($wottype as $wotypeshow)
                <option value="{{$wotypeshow->wotyp_code}}">{{$wotypeshow->wotyp_code}} -- {{$wotypeshow->wotyp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="m_failurecode" class="col-md-5 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-7 col-sm-12">
              <select class="form-control m_failurecode" id="m_failurecode" name="m_failurecode[]" multiple autofocus>
              </select>
            </div>
          </div>

          <input type="hidden" id="hide_editassetgroup" />
          <div class="form-group row justify-content-center e_impactdiv" id="e_impactdiv">
            <label for="e_impact" class="col-md-5 col-form-label text-md-left">Impact</label>
            <div class="col-md-7">
              <select id="e_impact" class="form-control e_impact" name="e_impact[]" multiple="multiple" autofocus>
                @foreach($impact as $e_impact)
                <option value="{{$e_impact->imp_code}}">{{$e_impact->imp_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_startdate" class="col-md-5 col-form-label text-md-left">Start Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="e_startdate" type="date" class="form-control" name="e_startdate" value="{{ old('e_startdate') }}" autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_duedate" class="col-md-5 col-form-label text-md-left">Due Date <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <input id="e_duedate" type="date" class="form-control" name="e_duedate" value="{{ old('e_duedate') }}" autofocus required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_priority" class="col-md-5 col-form-label text-md-left">Priority <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <select id="e_priority" class="form-control" name="e_priority" autofocus required>
                <option value='low'>Low</option>
                <option value='medium'>Medium</option>
                <option value='high'>High</option>
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
              <textarea id="e_note" class="form-control e_note" name="e_note" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_mtcode" class="col-md-5 col-form-label text-md-left">Maintenance Code</label>
            <div class="col-md-7">
              <select id="e_mtcode" name="e_mtcode" class="form-control">
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_inslist" class="col-md-5 col-form-label text-md-left">Instruction List</label>
            <div class="col-md-7">
              <select id="e_inslist" name="e_inslist" class="form-control">
                <option></option>
                @foreach ($inslist as $ins)
                <option value="{{$ins->ins_code}}">{{$ins->ins_code}} -- {{$ins->ins_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_splist" class="col-md-5 col-form-label text-md-left">Instruction Spare Part</label>
            <div class="col-md-7">
              <select id="e_splist" name="e_splist" class="form-control">
                <option></option>
                @foreach ($splist as $sp)
                <option value="{{$sp->spg_code}}">{{$sp->spg_code}} -- {{$sp->spg_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="e_qclist" class="col-md-5 col-form-label text-md-left">Instruction QC</label>
            <div class="col-md-7">
              <select id="e_qclist" name="e_qclist" class="form-control">
                <option></option>
                @foreach ($qclist as $qc)
                <option value="{{$qc->qcs_code}}">{{$qc->qcs_code}} -- {{$qc->qcs_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="photodiv">
            <label class="col-md-5 col-form-label text-md-left">Uploaded File</label>
            <div class="col-md-7" style="overflow-x: auto;">
              <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="munculgambar_edit">
              </table>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="photodiv">
            <label for="e_uploadfile" class="col-md-5 col-form-label text-md-left">Upload File</label>
            <div class="col-md-7">
              <input type="file" class="form-control" id="e_uploadfile" name="e_uploadfile[]" multiple>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container">
            <div class="row">
              <div class="col-4 pl-0">
                <button type="button" class="btn btn-dark maintcode" style="float:left"><b style="font-size: 13px;color:white">Maintenance Code</b></button>
              </div>
              <div class="col-8 text-right">
                <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success bt-action" id="e_btnconf">Save</button>
                <button type="button" class="btn btn-block btn-info" id="e_btnloading" style="display:none">
                  <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>
    </form>
  </div>
</div>

<!--Modal Approve-->
<div class="modal fade" id="approveModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Approval</h5>
        <button type="button" class="close" id='closeapprove' data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="a_counter">
      <div class="modal-body">
        <div class="form-group row justify-content-center">
          <label for="a_nowo" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
          <div class="col-md-7">
            <input id="a_nowo" type="text" class="form-control" name="a_nowo" autocomplete="off" readonly autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_nosr" class="col-md-5 col-form-label text-md-left">SR Number</label>
          <div class="col-md-7">
            <input id="a_nosr" type="text" class="form-control" name="a_nosr" readonly autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="avien1" style="display:none">
          <label for="a_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1</label>
          <div class="col-md-7">
            <input type='text' id="a_engineer1" class="form-control a_engineer1" name="a_engineer1" autofocus readonly>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="avien2" style="display:none">
          <label for="a_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2</label>
          <div class="col-md-7">
            <input type='text' id="a_engineer2" class="form-control a_engineer2" name="a_engineer2" autofocus readonly>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="avien3" style="display:none">
          <label for="a_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3</label>
          <div class="col-md-7">
            <input type="text" readonly id="a_engineer3" class="form-control a_engineer3" name="a_engineer3" autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="avien4" style="display:none">
          <label for="a_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4</label>
          <div class="col-md-7">
            <input type="text" readonly id="a_engineer4" class="form-control a_engineer4" name="a_engineer4" autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="avien5" style="display:none">
          <label for="a_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5</label>
          <div class="col-md-7">
            <input type="text" readonly id="a_engineer5" class="form-control a_engineer5" name="a_engineer5" autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_asset" class="col-md-5 col-form-label text-md-left">Asset</label>
          <div class="col-md-7">
            <input type="text" readonly id="a_asset" type="text" class="form-control a_asset" name="a_asset" autofocus>
          </div>
        </div>
        <!-- <div class="form-group row justify-content-center" id="adivfail1" style="display:none">
            <label for="a_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="a_failure1" class="form-control a_failure1" autofocus readonly>
              <input type="hidden" name="a_failure1" id="ahiddenfail1">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="adivfail2" style="display:none">
            <label for="a_failure2" class="col-md-5 col-form-label text-md-left">Failure Code 2</label>
            <div class="col-md-7">
              <input id="a_failure2" class="form-control a_failure2"  autofocus readonly>
              <input type="hidden" name="a_failure2" id="ahiddenfail2">
            </div>
          </div>
          <div class="form-group row justify-content-center" id="adivfail3" style="display:none">
            <label for="a_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <input id="a_failure3" class="form-control a_failure3"  autofocus readonly>
              <input type="hidden" name="a_failure3" id="ahiddenfail3">
            </div>
          </div> -->
        <div class="form-group row justify-content-center">
          <label for="a_schedule" class="col-md-5 col-form-label text-md-left">Start Date</label>
          <div class="col-md-7">
            <input id="a_schedule" readonly type="date" class="form-control" name="a_schedule" value="{{ old('a_schedule') }}" autofocus>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_duedate" class="col-md-5 col-form-label text-md-left">Due Date</label>
          <div class="col-md-7">
            <input id="a_duedate" readonly type="date" class="form-control" name="a_duedate" value="{{ old('a_duedate') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_department" class="col-md-5 col-form-label text-md-left">Department</label>
          <div class="col-md-7">
            <input id="a_department" class="form-control a_department" name="a_department" autofocus readonly>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_priority" class="col-md-5 col-form-label text-md-left">Priority</label>
          <div class="col-md-7">
            <input id="a_priority" type="text" class="form-control" name="a_priority" value="{{ old('a_priority') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_note" class="col-md-5 col-form-label text-md-left">Note</label>
          <div class="col-md-7">
            <textarea id="a_note" class="form-control c_note" name="a_note" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row justify-content-center">
          <label for="a_enginechoose" class="col-md-5 col-form-label text-md-left">Pick Engineers</label>
          <div class="col-md-7">
            <select id="apprengpick" name="apprengpick[]" class="form-control apprengpick" multiple="multiple">
              @foreach($engine as $engpick)
              <option value="{{$engpick->eng_code}}">{{$engpick->eng_code}} -- {{$engpick->eng_desc}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row justify-content-center" id="divrepairtype">

          <label for="repaircode" class="col-md-5 col-form-label text-md-left">Repair Type <span id="alert1" style="color: red; font-weight: 200;">*</span></label>

          <div class="col-md-7" style="vertical-align:middle;">
            <input class=" d-inline" type="radio" name="repairtype" id="argcheck" value="group">
            <label class="form-check-label" for="argcheck">
              Repair Group
            </label>

            <input class="d-inline ml-5" type="radio" name="repairtype" id="arccheck" value="code">
            <label class="form-check-label" for="arccheck">
              Repair Code
            </label>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="a_btnclose" data-dismiss="modal">Close</button>
        <form method="post" id="approvee" action="/approvewo">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-danger bt-action" id="a_btnreject">Reject</button>
          <input type='hidden' name='switch' value='reject'>
          <input type='hidden' name='aprwonbr' id="apprwonbr2">

        </form>
        <form method="post" id="approvee2" action="/approvewo">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-success bt-action" id="a_btnapprove">Approve</button>
          <input type='hidden' name='switch' value='approve'>
          <input type='hidden' name='aprwonbr' id="apprwonbr">
          <input type='hidden' name='repairtype' id='repairtype'>
          <input type='hidden' name='repaircodeapp' id="repaircodeapp">
          <input type='hidden' name='repairgroupapp' id="repairgroupapp">
          <input type='hidden' name='repairtypeapp' id='repairtypeapp'>
          <input type='hidden' name='engappr[]' id='engappr'>
        </form>
        <button type="button" class="btn btn-block btn-info" id="a_btnloading" style="display:none"><i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>
    </div>
  </div>
</div>
</div>

<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="v_counter" value=0>
      <div class="modal-body">
        <div class="form-group row">
          <label for="v_nowo" class="col-md-2 col-form-label text-md-left">WO Number</label>
          <div class="col-md-4">
            <input id="v_nowo" type="text" class="form-control" name="v_nowo" autocomplete="off" readonly autofocus>
          </div>
          <label for="v_creator" class="col-md-2 col-form-label text-md-left">Requested By</label>
          <div class="col-md-4">
            <input id="v_creator" readonly class="form-control" name="v_creator" value="{{ old('v_creator') }}" autofocus>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_nosr" class="col-md-2 col-form-label text-md-left">SR Number</label>
          <div class="col-md-4">
            <input id="v_nosr" type="text" class="form-control" name="v_nosr" readonly autofocus>
          </div>
          <label for="v_dept" class="col-md-2 col-form-label text-md-left">Department</label>
          <div class="col-md-4">
            <input id="v_dept" readonly class="form-control" name="v_dept" value="{{ old('v_dept') }}" autofocus>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_srnote" class="col-md-2 col-form-label text-md-left">SR Note</label>
          <div class="col-md-4">
            <textarea id="v_srnote" readonly class="form-control" name="v_srnote" value="{{ old('v_srnote') }}" autofocus></textarea>
          </div>
          <!-- <label for="v_dept" class="col-md-2 col-form-label text-md-left">Department</label>
          <div class="col-md-4">
            <input id="v_dept" readonly class="form-control" name="v_dept" value="{{ old('v_dept') }}" autofocus>
          </div> -->
        </div>
        <div class="form-group row">
          <label for="v_asset" class="col-md-2 col-form-label text-md-left">Asset Code</label>
          <div class="col-md-4">
            <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus>
          </div>
          <label for="v_loc" class="col-md-2 col-form-label text-md-left">Location</label>
          <div class="col-md-4">
            <input id="v_loc" type="text" class="form-control" name="v_loc" value="{{ old('v_loc') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_assetdesc" class="col-md-2 col-form-label text-md-left">Asset Desc</label>
          <div class="col-md-4">
            <input type="text" readonly id="v_assetdesc" type="text" class="form-control v_assetdesc" name="v_assetdesc" autofocus>
          </div>
          <label for="v_wottype" class="col-md-2 col-form-label text-md-left">Failure Type</label>
          <div class="col-md-4">
            <input id="v_wottype" type="text" class="form-control" name="v_wottype" value="{{ old('v_wottype') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_note" class="col-md-2 col-form-label text-md-left">Note</label>
          <div class="col-md-4">
            <textarea id="v_note" readonly class="form-control" name="v_note" value="{{ old('v_note') }}" autofocus></textarea>
          </div>
          <label for="v_fclist" class="col-md-2 col-form-label text-md-left">Failure Code</label>
          <div class="col-md-4">
            <textarea id="v_fclist" class="form-control" name="v_fclist" value="{{ old('v_fclist') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_engineerl" class="col-md-2 col-form-label text-md-left">Engineer List</label>
          <div class="col-md-4">
            <textarea id="v_engineerl" class="form-control v_engineerl" name="v_engineerl" autofocus readonly></textarea>
          </div>
          <label for="v_impact" class="col-md-2 col-form-label text-md-left">Impact</label>
          <div class="col-md-4">
            <textarea id="v_impact" class="form-control" name="v_impact" value="{{ old('v_impact') }}" style="white-space: pre-wrap;" autofocus readonly></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_startdate" class="col-md-2 col-form-label text-md-left">Start Date</label>
          <div class="col-md-4">
            <input id="v_startdate" readonly type="date" class="form-control" name="v_startdate" value="{{ old('v_startdate') }}" autofocus>
          </div>
          <label for="v_duedate" class="col-md-2 col-form-label text-md-left">Due Date</label>
          <div class="col-md-4">
            <input id="v_duedate" type="date" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}" autofocus readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-left">SR Uploaded File</label>
          <div class="col-md-4" style="overflow-x: auto;">
            <!-- <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="munculgambar_view_sr">
            </table> -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>File Name</th>
                </tr>
              </thead>
              <tbody id="munculgambar_view_sr">

              </tbody>
            </table>
          </div>
          <label class="col-md-2 col-form-label text-md-left">WO Uploaded File</label>
          <div class="col-md-4" style="overflow-x: auto;">
            <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="munculgambar_view">
            </table>
          </div>
        </div>
        <div class="form-group row">
          <label for="v_rejectreason" class="col-md-2 col-form-label text-md-left">User Acceptance Note</label>
          <div class="col-md-4">
            <textarea id="v_rejectreason" readonly type="text" class="form-control" name="v_rejectreason" value="{{ old('v_rejectreason') }}" rows="2" autofocus></textarea>
          </div>
          <label class="col-md-2 col-form-label text-md-left">WO Reporting File</label>
          <div class="col-md-4" style="overflow-x: auto;">
            <table class="table table-bordered" style="width: 100%; max-width: 100%;" id="fileupload_reporting">
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- modal accepting -->
<div class="modal fade" id="acceptModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form id="reportstatuswo" method="post" action="/statusreportingwo" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Acceptance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="v_counter">
          <input type="hidden" name="statuswo" id="statuswo">
          <div class="form-group row justify-content-center">
            <label for="ac_wonbr2" class="col-md-5 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-7">
              <input id="ac_wonbr2" type="text" class="form-control ac_wonbr2" name="ac_wonbr2" autofocus readonly>
              <!-- <input type="hidden" id="c_assetcode"> -->
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_srnbr2" class="col-md-5 col-form-label text-md-left">SR Number</label>
            <div class="col-md-7">
              <input id="ac_srnbr2" type="text" class="form-control ac_srnbr2" name="ac_srnbr2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_asset2" class="col-md-5 col-form-label text-md-left">Asset</label>
            <div class="col-md-7">
              <input id="ac_asset2" type="text" class="form-control ac_asset2" name="ac_asset2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer1" style="display:none">
            <label for="ac_engineer1" class="col-md-5 col-form-label text-md-left">Engineer 1</label>
            <div class="col-md-7">
              <input type='text' id="ac_engineer1" class="form-control ac_engineer1" name="ac_engineer1" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer2" style="display:none">
            <label for="ac_engineer2" class="col-md-5 col-form-label text-md-left">Engineer 2</label>
            <div class="col-md-7">
              <input type='text' id="ac_engineer2" class="form-control ac_engineer2" name="ac_engineer2" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer3" style="display:none">
            <label for="ac_engineer3" class="col-md-5 col-form-label text-md-left">Engineer 3</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer3" class="form-control ac_engineer3" name="ac_engineer3" autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer4" style="display:none">
            <label for="ac_engineer4" class="col-md-5 col-form-label text-md-left">Engineer 4</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer4" class="form-control ac_engineer4" name="ac_engineer4" autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivengineer5" style="display:none">
            <label for="ac_engineer5" class="col-md-5 col-form-label text-md-left">Engineer 5</label>
            <div class="col-md-7">
              <input type="text" readonly id="ac_engineer5" class="form-control ac_engineer5" name="ac_engineer5" autofocus>
            </div>
          </div>
          <!-- <div class="form-group row col-md-12 c_engineerdiv">
            <label for="c_repaircodenum" class="col-md-5 col-form-label text-md-left">Total Repair Code</label>
            <div class="col-md-7">
              <input id="c_repaircodenum" type="number" class="form-control c_repaircodenum" name="c_repaircodenum" min='1' max='3'  autofocus>
            </div>
          </div> -->
          <div class="form-group row justify-content-center" id="acdivfail1" style="display:none">
            <label for="ac_failure1" class="col-md-5 col-form-label text-md-left">Failure Code 1</label>
            <div class="col-md-7">
              <input id="ac_failure1" class="form-control ac_failure1" autofocus readonly>

            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivfail2" style="display:none">
            <label for="ac_failure2" class="col-md-5 col-form-label text-md-left">Failure Code2</label>
            <div class="col-md-7">
              <input id="ac_failure2" class="form-control ac_failure2" autofocus readonly>

            </div>
          </div>
          <div class="form-group row justify-content-center" id="acdivfail3" style="display:none">
            <label for="ac_failure3" class="col-md-5 col-form-label text-md-left">Failure Code 3</label>
            <div class="col-md-7">
              <input id="ac_failure3" class="form-control ac_failure3" autofocus readonly>

            </div>
          </div>
          <div class="form-group row justify-content-center" id="divaccode" style="display: none;">
            <label for="ac_repaircode" class="col-md-5 col-form-label text-md-left">Repair Code</label>
            <div class="col-md-7">
              <textarea id="ac_repaircode" readonly class="form-control" name="ac_repaircode" value="{{ old('v_repaircode') }}" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divacgroup" style="display: none;">
            <label for="ac_repairgroup" class="col-md-5 col-form-label text-md-left">Repair Group</label>
            <div class="col-md-7">
              <input id="ac_repairgroup" readonly class="form-control" name="ac_repairgroup" value="{{ old('v_repairgroup') }}" autofocus>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="divacmanual" style="display: none;">
            <label for="ac_repairmanual" class="col-md-5 col-form-label text-md-left">Repair</label>
            <div class="col-md-7">
              <input id="ac_repairmanual" readonly class="form-control" name="ac_repairmanual" value="Manual" autofocus>
            </div>
          </div>
          <!-- <div class="form-group row justify-content-center c_engineerdiv">
            <label for="c_repairhour" class="col-md-5 col-form-label text-md-left">Repair Hour</label>
            <div class="col-md-7">
              <input id="c_repairhour" type="number" class="form-control c_repairhour" name="c_repairhour" min='1'  autofocus readonly>
            </div>
          </div> -->
          <div class="form-group row justify-content-center">
            <label for="c_finishdate" class="col-md-5 col-form-label text-md-left">Finish Date</label>
            <div class="col-md-7">
              <input id="c_finishdate" type="date" class="form-control c_finishdate" name="c_finishdate" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="c_finishtime" class="col-md-5 col-form-label text-md-left">Finish Time</label>
            <div class="col-md-7">
              <input id="c_finishtime" type="text" class="form-control c_finishdate" name="c_finishdate" autofocus readonly>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="ac_note" class="col-md-5 col-form-label text-md-left">Note</label>
            <div class="col-md-7">
              <textarea id="ac_note" class="form-control c_note" name="ac_note" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="reportnote">
            <label for="v_reportnote" class="col-md-5 col-form-label text-md-left">Reporting Note</label>
            <div class="col-md-7">
              <textarea id="ac_reportnote" class="form-control ac_reportnote" name="ac_reportnote" autofocus></textarea>
            </div>
          </div>
          <div class="form-group row justify-content-center" id="photodiv">
            <label for="v_reportnote" class="col-md-5 col-form-label text-md-left">Uploaded File</label>
            <div class="col-md-7" id="munculgambar_edit">

            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="o_part" class="col-md-5 col-form-label text-md-left">Upload File</label>
            <div class="col-md-7">
              <input type="file" name="fileother[]" multiple>
            </div>
          </div>
          <!-- A211022 
          <div class="form-group row justify-content-center" id="photodiv">
            <div class="col-md-12 justify-content-center"  >
              <label for="v_fotoupload" class="col-md-12 col-form-label text-md-center">Photo(s) uploaded</label>
              
            </div>
            <div class="col-md-12 justify-content-center">
              <div id="munculgambar">
          
              </div>
            </div>
          </div> -->


          <!-- <div class="form-group row justify-content-center">
            <label class="col-md-12 col-form-label text-md-center"><b>Completed</b></label>
            <label class="col-md-12 col-form-label text-md-left">Photo Upload : <span id="alert1" style="color: red; font-weight: 200;">*</span> </label>
          </div>
          <div class="form-group row justify-content-center" style="margin-bottom: 10%;">
              <div class="col-md-12 images">
                  <div class="pic">
                      add
                  </div>
              </div>
          </div> -->
          <input type="hidden" id="hidden_var" name="hidden_var" value="0" />
          <input type="hidden" id="formtype" name="formtype" value="0" />

          <hr>
          <h6 style="text-align: center;"><b>Reprocess</b></h6>
          <div class="form-group row">
            <label for="uncompletenote" class="col-md-3 col-form-label text-md-left">Reason <span id="alert1" style="color: red; font-weight: 200;">*</span></label>
            <div class="col-md-7">
              <textarea id="uncompletenote" type="text" class="form-control" name="uncompletenote" rows="3" maxlength="50" autocomplete="off" autofocus></textarea>
            </div>
          </div>
          <!--           
          <div id="divrepair">
          
          </div> -->
        </div>

        <div class="modal-footer">

          <a id="aprint" target="_blank" class="mr-auto" style="width: 20%;"><button type="button" class="btn btn-warning bt-action" style="width: 70%;"><b>Print</b></button></a>
          <button type="button" class="btn btn-info bt-action" id="ac_btnclose" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger bt-action" id="ac_btnuncom">Reprocess</button>
          <button type="submit" class="btn btn-success bt-action" id="ac_btncom">Complete</button>
          <input type='hidden' name='switch2' id="switch2" value=''>
          <input type='hidden' name='aprwonbr2' id="apprwonbr3">
          <input type='hidden' name='aprsrnbr2' id="apprsrnbr3">
          <button type="button" class="btn btn-block btn-info" id="ac_btnloading" style="display:none">
            <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--Modal Delete-->
<div class="modal fade" id="deleteModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order Cancel / Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="delete" method="post" action="closewo">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_wonbr" id="tmp_wonbr" />
          <input type="hidden" name="tmp_wostatus" id="tmp_wostatus" />
          Are you sure want to cancel/delete this <i>Work Order</i> <b> <span id="d_wonbr"></span></b> ?
          <div class="form-group row" id="divnotecancel" style="display: none;">
            <label class="col-md-12 col-form-label">Note for Service Request maker : </label>
            <textarea class="form-control" id="notecancel" name="notecancel" autofocus maxlength="150"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info bt-action" id="d_btnclosed" data-dismiss="modal">Back</button>
          <button type="submit" class="btn btn-danger bt-action" id="d_btnconfd" name="thisbutton" value="btndelete">Delete</button>
          <button type="submit" class="btn btn-primary bt-action" id="d_btnconfd" name="thisbutton" value="btncancel">Cancel</button>
          <button type="button" class="btn btn-block btn-info" id="d_btnloadingd" style="display:none">
            <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="reopenModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Reopen WO</h5>
        <button type="button" class="close" id='deletequit' data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="reopen" method="post" action="reopenwo">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="tmp_rowonbr" id="tmp_rowonbr">
          Do you want to reopen <i>work order</i> <b> <span id="d_rowonbr"></span></b> ?
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
<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>
  </div>
</div>

<!-- Modal Maint Code -->
<div class="modal fade" id="maintCodeModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Maintenance Code Browse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="maintcodebrowse" method="post" action="/" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <!-- <input type="hidden" id="v_hiddenreq" name="v_hiddenreq" />
          <input type="hidden" id="v_idsr" name="v_idsr" /> -->
          <div class="form-group row col-md-12">
            <label for="b_mtcode" class="col-md-3 col-form-label text-md-left">Maintenance Code</label>
            <div class="col-md-7">
              <select id="b_mtcode" name="b_mtcode" class="form-control">
                <option value="">--Select Maintenance Code--</option>
                @foreach($maintenancelist as $mt)
                <option value="{{$mt->pmc_code}}">{{$mt->pmc_code}} -- {{$mt->pmc_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="responsive-table">
            <table class="table table-bordered mt-4 no-footer" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Maintenance Code</th>
                  <th>Maintenance Type</th>
                  <th>Instruction List</th>
                  <th>Instruction Sparepart</th>
                  <th>Instruction Qc</th>
                </tr>
              </thead>
              <tbody id="b_mtcodetable">
              </tbody>
            </table>
          </div>
          <hr>
          <div class="form-group row col-md-12">
            <label for="b_inslist" class="col-md-3 col-form-label text-md-left">Instruction List Code</label>
            <div class="col-md-7">
              <select class="form-control b_inslist" name="b_inslist" id="b_inslist">
                <option></option>
                @foreach ($inslist as $ins)
                <option value="{{$ins->ins_code}}">{{$ins->ins_code}} -- {{$ins->ins_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="responsive-table">
            <table class="table table-bordered mt-4 no-footer" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Instruction Code</th>
                  <th>Duration</th>
                  <th>UM</th>
                  <th>Man Power</th>
                  <th>Step</th>
                  <th>Step Desc</th>
                  <th>Reference</th>
                </tr>
              </thead>
              <tbody id="b_inslisttable">
              </tbody>
            </table>
          </div>
          <hr>
          <div class="form-group row col-md-12">
            <label for="b_splist" class="col-md-3 col-form-label text-md-left">Instruction Sparepart Code</label>
            <div class="col-md-7">
              <select class="form-control b_splist" name="b_splist" id="b_splist">
                <option></option>
                @foreach ($splist as $sp)
                <option value="{{$sp->spg_code}}">{{$sp->spg_code}} -- {{$sp->spg_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="responsive-table">
            <table class="table table-bordered mt-4 no-footer" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Instruction Sparepart Code</th>
                  <th>Sparepart Code</th>
                  <th>Qty Req</th>
                </tr>
              </thead>
              <tbody id="b_splisttable">
              </tbody>
            </table>
          </div>
          <hr>
          <div class="form-group row col-md-12">
            <label for="b_qclist" class="col-md-3 col-form-label text-md-left">Instruction QC</label>
            <div class="col-md-7">
              <select class="form-control b_qclist" name="b_qclist" id="b_qclist">
                <option></option>
                @foreach ($qclist as $qc)
                <option value="{{$qc->qcs_code}}">{{$qc->qcs_code}} -- {{$qc->qcs_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="responsive-table">
            <table class="table table-bordered mt-4 no-footer" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>QC Code</th>
                  <th>QC Spec</th>
                  <th>QC Tools</th>
                  <th>Operator</th>
                  <th>Value 1</th>
                  <th>Value 2</th>
                  <th>UM</th>
                </tr>
              </thead>
              <tbody id="b_qclisttable">
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="btnclose_b" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
              <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  //konfigurasi modal ketika ada modal bertumpuk dan modal terakhir di close tetap bisa scroll ke modal pertama
  $(document).on('show.bs.modal', '.modal', function() {
    var zIndex = 1040 + (10 * $('.modal.show').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });

  $(document).on('hidden.bs.modal', '.modal', function() {
    $('.modal.show').length && $(document.body).addClass('modal-open');
  });
  //batas konfigurasi modal


  $(document).on('submit', '#approvee', function(event) {

    event.preventDefault();
    // document.getElementById('repaircodeapp').values = document.getElementById('repaircode').values;


    document.getElementById('a_btnapprove').style.display = 'none';
    document.getElementById('a_btnreject').style.display = 'none';
    document.getElementById('a_btnclose').style.display = 'none';
    document.getElementById('a_btnloading').style.display = '';
    document.getElementById('closeapprove').style.display = 'none';
    document.getElementById('repaircodeapp').value = test;
    // test.forEach(insertapprove); 
  });

  $(document).on('submit', '#approvee2', function(event) {

    event.preventDefault();
    // document.getElementById('repaircodeapp').values = document.getElementById('repaircode').values;
    const appreng = $('#apprengpick').val();
    $('#engappr').val(appreng);
    var test = $('#repaircodeselect').val();
    var repairgroup = $('#repairgroup').val();
    if (test == null && repairgroup == null) {
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Enter minimum 1 repair code/group',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
    } else {
      // document.getElementById('repaircodeapp').value = document.getElementById('repaircode');
      document.getElementById('repairgroupapp').value = repairgroup;
      document.getElementById('a_btnapprove').style.display = 'none';
      document.getElementById('a_btnreject').style.display = 'none';
      document.getElementById('a_btnclose').style.display = 'none';
      document.getElementById('a_btnloading').style.display = '';
      document.getElementById('closeapprove').style.display = 'none';
      document.getElementById('repaircodeapp').value = test;
      // test.forEach(insertapprove);
      document.getElementById('approvee2').submit();
    }
  });

  $("#apprengpick").select2({
    width: '100%',
    placeholder: "Select Engineers",
    maximumSelectionLength: 5,
    closeOnSelect: false,
    allowClear: true,
    // theme : 'bootstrap4'
  });
  $('#erepairgroup').select2({
    placeholder: '--Select Repair Group--',
    width: '100%',
    closeOnSelect: true,
  })
  $("#erepaircode").select2({
    width: '100%',
    placeholder: "Select Repair Code",
    maximumSelectionLength: 3,
    closeOnSelect: false,
    allowClear: true,
    // theme : 'bootstrap4'
  });
  $("#c_mtcode").select2({
    width: '100%',
    placeholder: "Select Maintenance Code",
    allowClear: true,
  });

  $("#c_inslist").select2({
    width: '100%',
    placeholder: "Select Instruction List Code",
    allowClear: true,
  });

  $("#c_splist").select2({
    width: '100%',
    placeholder: "Select Spare Part List Code",
    allowClear: true,
  });

  $("#c_qclist").select2({
    width: '100%',
    placeholder: "Select QC List Code",
    allowClear: true,
  });

  $('#s_asset').select2({
    width: '100%',
    theme: 'bootstrap4',


  });

  $('#assetloc').select2({
    placeholder: "Select Asset",
    width: '100%',
    theme: 'bootstrap4',
  });

  $('.c_asset').select2({
    placeholder: "Select Asset",
    width: '100%',
    theme: 'bootstrap4',
  });

  $('.c_listengineer').select2({
    placeholder: "Select Engineer",
    width: '100%',
    theme: 'bootstrap4',
    maximumSelectionLength: 5,
    allowClear: true,
    closeOnSelect: false,
    templateSelection: function(data, container) {
      // Memotong teks opsi menjadi 20 karakter
      var text = data.text.slice(0, 20);
      // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
      return text + (data.text.length > 20 ? '...' : '');
    }
  });

  $('#c_wottype').select2({
    placeholder: "Select Value",
    width: '100%',
    theme: 'bootstrap4',
  });

  $('#c_failuretype').select2({
    placeholder: "Select Failure Type",
    width: '100%',
    closeOnSelect: false,
    allowClear: true,
    theme: 'bootstrap4',
  });

  $('#c_impact').select2({
    placeholder: "Select Value",
    width: '100%',
    closeOnSelect: false,
    allowClear: true,
    theme: 'bootstrap4',
    maximumSelectionLength: 5,
  });



  $("#wotype").select2({
    width: '100%',
    // theme : 'bootstrap4',
    allowClear: true,
    placeholder: 'Select Failure Type',

  });

  $("#failurecode").select2({
    width: '100%',
    placeholder: "Select Failure Code",
    theme: "bootstrap4",
    allowClear: true,
    maximumSelectionLength: 5,
    closeOnSelect: false,
    allowClear: true,
    multiple: true,
  });

  $('#reportstatuswo').submit(function(e) {
    document.getElementById('ac_btnclose').style.display = 'none';
    document.getElementById('ac_btnuncom').style.display = 'none';
    document.getElementById('ac_btncom').style.display = 'none';
    document.getElementById('ac_btnloading').style.display = '';
    document.getElementById('aprint').style.display = 'none';
  })
  $("#new").submit(function(e) {
    var engarr = [];
    var failarr = [];
    var failure = document.getElementsByName('c_failure[]');
    var engineer = document.getElementsByName('c_engineer[]');
    var engineerlength = engineer.length;
    var failurelength = failure.length;
    for (var i = 0; i < failurelength; i++) {
      var failurenow = document.getElementsByName('c_failure[]')[i].value;
      if (failurenow != '') {
        failarr.push(failurenow);
      }
    }
    for (var k = 0; k < engineerlength; k++) {
      var engineernow = document.getElementsByName('c_engineer[]')[k].value;
      if (engineernow != '') {
        engarr.push(engineernow);
      }
    }
    const counteng = {};
    const countfail = {};
    failarr.forEach(function(item, index) {
      if (countfail[failarr[index]]) {
        countfail[failarr[index]] += 1;
      } else {
        countfail[failarr[index]] = 1;
      }
    });
    engarr.forEach(function(item, index) {
      if (counteng[engarr[index]]) {
        counteng[engarr[index]] += 1;
      } else {
        counteng[engarr[index]] = 1;
      }
    });
    const duplfail = Object.values(countfail).filter(x => x != 1);
    const dupleng = Object.values(counteng).filter(y => y != 1);
    if (duplfail.length > 0) {
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Failure Code Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      e.preventDefault();
    }
    if (dupleng.length > 0) {
      // eksekusi jika duplikat
      swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Engineer Duplicate',
        toast: true,
        showConfirmButton: false,
        timer: 2000,
      })
      e.preventDefault();
    }
    if (duplfail <= 0 && dupleng <= 0) {
      document.getElementById('btnclose').style.display = 'none';
      document.getElementById('btnconf').style.display = 'none';
      document.getElementById('btnloading').style.display = '';
    }
  });

  $(document).on('click', '.approvewo', function() {
    $('#loadingtable').modal('show');
    var arrayeng = [];
    var wonbr = $(this).data('wonbr');
    var btnendel1 = document.getElementById("btndeleteen1");
    var btnendel2 = document.getElementById("btndeleteen2");
    var btnendel3 = document.getElementById("btndeleteen3");
    var btnendel4 = document.getElementById("btndeleteen4");
    var btnendel5 = document.getElementById("btndeleteen5");
    var counter = document.getElementById('counter').value;
    var counterfail = document.getElementById('counterfail').value;
    $.ajax({
      url: '/womaint/getwoinfo',
      method: 'GET',
      data: {
        nomorwo: wonbr,
      },
      success: function(vamp) {
        var tempres = JSON.stringify(vamp);
        var result = JSON.parse(tempres);
        var wonbr = result[0].wo_nbr;
        var srnbr = result[0].wo_sr_nbr;
        var en1val = result[0].woen1;
        var en2val = result[0].woen2;
        var en3val = result[0].woen3;
        var en4val = result[0].woen4;
        var en5val = result[0].woen5;
        var asset = result[0].wo_asset;
        var assdesc = result[0].asset_desc;
        var schedule = result[0].wo_schedule;
        var duedate = result[0].wo_duedate;
        var fc1 = result[0].wofc1;
        var fc2 = result[0].wofc2;
        var fc3 = result[0].wofc3;
        var fn1 = result[0].fd1;
        var fn2 = result[0].fd2;
        var fn3 = result[0].fd3;
        var wodept = result[0].wo_dept;
        var prio = result[0].wo_priority;
        var note = result[0].wo_note;
        var wotype = result[0].wo_type;
        // alert(wotype);
        document.getElementById('repairtypeapp').value = wotype;
        if (wotype == 'auto') {
          document.getElementById('divrepairtype').style.display = 'none';
        }
        // if(fc1 == null || fc1 == ''){
        //   document.getElementById('adivfail1').style.display = 'none';
        // }
        // else{
        //   document.getElementById('adivfail1').style.display = '';
        //   document.getElementById('a_failure1').value = fn1;
        //   document.getElementById('ahiddenfail1').value = fc1;
        //   counterfail = 1;
        // }

        // if(fc2 == null || fc2 == '' ){
        //   document.getElementById('adivfail2').style.display = 'none';
        // }  
        // else{
        //     document.getElementById('adivfail2').style.display = '';
        //     document.getElementById('a_failure2').value = fn2;
        //     document.getElementById('ahiddenfail2').value = fc2;
        //     counterfail = 2;
        // }

        // if(fc3 == null || fc3 == ''){
        //   document.getElementById('adivfail3').style.display = 'none';
        // }
        // else{
        //   document.getElementById('adivfail3').style.display = '';
        //   document.getElementById('a_failure3').value = fn3;
        //   document.getElementById('ahiddenfail3').value = fc3;
        //   counterfail = 3;
        // }

        if (en1val == null || en1val == '') {
          en1val = '';
        } else {
          document.getElementById('avien1').style.display = '';
          arrayeng.push(en1val);
          counter = 1;
        }

        if (en2val == null || en2val == '') {
          en2val = '';
          document.getElementById('avien2').style.display = 'none';
        } else {
          document.getElementById('avien2').style.display = '';
          arrayeng.push(en2val);
          counter = 2;
        }
        if (en3val == null || en3val == '') {
          en3val = '';
          document.getElementById('avien3').style.display = 'none';
        } else {
          document.getElementById('avien3').style.display = '';
          arrayeng.push(en3val);
          counter = 3;
        }

        if (en4val == null || en4val == '') {
          en4val = '';
          document.getElementById('avien4').style.display = 'none';
        } else {
          document.getElementById('avien4').style.display = '';
          arrayeng.push(en4val);
          counter = 4;
        }

        if (en5val == null || en5val == '') {
          en5val = '';
          document.getElementById('avien5').style.display = 'none';
        } else {
          document.getElementById('avien5').style.display = '';
          arrayeng.push(en5val);
          counter = 5;
        }

        document.getElementById('counter').value = counter;
        document.getElementById('a_nowo').value = wonbr;
        document.getElementById('a_nosr').value = srnbr;
        document.getElementById('a_schedule').value = schedule;
        document.getElementById('a_duedate').value = duedate;
        document.getElementById('a_engineer1').value = en1val;
        document.getElementById('a_engineer2').value = en2val;
        document.getElementById('a_engineer3').value = en3val;
        document.getElementById('a_engineer4').value = en4val;
        document.getElementById('a_engineer5').value = en5val;
        document.getElementById('a_asset').value = asset + ' -- ' + assdesc;
        // document.getElementById('a_failure1').value  = fc1+' -- '+fn1;
        // document.getElementById('a_failure2').value  = fc2+' -- '+fn2;
        // document.getElementById('a_failure3').value  = fc3+' -- '+fn3;
        document.getElementById('a_department').value = wodept;
        document.getElementById('a_note').value = note;
        document.getElementById('a_priority').value = prio;
        document.getElementById('counterfail').value = counterfail;
        document.getElementById('apprwonbr2').value = wonbr;
        document.getElementById('apprengpick').value = arrayeng;
        document.getElementById('apprwonbr').value = wonbr;
        $("#repaircodeselect").select2({
          width: '100%',
          placeholder: "Select Repair Code",
          maximumSelectionLength: 3,
          closeOnSelect: false,
          allowClear: true,
          // theme : 'bootstrap4'
        });

      },
      complete: function(vamp) {
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));

        setTimeout(function() {
          $('#loadingtable').modal('hide');
        }, 500);

        setTimeout(function() {
          $('#approveModal').modal('show');
        }, 1000);

      }
    })
  });
  $("#delete").submit(function() {
    //alert('test');
    document.getElementById('d_btnclosed').style.display = 'none';
    document.getElementById('d_btnconfd').style.display = 'none';
    document.getElementById('d_btnloadingd').style.display = '';
  });

  $(document).on('click', '#e_addfai', function(e) {
    var counterfail = parseInt(document.getElementById('counterfail').value);
    var isfailnan = isNaN(counterfail);
    if (isfailnan) {
      counterfail = 0;
    }
    if (counterfail < 3) {
      // var lastdiv = 'btndeleteen'+counter;
      //  if(counterfail > 1){
      //   document.getElementById(lastdiv).style.display ='none';
      //  }
      counterfail += 1;
      var nextdiv = 'divfail' + counterfail;
      // var newdiv = 'btndeleteen'+counter;
      // alert(nextdiv);
      document.getElementById(nextdiv).style.display = '';
      $('#e_failure' + counterfail).attr('required', true);
      // document.getElementById(newdiv).style.display = '';
      document.getElementById('counterfail').value = counterfail;
      if (counterfail == 3) {
        document.getElementById('e_addfai').style.display = 'none';
      }
    }
  });

  $(document).on('change', '#e_wottype', function() {
    // console.log('masuk');
    var getAssetG = document.getElementById('hide_editassetgroup').value;
    var getType = $(this).val();

    // console.log(getAssetG);
    // console.log(getType);
    $.ajax({
      url: "/checkfailurecodetype",
      data: {
        group: getAssetG,
        type: getType,

      },
      success: function(data) {
        var code = data.optionfailcode;

        // console.log(code);

        var selectthis = document.getElementById('m_failurecode');

        // Hapus semua option yang ada
        selectthis.innerHTML = '';

        // Tambahkan option baru
        code.forEach(data => {
          const option = document.createElement('option');
          option.value = data.fn_code;
          option.text = data.fn_code + ' - ' + data.fn_desc;
          selectthis.add(option);
        });
      }
    })
  });

  $(document).on('click', '.viewwo', function() {
    $('#loadingtable').modal('show');
    var wonbr = $(this).data('wonumber');
    var srnumber = $(this).data('srnumber');
    var btnendel1 = document.getElementById("btndeleteen1");
    var btnendel2 = document.getElementById("btndeleteen2");
    var btnendel3 = document.getElementById("btndeleteen3");
    var btnendel4 = document.getElementById("btndeleteen4");
    var btnendel5 = document.getElementById("btndeleteen5");
    var counter = document.getElementById('counter').value;
    var counterfail = document.getElementById('counterfail').value;
    $.ajax({
      url: '/womaint/getwoinfo',
      method: 'GET',
      data: {
        wonumber: wonbr,
      },
      success: function(vamp) {

        // console.log(vamp);

        var wonumber = wonbr;
        var srnumber = vamp.wo_master.wo_sr_number;
        var assetcode = vamp.wo_master.wo_asset_code;
        var srnote = vamp.sr_note;
        var assetdesc = vamp.asset.asset_desc;
        var assetloc = vamp.asset.asset_loc;
        var assetloc_desc = vamp.asset.asloc_desc;
        var failuretype_code = vamp.wo_master.wo_failure_type !== null ? vamp.wo_master.wo_failure_type : '';
        var failuretype_desc = vamp.failure_type.wotyp_desc ? vamp.failure_type.wotyp_desc : '';
        var note = vamp.wo_master.wo_note;
        var startdate = vamp.wo_master.wo_start_date;
        var duedate = vamp.wo_master.wo_due_date;
        var createdby = vamp.wo_master.wo_createdby;
        var department = vamp.wo_master.wo_department ? vamp.wo_master.wo_department : '';
        var rejectreason = vamp.sr_acceptance_note ? vamp.sr_acceptance_note : '';

        let combineFailure = [];

        vamp.failurecode.forEach(function(failure) {
          combineFailure.push(failure.fn_code + " - " + failure.fn_desc);
        });

        let combineImpact = [];

        vamp.impact.forEach(function(impact) {
          combineImpact.push(impact.imp_code + " - " + impact.imp_desc);
        });

        let combineEngineer = [];

        vamp.engineer.forEach(function(engineer) {
          combineEngineer.push(engineer.eng_code + ' - ' + engineer.eng_desc);
        });


        document.getElementById('v_nowo').value = wonumber;
        document.getElementById('v_asset').value = assetcode;
        document.getElementById('v_assetdesc').value = assetdesc;
        document.getElementById('v_loc').value = assetloc + ' - ' + assetloc_desc;
        document.getElementById('v_wottype').value = failuretype_code + ' - ' + failuretype_desc;
        document.getElementById('v_fclist').value = combineFailure.join('\n');
        document.getElementById('v_impact').value = combineImpact.join('\n');
        document.getElementById('v_engineerl').value = combineEngineer.join('\n');
        document.getElementById('v_note').value = note;
        document.getElementById('v_nosr').value = srnumber;
        document.getElementById('v_startdate').value = startdate;
        document.getElementById('v_duedate').value = duedate;
        document.getElementById('v_creator').value = createdby;
        document.getElementById('v_dept').value = department;
        document.getElementById('v_srnote').value = srnote;
        document.getElementById('v_rejectreason').value = rejectreason;


      },
      complete: function(vamp) {
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));

        setTimeout(function() {
          $('#loadingtable').modal('hide');
        }, 500);

        setTimeout(function() {
          $('#viewModal').modal('show');
        }, 1000);

      }
    })

    $.ajax({
      url: "/imageviewonly_woimaint",
      data: {
        wonumber: wonbr,
      },
      success: function(data) {

        $('#munculgambar_view').html('').append(data);
      }
    })

    $.ajax({
      url: "/imageview_nodelete",
      data: {
        wonumber: wonbr,
      },
      success: function(data) {

        $('#fileupload_reporting').html('').append(data);
      }
    })

    $.ajax({
      url: "/listuploadview/" + srnumber,
      success: function(data) {
        // console.log(data);
        $('#munculgambar_view_sr').html('').append(data);
      }
    })
  });
  // flag tunggu semua menu


  $(document).on('click', '.deletewo', function() {

    var wonbr = $(this).data('wonumber');
    var status = $(this).data('wostatus');
    var srnbr = $(this).data('srnumber');
    document.getElementById('d_wonbr').innerHTML = wonbr;
    document.getElementById('tmp_wonbr').value = wonbr;
    document.getElementById('tmp_wostatus').value = status;

    if (srnbr !== '') {
      document.getElementById('divnotecancel').style.display = "";
    } else {
      document.getElementById('divnotecancel').style.display = "none";
    }

  });

  function clear_icon() {
    $('#id_icon').html('');
    $('#post_title_icon').html('');
  }

  $('#s_engineer').select2({
    width: '100%',
    theme: 'bootstrap4',

  })

  $(document).on('click', '#btnrefresh', function() {
    var wonumber = '';
    var asset = '';
    var status = '';
    var engineer = '';
    var priority = '';
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = 1;

    document.getElementById('s_nomorwo').value = '';
    document.getElementById('s_asset').value = '';
    document.getElementById('s_status').value = '';
    document.getElementById('s_engineer').value = '';
    document.getElementById('s_priority').value = '';
    document.getElementById('tmpwo').value = '';
    document.getElementById('tmpasset').value = '';
    document.getElementById('tmpstatus').value = '';
    document.getElementById('tmppriority').value = '';
    document.getElementById('tmpengineer').value = '';

    $('#s_asset').select2({
      width: '100%',
      theme: 'bootstrap4',
      asset
    })
    $('#s_engineer').select2({
      width: '100%',
      theme: 'bootstrap4',
      engineer
    })
    fetch_data(page, sort_type, column_name, wonumber, asset, status, priority, engineer);
  });

  $(document).on('change', '#c_engineernum', function() {
    var col = '';
    var engineernum = document.getElementById('c_engineernum').value;

    var divengine1 = document.getElementById('testdiv');
    var appendclone = divengine1.cloneNode(true);
    col = '';
    var i;
    if (engineernum != 0 && engineernum < 6) {
      $('.divenginer').remove();
      for (i = 1; i <= engineernum; i++) {
        col += '<div class="form-group row col-md-12 divenginer" id="engineer1" >';
        col += '<label for="engineer' + i + '" class="col-md-5 col-form-label text-md-left">Engineer' + i + '</label>';
        col += '<div class="col-md-7">';
        col += '<select id="c_engineer' + i + '" type="text" class="form-control c_engineer" name="c_engineer[]" required>';
        col += '<option value="">--Select Engineer--</option>';
        @foreach($user as $user2)
        col += '<option value="{{$user2->eng_code}}">{{$user2->eng_code}} -- {{$user2->eng_desc}}</option>';
        @endforeach
        col += '</select>';
        col += '</div>';
        col += '</div>';
        // var newid = 'engineer'+i;
        //   console.log(newid);
        // document.getElementById('testdiv').append(col);
        $("#testdiv").append(col);
        col = '';
      }
      $('.c_engineer').select2({
        placeholder: "Select Data",
        width: '100%',
        theme: 'bootstrap4',
      });
    }
  });

  function resetSearch() {
    $('#s_nomorwo').val('');
    $('#s_status').val('');
    $('#s_wotype').val('');
    $('#s_engineer').val('');
  }

  $(document).on('click', '#btnrefresh', function() {
    resetSearch();
  });

  $(document).ready(function() {
    // var currentURL = window.location.href;
    // var urlParams = new URLSearchParams(currentURL);

    // var s_asset = urlParams.get('s_asset');
    // var s_status = urlParams.get('s_status');

    // document.getElementById('test1').value = s_asset;
    // document.getElementById('test2').value = s_status;

    $("#b_mtcode").select2({
      width: '100%',
      placeholder: "Select Maintenance Code",
      allowClear: true,
    });

    $("#b_inslist").select2({
      width: '100%',
      placeholder: "Select Instruction List Code",
      allowClear: true,
    });

    $("#b_splist").select2({
      width: '100%',
      placeholder: "Select Spare Part List Code",
      allowClear: true,
    });

    $("#b_qclist").select2({
      width: '100%',
      placeholder: "Select QC List Code",
      allowClear: true,
    });

    $('#e_engineerlist').select2({
      placeholder: 'Select Engineers',
      width: '100%',
      theme: 'bootstrap4',
      maximumSelectionLength: 5,
      allowClear: true,
      closeOnSelect: false,
      templateSelection: function(data, container) {
        // Memotong teks opsi menjadi 20 karakter
        var text = data.text.slice(0, 20);
        // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
        return text + (data.text.length > 20 ? '...' : '');
      }
    });

    $('#e_wottype').select2({
      placeholder: 'Select Failure Type',
      width: '100%',
      theme: 'bootstrap4',
      allowClear: true,
      closeOnSelect: false,
      templateSelection: function(data, container) {
        // Memotong teks opsi menjadi 20 karakter
        var text = data.text.slice(0, 20);
        // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
        return text + (data.text.length > 20 ? '...' : '');
      },
    });

    $('#e_impact').select2({
      placeholder: 'Select Impact',
      width: '100%',
      theme: 'bootstrap4',
      maximumSelectionLength: 5,
      allowClear: true,
      closeOnSelect: false,
      templateSelection: function(data, container) {
        // Memotong teks opsi menjadi 20 karakter
        var text = data.text.slice(0, 20);
        // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
        return text + (data.text.length > 20 ? '...' : '');
      }
    });

    $('#m_failurecode').select2({
      placeholder: 'Select Failure Code',
      width: '100%',
      theme: 'bootstrap4',
      allowClear: true,
      closeOnSelect: false,
      maximumSelectionLength: 5,
      templateSelection: function(data, container) {
        // Memotong teks opsi menjadi 20 karakter
        var text = data.text.slice(0, 20);
        // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
        return text + (data.text.length > 20 ? '...' : '');
      }
    });

    $("#e_mtcode").select2({
      width: '100%',
      placeholder: "Select Maintenance Code",
      allowClear: true,
    });

    $("#e_inslist").select2({
      width: '100%',
      placeholder: "Select Instruction List Code",
      allowClear: true,
    });

    $("#e_splist").select2({
      width: '100%',
      placeholder: "Select Spare Part List Code",
      allowClear: true,
    });

    $("#e_qclist").select2({
      width: '100%',
      placeholder: "Select QC List Code",
      allowClear: true,
    });

    var cur_url = window.location.href;

    let paramString = cur_url.split('?')[1];
    let queryString = new URLSearchParams(paramString);

    let status = queryString.get('s_status');
    let wotype = queryString.get('s_wotype');
    let engineer = queryString.get('s_engineer')
    $('#s_status').val(status).trigger('change');
    $('#s_wotype').val(wotype).trigger('change');
    $('#s_engineer').val(engineer).trigger('change');

    $(document).on('change', '#c_failuretype', function() {
      var getAssetG = document.getElementById('hide_assetgroup').value;
      var getType = $(this).val();

      // console.log(getAssetG);
      // console.log(getType);
      $.ajax({
        url: "/checkfailurecodetype",
        data: {
          group: getAssetG,
          type: getType,

        },
        success: function(data) {
          var code = data.optionfailcode;

          // console.log(code);

          var selectthis = document.getElementById('failurecode');

          // Hapus semua option yang ada
          selectthis.innerHTML = '';

          // Tambahkan option baru
          code.forEach(data => {
            const option = document.createElement('option');
            option.value = data.fn_code;
            option.text = data.fn_code + ' - ' + data.fn_desc;
            selectthis.add(option);
          });
        }
      })
    });

    $(document).on('change', '#c_asset', function() {
      // document.getElementById('womanualchoose').style.display = '';
      var assetsite = $(this).find(':selected').data('assetsite');
      var assetloc = $(this).find(':selected').data('assetloc');

      document.getElementById('hide_site').value = assetsite;
      document.getElementById('hide_loc').value = assetloc;

      var selectedAsset = $(this).find("option:selected").data("assetgroup");

      document.getElementById('hide_assetgroup').value = selectedAsset;
      $('#failurecode').html('');
      document.getElementById('c_failuretype').value = '';

      var assetval = document.getElementById('c_asset').value;

    });

    $(document).on('click', '.editwo2', function() {
      $('#loadingtable').modal('show');
      // alert('aaa');

      var wonbr = $(this).data('wonumber');
      var status = $(this).data('status');
      var wotype = $(this).data('wotype');

      $.ajax({
        url: '/filtermaintcode',
        method: 'GET',
        data: {
          pmc_type: wotype
        },
        success: function(response) {
          // Manipulasi data di sini
          // console.log(response);

          var select = $('#e_mtcode');
          select.empty();
          select.append('<option value="">Select Maintenance Code</option>');
          $.each(response, function(key, value) {
            select.append('<option value="' + value.pmc_code + '">' + value.pmc_code + ' -- ' + value.pmc_desc + '</option>');
          });

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });

      if (status == "released" || status == "started") {
        // document.getElementById('e_engineerlist').setAttribute('readonly', true);
        document.getElementById('e_mtcode').setAttribute('readonly', true);
        document.getElementById('e_inslist').setAttribute('readonly', true);
        document.getElementById('e_splist').setAttribute('readonly', true);
        document.getElementById('e_qclist').setAttribute('readonly', true);
        document.getElementById('e_startdate').setAttribute('readonly', true);
        document.getElementById('e_duedate').setAttribute('readonly', true);
      }

      if (status == "firm") {
        document.getElementById('e_engineerlist').removeAttribute('readonly');
        document.getElementById('e_mtcode').removeAttribute('readonly');
        document.getElementById('e_inslist').removeAttribute('readonly');
        document.getElementById('e_splist').removeAttribute('readonly');
        document.getElementById('e_qclist').removeAttribute('readonly');
        document.getElementById('e_startdate').removeAttribute('readonly');
        document.getElementById('e_duedate').removeAttribute('readonly');
      }

      var btnendel1 = document.getElementById("btndeleteen1");
      var btnendel2 = document.getElementById("btndeleteen2");
      var btnendel3 = document.getElementById("btndeleteen3");
      var btnendel4 = document.getElementById("btndeleteen4");
      var btnendel5 = document.getElementById("btndeleteen5");
      var counter = document.getElementById('counter').value;
      var counterfail = document.getElementById('counterfail').value;

      $.ajax({
        url: '/womaint/getwoinfo',
        method: 'GET',
        data: {
          wonumber: wonbr,
        },
        success: function(vamp) {

          console.log(vamp);

          var wonumber = vamp.wo_master.wo_number;
          var srnumber = vamp.wo_master.wo_sr_number;
          var ewottype = vamp.wo_master.wo_failure_type;
          var assetgroup = vamp.asset.asset_group;
          var assetcode = vamp.wo_master.wo_asset_code;
          var assetdesc = vamp.asset.asset_desc;
          var englist = vamp.engineer;
          var failurelist = vamp.failurecode;
          var impact = vamp.impact;
          var startdate = vamp.wo_master.wo_start_date;
          var duedate = vamp.wo_master.wo_due_date;
          var priority = vamp.wo_master.wo_priority;
          var wonote = vamp.wo_master.wo_note;
          var mtcode = vamp.mtcode ? vamp.mtcode.pmc_code : '';
          var inslist = vamp.inslist ? vamp.inslist.ins_code : '';
          var splist = vamp.splist ? vamp.splist.spg_code : '';
          var qcslist = vamp.qcslist ? vamp.qcslist.qcs_code : '';
          var wostatus = vamp.wo_master.wo_status;

          let selectOptions = document.getElementById("e_engineerlist").options;

          for (let i = 0; i < selectOptions.length; i++) {
            for (let j = 0; j < englist.length; j++) {
              if (selectOptions[i].value == englist[j].eng_code) {
                selectOptions[i].setAttribute("selected", true);
              }
            }
          }

          $("#e_engineerlist").trigger("change");

          document.getElementById('e_nowo').value = wonumber;
          document.getElementById('e_nosr').value = srnumber;
          document.getElementById('e_wottype').value = ewottype;
          document.getElementById('e_asset').value = assetcode + " - " + assetdesc;
          document.getElementById('hide_editassetgroup').value = assetgroup;
          // document.getElementById('e_startdate').value = startdate;
          document.getElementById('e_duedate').value = duedate;
          document.getElementById('e_priority').value = priority;
          document.getElementById('e_note').value = wonote;
          document.getElementById('e_mtcode').value = mtcode;
          document.getElementById('e_inslist').value = inslist;
          document.getElementById('e_splist').value = splist;
          document.getElementById('e_qclist').value = qcslist;
          document.getElementById('e_assetcode').value = assetcode;

          // console.log(mtcode);

          //jika mtcode tidak kosong
          if (mtcode !== "") {
            $('#e_mtcode').val(mtcode).trigger('change');
          }


          $('#e_inslist').val(inslist).trigger('change');
          $('#e_splist').val(splist).trigger('change');
          $('#e_qclist').val(qcslist).trigger('change');

          $('#e_startdate').val(startdate).trigger('change');

          $("#e_wottype").trigger("change");


          $.ajax({
            url: "/checkfailurecodetype",
            data: {
              group: assetgroup,
              type: ewottype,
            },
            success: function(data) {
              var code = data.optionfailcode;

              // console.log(code);

              var selectthis = document.getElementById('m_failurecode');

              // Hapus semua option yang ada
              selectthis.innerHTML = '';

              // Tambahkan option baru
              code.forEach(data => {
                const option = document.createElement('option');
                option.value = data.fn_code;
                option.text = data.fn_code + ' - ' + data.fn_desc;
                selectthis.add(option);
              });

              let selectOptionsFail = document.getElementById("m_failurecode").options;

              for (let i = 0; i < selectOptionsFail.length; i++) {
                for (let j = 0; j < failurelist.length; j++) {
                  if (selectOptionsFail[i].value == failurelist[j].fn_code) {
                    selectOptionsFail[i].setAttribute("selected", true);
                  }
                }
              }

              $("#m_failurecode").trigger("change");

            }
          })

          let selectOptionsImp = document.getElementById('e_impact').options;

          for (let i = 0; i < selectOptionsImp.length; i++) {
            for (let j = 0; j < impact.length; j++) {
              if (selectOptionsImp[i].value == impact[j].imp_code) {
                selectOptionsImp[i].setAttribute("selected", true);
              }
            }
          }

          $("#e_impact").trigger("change");

        },
        complete: function(vamp) {
          //  $('.modal-backdrop').modal('hide');
          // alert($('.modal-backdrop').hasClass('in'));

          setTimeout(function() {
            $('#loadingtable').modal('hide');
          }, 500);


          setTimeout(function() {
            $('#editModal').modal('show');
          }, 1000);

        }
      })

      $.ajax({
        url: "/imageview_womaint",
        data: {
          wonumber: wonbr,
        },
        success: function(data) {

          $('#munculgambar_edit').html('').append(data);
        }
      })
    });

    $("#c_startdate").change(function() {
      var start_date = new Date($("#c_startdate").val());
      var due_date = new Date($("#c_duedate").val());
      var today = new Date();
      var min_date = start_date.toJSON().slice(0, 10);


      $("#c_duedate").prop("min", min_date);


      if (start_date > due_date) {
        $("#c_duedate").val($("#c_startdate").val());
      }
    });

    $('input[name="cwotype"]').on('change', function() {
      // ambil value dari input radio yang dipilih
      var selectedValue = $('input[name="cwotype"]:checked').val();

      // console.log(selectedValue);

      $.ajax({
        url: '/filtermaintcode',
        method: 'GET',
        data: {
          pmc_type: selectedValue
        },
        success: function(response) {
          // Manipulasi data di sini
          // console.log(response);

          var select = $('#c_mtcode');
          select.empty();
          select.append('<option value="">Select Maintenance Code</option>');
          $.each(response, function(key, value) {
            select.append('<option value="' + value.pmc_code + '">' + value.pmc_code + ' -- ' + value.pmc_desc + '</option>');
          });

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });

    $('#c_mtcode').on('change', function() {
      // alert('ganti');
      let selectedValue = $(this).val();
      $.ajax({
        url: '/searchic',
        method: 'GET',
        data: {
          pmc_code: selectedValue
        },
        success: function(response) {
          // Manipulasi data di sini
          // console.log(response);

          //jika response tidak kosong
          if (response && Object.keys(response).length) {
            let inslistval = response.pmc_ins;
            let spglistval = response.pmc_spg;
            let qcslistval = response.pmc_qcs;

            $('#c_inslist option[value !="' + inslistval + '"]').prop('disabled', true);
            $('#c_inslist option[value="' + inslistval + '"]').prop('disabled', false);
            $('#c_inslist').val(inslistval).trigger('change');

            $('#c_splist option[value !="' + spglistval + '"]').prop('disabled', true);
            $('#c_splist option[value="' + spglistval + '"]').prop('disabled', false);
            $('#c_splist').val(spglistval).trigger('change');

            $('#c_qclist option[value !="' + qcslistval + '"]').prop('disabled', true);
            $('#c_qclist option[value="' + qcslistval + '"]').prop('disabled', false);
            $('#c_qclist').val(qcslistval).trigger('change');

            $("#c_inslist").select2({
              width: '100%',
              placeholder: "Select Instruction List Code",
              allowClear: false,
            });

            $("#c_splist").select2({
              width: '100%',
              placeholder: "Select Spare Part List Code",
              allowClear: false,
            });

            $("#c_qclist").select2({
              width: '100%',
              placeholder: "Select QC List Code",
              allowClear: false,
            });

          } else { //jika response kosong karena user click tanda "x" di field select maintenance code
            $('#c_inslist option[value!=""]').prop('disabled', false);
            $('#c_inslist').val('').trigger('change');

            $('#c_splist option').prop('disabled', false);
            $('#c_splist').val('').trigger('change');

            $('#c_qclist option').prop('disabled', false);
            $('#c_qclist').val('').trigger('change');

            $("#c_inslist").select2({
              width: '100%',
              placeholder: "Select Instruction List Code",
              allowClear: true,
            });

            $("#c_splist").select2({
              width: '100%',
              placeholder: "Select Spare Part List Code",
              allowClear: true,
            });

            $("#c_qclist").select2({
              width: '100%',
              placeholder: "Select QC List Code",
              allowClear: true,
            });
          }

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });

    $("#e_startdate").change(function() {
      var start_date = new Date($("#e_startdate").val());
      var due_date = new Date($("#e_duedate").val());
      var today = new Date();
      var min_date = start_date.toJSON().slice(0, 10);


      $("#e_duedate").prop("min", min_date);


      if (start_date > due_date) {
        $("#e_duedate").val($("#e_startdate").val());
      }
    });

    $('#e_mtcode').on('change', function() {
      // alert('ganti');
      let selectedValue = $(this).val();

      console.log(selectedValue);
      $.ajax({
        url: '/searchic',
        method: 'GET',
        data: {
          pmc_code: selectedValue
        },
        success: function(response) {
          // Manipulasi data di sini
          // console.log(response);

          //jika response tidak kosong
          if (response && Object.keys(response).length) {
            let inslistval = response.pmc_ins;
            let spglistval = response.pmc_spg;
            let qcslistval = response.pmc_qcs;

            $('#e_inslist option[value !="' + inslistval + '"]').prop('disabled', true);
            $('#e_inslist option[value="' + inslistval + '"]').prop('disabled', false);
            $('#e_inslist').val(inslistval).trigger('change');

            $('#e_splist option[value !="' + spglistval + '"]').prop('disabled', true);
            $('#e_splist option[value="' + spglistval + '"]').prop('disabled', false);
            $('#e_splist').val(spglistval).trigger('change');

            $('#e_qclist option[value !="' + qcslistval + '"]').prop('disabled', true);
            $('#e_qclist option[value="' + qcslistval + '"]').prop('disabled', false);
            $('#e_qclist').val(qcslistval).trigger('change');

            $("#e_inslist").select2({
              width: '100%',
              placeholder: "Select Instruction List Code",
              allowClear: false,
            });

            $("#e_splist").select2({
              width: '100%',
              placeholder: "Select Spare Part List Code",
              allowClear: false,
            });

            $("#e_qclist").select2({
              width: '100%',
              placeholder: "Select QC List Code",
              allowClear: false,
            });

          } else { //jika response kosong karena user click tanda "x" di field select maintenance code
            $('#e_inslist option[value!=""]').prop('disabled', false);
            $('#e_inslist').val('').trigger('change');

            $('#e_splist option').prop('disabled', false);
            $('#e_splist').val('').trigger('change');

            $('#e_qclist option').prop('disabled', false);
            $('#e_qclist').val('').trigger('change');

            $("#e_inslist").select2({
              width: '100%',
              placeholder: "Select Instruction List Code",
              allowClear: true,
            });

            $("#e_splist").select2({
              width: '100%',
              placeholder: "Select Spare Part List Code",
              allowClear: true,
            });

            $("#e_qclist").select2({
              width: '100%',
              placeholder: "Select QC List Code",
              allowClear: true,
            });
          }

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });

    $(document).on('click', '.deleterow', function(e) {
      var data = $(this).closest('tr').find('.rowval').val();

      Swal.fire({
        title: '',
        text: "Delete File ?",
        icon: '',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "/delfilewomaint/" + data,
            success: function(data) {

              $('#munculgambar_edit').html('').append(data);
            }
          })
        }
      })
    });

    $(document).on('click', '.maintcode', function(e) {
      $('#maintCodeModal').modal('show');

      //   e.stopPropagation();

      // document.getElementById('btnclose_b').addEventListener('click', function() {
      //   // Mengatur fokus kembali pada modal pertama
      //   document.getElementById('maintCodeModal').style.display = 'none';
      //   document.getElementById('viewModal').style.display = 'block';
      //   document.getElementById('wotype').focus();

      //   document.body.classList.remove('modal-open');
      // });

      //muncul saat modal pertama kali muncul
      //maintenance code
      var output = '';
      output += '<tr>';
      output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Maintenace Code first! </td>';
      output += '</tr>';
      $('#b_mtcodetable').html('').append(output);

      //instruction list
      var output = '';
      output += '<tr>';
      output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction List Code first! </td>';
      output += '</tr>';
      $('#b_inslisttable').html('').append(output);

      //sparepart list
      var output = '';
      output += '<tr>';
      output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction Sparepart Code first! </td>';
      output += '</tr>';
      $('#b_splisttable').html('').append(output);

      //qc list
      var output = '';
      output += '<tr>';
      output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction QC Code first! </td>';
      output += '</tr>';
      $('#b_qclisttable').html('').append(output);

      $(document).on('change', '#b_mtcode', function() {

        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchic',
          method: 'GET',
          data: {
            pmc_code: selectedValue
          },
          success: function(response) {

            if (Object.keys(response).length === 0) {
              //jika data yang dipilih valuenya tidak ada
              var output = '';
              output += '<tr>';
              output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Maintenace Code first! </td>';
              output += '</tr>';

              $('#b_mtcodetable').html('').append(output);

              $('#b_inslist option[value!=""]').prop('disabled', false);
              $('#b_inslist').val('').trigger('change');

              $('#b_splist option').prop('disabled', false);
              $('#b_splist').val('').trigger('change');

              $('#b_qclist option').prop('disabled', false);
              $('#b_qclist').val('').trigger('change');

              $("#b_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: true,
              });

              $("#b_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: true,
              });

              $("#b_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: true,
              });
            } else {
              //jika data yang dipilih valuenya ada
              var output = '';
              output += '<tr>';
              output += '<td>' + response.pmc_code + ' -- ' + response.pmc_desc + '</td>';
              output += '<td>' + response.pmc_type + '</td>';
              output += '<td>' + response.pmc_ins + '</td>';
              output += '<td>' + response.pmc_spg + '</td>';
              output += '<td>' + response.pmc_qcs + '</td>';
              output += '</tr>';

              $('#b_mtcodetable').html('').append(output);

              let inslistval = response.pmc_ins;
              let spglistval = response.pmc_spg;
              let qcslistval = response.pmc_qcs;

              $('#b_inslist option[value !="' + inslistval + '"]').prop('disabled', true);
              $('#b_inslist option[value="' + inslistval + '"]').prop('disabled', false);
              $('#b_inslist').val(inslistval).trigger('change');

              $('#b_splist option[value !="' + spglistval + '"]').prop('disabled', true);
              $('#b_splist option[value="' + spglistval + '"]').prop('disabled', false);
              $('#b_splist').val(spglistval).trigger('change');

              $('#b_qclist option[value !="' + qcslistval + '"]').prop('disabled', true);
              $('#b_qclist option[value="' + qcslistval + '"]').prop('disabled', false);
              $('#b_qclist').val(qcslistval).trigger('change');

              $("#b_inslist").select2({
                width: '100%',
                placeholder: "Select Instruction List Code",
                allowClear: false,
              });

              $("#b_splist").select2({
                width: '100%',
                placeholder: "Select Spare Part List Code",
                allowClear: false,
              });

              $("#b_qclist").select2({
                width: '100%',
                placeholder: "Select QC List Code",
                allowClear: false,
              });
            }
          }
        });
      });

      $(document).on('change', '#b_inslist', function() {

        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchil',
          method: 'GET',
          data: {
            ins_code: selectedValue
          },
          success: function(response) {
            if (Object.keys(response).length === 0) {
              //jika data yang dipilih valuenya tidak ada
              var output = '';
              output += '<tr>';
              output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction List Code first! </td>';
              output += '</tr>';

              $('#b_inslisttable').html('').append(output);
            } else {
              //jika data yang dipilih valuenya ada
              var output = '';
              for (var i = 0; i < response.length; i++) {
                output += '<tr>';
                output += '<td>' + response[i].ins_code + ' -- ' + response[i].ins_desc + '</td>';
                output += '<td>' + response[i].ins_duration + '</td>';
                output += '<td>' + response[i].ins_durationum + '</td>';
                output += '<td>' + response[i].ins_manpower + '</td>';
                output += '<td>' + response[i].ins_step + '</td>';
                output += '<td>' + response[i].ins_stepdesc + '</td>';
                if (response[i].ins_ref == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].ins_ref + '</td>';
                }
                output += '</tr>';
              }

              $('#b_inslisttable').html('').append(output);
            }
          }
        });
      });

      $(document).on('change', '#b_splist', function() {

        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchis',
          method: 'GET',
          data: {
            spg_code: selectedValue
          },
          success: function(response) {
            if (Object.keys(response).length === 0) {
              //jika data yang dipilih valuenya tidak ada
              var output = '';
              output += '<tr>';
              output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction Sparepart Code first! </td>';
              output += '</tr>';

              $('#b_splisttable').html('').append(output);
            } else {
              //jika data yang dipilih valuenya ada
              var output = '';
              for (var i = 0; i < response.length; i++) {
                output += '<tr>';
                output += '<td>' + response[i].spg_code + ' -- ' + response[i].spg_desc + '</td>';
                if (response[i].spg_spcode == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].spg_spcode + '</td>';
                }
                if (response[i].spg_qtyreq == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].spg_qtyreq + '</td>';
                }
                output += '</tr>';
              }

              $('#b_splisttable').html('').append(output);
            }
          }
        });
      });

      $(document).on('change', '#b_qclist', function() {

        let selectedValue = $(this).val();
        $.ajax({
          url: '/searchiq',
          method: 'GET',
          data: {
            qcs_code: selectedValue
          },
          success: function(response) {
            if (Object.keys(response).length === 0) {
              //jika data yang dipilih valuenya tidak ada
              var output = '';
              output += '<tr>';
              output += '<td colspan="12" style="text-align:center; color:red;"> Please select the Instruction QC Code first! </td>';
              output += '</tr>';

              $('#b_qclisttable').html('').append(output);
            } else {
              //jika data yang dipilih valuenya ada
              var output = '';
              for (var i = 0; i < response.length; i++) {
                output += '<tr>';
                output += '<td>' + response[i].qcs_code + ' -- ' + response[i].qcs_desc + '</td>';
                output += '<td>' + response[i].qcs_spec + '</td>';
                if (response[i].qcs_tools == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].qcs_tools + '</td>';
                }
                output += '<td>' + response[i].qcs_op + '</td>';
                output += '<td>' + response[i].qcs_val1 + '</td>';
                if (response[i].qcs_val2 == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].qcs_val2 + '</td>';
                }
                if (response[i].qcs_um == null) {
                  output += '<td></td>';
                } else {
                  output += '<td>' + response[i].qcs_um + '</td>';
                }
                output += '</tr>';
              }

              $('#b_qclisttable').html('').append(output);
            }
          }
        });
      });


    });

    $("#assetloc").change(function() {
      var selectedAssetLoc = $("#assetloc").val();
      // console.log(selectedAssetLoc);
      $.ajax({
        url: "/assetbyloc_wo",
        data: {
          assetloc: selectedAssetLoc,
        },
        success: function(data) {
          // var type = data.optionfailtype;
          var code = data.optionassetcode;

          // $('#wotype').html(type);
          $('#c_asset').html('');
          $('#c_asset').html(code);
          $('#c_asset').trigger("change");
        }
      });
    });

  });
  $(document).on('click', '.reopen', function() {

    var wonbr = this.getAttribute('data-wonbr');
    // alert(wonbr);
    document.getElementById('d_rowonbr').textContent = wonbr;
    document.getElementById('tmp_rowonbr').value = wonbr;
    $('#reopenModal').modal('show');

  });
  $(document).on('click', '#createnewwo', function(e) {
    document.getElementById('counter').value = 0;
    document.getElementById('counterfail').value = 0;
  })

  $(document).on('click', '.accepting', function() {
    var wonbr = $(this).closest('tr').find('input[name="wonbrr"]').val();
    // $('#loadingtable').modal('hide');
    $('#loadingtable').modal('show');
    var counter = document.getElementById('v_counter').value;

    $.ajax({
      url: '/womaint/getnowo?nomorwo=' + wonbr,
      success: function(vamp) {
        var tempres = JSON.stringify(vamp);
        var result = JSON.parse(tempres);
        var wonbr = result[0].wo_nbr;
        var srnbr = result[0].wo_sr_nbr;
        var asset = result[0].asset_desc;
        var wostatus = result[0].wo_status;
        var repair1 = result[0].rr11;
        var repair2 = result[0].rr22;
        var repair3 = result[0].rr33;
        var en1val = result[0].u11;
        var en2val = result[0].u22;
        var en3val = result[0].u33;
        var en4val = result[0].u44;
        var en5val = result[0].u55;
        var schedule = result[0].wo_schedule;
        var duedate = result[0].wo_duedate;
        var fc1 = result[0].wofc1;
        var fc2 = result[0].wofc2;
        var fc3 = result[0].wofc3;
        var fn1 = result[0].fd1;
        var fn2 = result[0].fd2;
        var fn3 = result[0].fd3;
        var prio = result[0].wo_priority;
        var note = result[0].wo_note;
        var wodept = result[0].dept_desc;
        var rc1 = result[0].r11;
        var rc2 = result[0].r22;
        var rc3 = result[0].r33;
        var rd1 = result[0].rr11;
        var rd2 = result[0].rr22;
        var rd3 = result[0].rr33;
        // var repairhour  = result[0].wo_repair_hour;
        var finishdate = result[0].wo_finish_date;
        var finishtime = result[0].wo_finish_time;
        var repairtype = result[0].wo_repair_type;
        var repairgroup = result[0].xxrepgroup_desc;
        var superappdate = result[0].wo_reviewer_appdate;
        var apprdate = result[0].wo_approval_appdate;
        var apprnote = result[0].wo_approval_note;
        var wotype = result[0].wo_type;
        var action = result[0].wo_action;
        var rejectnote = result[0].wo_reject_reason;
        // alert(srnbr);
        // alert(repairhour)
        if (wotype == 'auto') {
          document.getElementById('aprint').style.display = 'none';
        }
        if (fc1 == null || fc1 == '') {
          document.getElementById('acdivfail1').style.display = 'none';
        } else {
          document.getElementById('acdivfail1').style.display = '';
          document.getElementById('ac_failure1').value = fn1;

          counterfail = 1;
        }

        if (fc2 == null || fc2 == '') {
          document.getElementById('acdivfail2').style.display = 'none';
        } else {
          document.getElementById('acdivfail2').style.display = '';
          document.getElementById('ac_failure2').value = fn2;

          counterfail = 2;
        }

        if (fc3 == null || fc3 == '') {
          document.getElementById('acdivfail3').style.display = 'none';
        } else {
          document.getElementById('acdivfail3').style.display = '';
          document.getElementById('ac_failure3').value = fn3;

          counterfail = 3;
        }

        if (en1val == null || en1val == '') {
          en1val = '';
        } else {
          document.getElementById('acdivengineer1').style.display = '';
          counter = 1;
        }

        if (en2val == null || en2val == '') {
          en2val = '';
          document.getElementById('acdivengineer2').style.display = 'none';
        } else {
          document.getElementById('acdivengineer2').style.display = '';
          counter = 2;
        }
        if (en3val == null || en3val == '') {
          en3val = '';
          document.getElementById('acdivengineer3').style.display = 'none';
        } else {
          document.getElementById('acdivengineer3').style.display = '';
          counter = 3;
        }

        if (en4val == null || en4val == '') {
          en4val = '';
          document.getElementById('acdivengineer4').style.display = 'none';
        } else {
          document.getElementById('acdivengineer4').style.display = '';
          counter = 4;
        }

        if (en5val == null || en5val == '') {
          en5val = '';
          document.getElementById('acdivengineer5').style.display = 'none';
        } else {
          document.getElementById('acdivengineer5').style.display = '';
          counter = 5;
        }

        var arrrc = [];

        if (rc1 != null) {
          arrrc.push(rd1 + ' -- ' + rc1);
        }
        if (rc2 != null) {
          arrrc.push(rd2 + ' -- ' + rc2);
        }
        if (rc3 != null) {
          arrrc.push(rd3 + ' -- ' + rc3);
        }

        var event = new Event('change', {
          "bubbles": true
        });
        // alert(arrrc);
        document.getElementById('apprwonbr3').value = wonbr;
        document.getElementById('apprsrnbr3').value = srnbr;
        document.getElementById('counter').value = counter;
        document.getElementById('ac_engineer1').value = en1val;
        document.getElementById('ac_engineer2').value = en2val;
        document.getElementById('ac_engineer3').value = en3val;
        document.getElementById('ac_engineer4').value = en4val;
        document.getElementById('ac_engineer5').value = en5val;
        document.getElementById('ac_failure1').value = fn1;
        document.getElementById('ac_failure2').value = fn2;
        document.getElementById('ac_failure3').value = fn3;
        document.getElementById('counterfail').value = counterfail;
        document.getElementById('apprwonbr2').value = wonbr;
        document.getElementById('apprwonbr').value = wonbr;
        document.getElementById('c_finishtime').value = finishtime;
        document.getElementById('c_finishdate').value = finishdate;
        // document.getElementById('c_repairhour').value = repairhour;
        document.getElementById('statuswo').value = wostatus;
        document.getElementById('v_counter').value = counter;
        document.getElementById('ac_wonbr2').value = wonbr;
        document.getElementById('ac_srnbr2').value = srnbr;
        document.getElementById('ac_asset2').value = asset;
        document.getElementById('uncompletenote').value = rejectnote;

        document.getElementById('ac_note').value = note;

        if (apprnote != null) {
          document.getElementById('ac_reportnote').value = apprnote;
        } else {
          document.getElementById('ac_reportnote').value = action;
        }





        if (repairtype == 'code') {
          var textareaview = document.getElementById('ac_repaircode');
          textareaview.value = arrrc.join("\n");
          document.getElementById('divaccode').style.display = '';
          document.getElementById('divacgroup').style.display = 'none';
          document.getElementById('divacmanual').style.display = 'none';

        } else if (repairtype == 'group') {

          var vgroup = document.getElementById('ac_repairgroup').value = result[0].xxrepgroup_nbr + ' -- ' + repairgroup;
          document.getElementById('divaccode').style.display = 'none';
          document.getElementById('divacmanual').style.display = 'none';
          document.getElementById('divacgroup').style.display = '';
        } else if (repairtype == 'manual') {
          document.getElementById('divaccode').style.display = 'none';
          document.getElementById('divacmanual').style.display = '';
          document.getElementById('divacgroup').style.display = 'none';
        } else {
          document.getElementById('divaccode').style.display = 'none';
          document.getElementById('divacgroup').style.display = 'none';
          document.getElementById('divacmanual').style.display = 'none';
        }
        if (superappdate == null) {
          document.getElementById('formtype').value = 1;
        } else if (superappdate != null) {
          document.getElementById('formtype').value = 2;
        }

        // A211019
        if (wostatus == 'reprocess') {
          document.getElementById("ac_reportnote").readOnly = false;
        } else {
          document.getElementById("ac_reportnote").readOnly = true;
        }

        // uploadImage();
        $.ajax({
          url: "/imageview",
          data: {
            wonumber: wonbr,
          },
          success: function(data) {
            // console.log(data);

            /* coding asli ada di backup-20211026 sblm PM attach file, coding aslinya nampilin gambar*/
            //alert('test');

            $('#munculgambar').html('').append(data);
          }
        })

      },
      complete: function(vamp) {
        //  $('.modal-backdrop').modal('hide');
        // alert($('.modal-backdrop').hasClass('in'));

        setTimeout(function() {
          $('#loadingtable').modal('hide');

        }, 500);

        setTimeout(function() {
          $('#acceptModal').modal('show');
        }, 1000);

      }

    })
  });


  $(document).on('change', '#e_failure1', function(e) {
    document.getElementById('hiddenfail1').value = document.getElementById('e_failure1').value;

  })
  $(document).on('change', '#e_failure2', function(e) {
    document.getElementById('hiddenfail2').value = document.getElementById('e_failure2').value;

  })
  $(document).on('change', '#e_failure3', function(e) {
    document.getElementById('hiddenfail3').value = document.getElementById('e_failure3').value;

  })

  $(".delfile").click(function() {
    // console.log('deleteAttachment[]');
    var c = confirm("Are you sure you want to delete?");
    if (c) {
      var id = $(this).data("id");
      alert(id);
      $.ajax({
        url: '/kn/' + id + '/delete_filecase',
        type: 'POST',
        data: {
          "id": id,
          '_token': "{{csrf_token()}}",
          '_method': "POST"
        },
        dataType: 'json',
        success: function(data) {
          // alert(id);
          // alert(message.data);
          location.reload(true);
        },
        error: function(data, textStatus, errorThrown) {
          // console.log(data);
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('click', '#aprint', function(event) {
    var wonbr = document.getElementById('ac_wonbr2').value;
    var url = "{{url('openprint2','id')}}";
    // var newo = JSON.stringify(wonbr);
    url = url.replace('id', wonbr);
    // alert(url);
    document.getElementById('aprint').href = url;
  });

  $("#acceptance").submit(function() {
    document.getElementById('btnclose').style.display = 'none';
    document.getElementById('btnreject').style.display = 'none';
    document.getElementById('btnapprove').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });

  $(document).on('click', '#ac_btnuncom', function(event) {
    document.getElementById('switch2').value = 'reject';
    var rejectreason = document.getElementById('uncompletenote').value;

    // event.preventDefault();
    // $('#approval')

    if (rejectreason == "") {
      $("#t_photo").attr('required', false);
      $("#uncompletenote").attr('required', true);
    } else {
      // alert('masuk sini');
      $("#t_photo").attr('required', false);
      $("#uncompletenote").attr('required', true);
      $('#acceptance').submit();

    }
  })

  $(document).on('click', '#ac_btncom', function(event) {
    document.getElementById('switch2').value = 'approve';

    $("#uncompletenote").attr('required', false);
    $('#acceptance').submit();
  })

  $(document).on('click', '.deleterow', function(e) {
    var data = $(this).closest('tr').find('.rowval').val();

    Swal.fire({
      title: '',
      text: "Delete File??",
      icon: '',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "/delfilewofinish/" + data,
          success: function(data) {

            $('#munculgambar').html('').append(data);
          }
        })
      } else {

      }
    })


  });
</script>
@endsection