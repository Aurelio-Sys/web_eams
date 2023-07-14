@extends('layout.newlayout')

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6 mt-2">
      <h1 class="m-0 text-dark">My Routine Check Browse</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active">My Routine Check Browse</li>
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

@foreach($datasroutine as $datas)
<a href="{{ route('myrcdetail', ['id' => $datas->id]) }}" style="color: black;">
  <div class="card">
      <div class="card-body">
          <div class="d-flex justify-content-between">
              <h5 class="card-title"><b>{{$datas->ra_asset_code}} -- {{$datas->asset_desc}}</b></h5>
              <p class="card-text">{{date('H:i', strtotime($datas->ra_schedule_time))}}</p>
          </div>
          <div class="d-flex justify-content-between">
            <h6>{{$datas->ra_qcs_code}} -- {{$datas->ra_qcs_desc}}</h6>
          </div>
          
      </div>
  </div>
</a>
@endforeach


@endsection

@section('scripts')
<script>
  
</script>
@endsection