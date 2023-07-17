@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">My Routine Check Detail</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active">My Routine Check Detail</li>
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

<form action="/myroutinesubmit" method="post" id="submitform" enctype="multipart/form-data">
  {{ csrf_field() }}

  <input type="hidden" name="rcm_activity_id" value="{{$rcm_activity->id}}" />

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <label for="qc_desc1" class="form-label">QC Spec Code</label>
            </div>
            <div class="col-md-7">
              <input type="text" class="form-control" id="qcspc" name="qcspc" value="{{$rcm_activity->ra_qcs_code}}" readonly>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-5">
              <label for="qc_desc2" class="form-label">QC Spec Desc</label>
            </div>
            <div class="col-md-7">
              <input type="text" class="form-control" id="qcspcd" name="qcspcd" value="{{$rcm_activity->ra_qcs_desc}}" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <label for="qc_desc3" class="form-label">Start Time</label>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" id="rcm_starttime" name="rcm_starttime" value="{{date('H:i', strtotime($rcm_activity->ra_schedule_time))}}" readonly>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label for="qc_desc4" class="form-label">Last Check</label>
            </div>
            <div class="col-md-6">
              @if ($lastchecktime == null)
              <input type="text" class="form-control" id="rcm_lastcheck" name="rcm_lastcheck" value="-" readonly>
              @else
              <input type="text" class="form-control" id="rcm_lastcheck" name="rcm_lastcheck" value="{{$lastchecktime->ra_actual_check_time}}" readonly>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @foreach($qcsdata_det as $datas)
  <div class="card">
    <div class="card-body">
      <div class="row mt-3">
        <div class="col-md-4">
          <label for="qc_desc" class="form-label">QC Spec</label>
        </div>
        <div class="col-md-4">
          <input type="hidden" name="qc_code[]" value="{{$datas->qcs_code}}" />
          <input type="hidden" name="qc_desc[]" value="{{$datas->qcs_desc}}" />
          <input type="text" class="form-control" name="qc_spec[]" value="{{$datas->qcs_spec}}" readonly>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4">
          <label for="qc_desc" class="form-label">Result</label>
        </div>
        <div class="col-md-4">
          <input type="{{ in_array($datas->qcs_op, ['<', '>', '=', '<=', '>=']) ? 'number' : 'text' }}" class="form-control" name="qc_result1[]" placeholder="result value...">
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4">
          <label for="qc_desc" class="form-label">Note</label>
        </div>
        <div class="col-md-4">
          <textarea type="text" class="form-control" name="qc_note[]" placeholder="result note..." rows="3"></textarea>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <div class="d-flex justify-content-center mt-3">
    <div class="d-grid gap-2">
      <a class="btn btn-danger" id="btnback" name="btnback" href="/myroutine">Back</a>
      <button type="submit" class="btn btn-primary" id="btn1" name="btnconf" value="1">Confirm</button>
      <button type="submit" class="btn btn-warning" id="btn2" name="btnconf" value="2">Confirm &amp; Send Alert</button>
    </div>
    <button type="button" class="btn btn-info ml-2" id="btnloading" style="display:none; width: 150px !important;">
      <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
    </button>
  </div>





</form>


@endsection

@section('scripts')
<script>
  $('#submitform').submit(function(event) {
    document.getElementById('btn1').style.display = 'none';
    document.getElementById('btn2').style.display = 'none';
    document.getElementById('btnback').style.display = 'none';
    document.getElementById('btnloading').style.display = '';
  });
</script>
@endsection