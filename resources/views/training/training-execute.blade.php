@extends('layout.newlayout')

@section('content-header')
@endsection
@section('content')
<style>
    .card-link1 {
        text-decoration: none;
        color: inherit;
        display: block;
        color: white;
        font-weight: bold;
    }

    .card-link2 {
        text-decoration: none;
        color: inherit;
        display: block;
        color: white;
        font-weight: bold;
    }

    .card-link3 {
        text-decoration: none;
        color: inherit;
        display: block;
        font-weight: bold;
    }

    .card-link4 {
        text-decoration: none;
        color: inherit;
        display: block;
        font-weight: bold;
    }
</style>
<div class="container p-4" style="background-color: white; height: 35rem;">
    <div class="row">
        <div class="col-md-6 p-2 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 7rem; background-color: #7030A0; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link1" href="/servicerequest" target="_blank">Record a Service Request (SR)</a>
                            <a class="card-link1" href="/srapproval" target="_blank">SR approval per department</a>
                            <a class="card-link1" href="/srapprovaleng" target="_blank">SR approval by Engineering department</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8" style="position: relative;">
                            <h1 class="card-text text-right font-weight-bold" style="color: #5B9BD5; position: absolute; bottom: 0; left: 0; right: 0;">EXECUTE</h1>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('images/execute-robot.png')}}" height="260" width="135" alt="Card image cap" style="float: right;">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-2">
                    <div class="card" style="border-radius: 30px; height: 6rem; background-color: #C00000; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link1" href="/myroutine" target="_blank">Record routine check</a>
                            <a class="card-link1" href="/usagemt" target="_blank">Record asset reading</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 p-2">
            <div class="row">
                <!-- Row 4 -->
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 15rem; background-color: #9DC3CB; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link3" href="/womaint" target="_blank">Create or modify a work order (WO)</a>
                            <a class="card-link3" href="/worelease" target="_blank">Active a WO and spare part request</a>
                            <a class="card-link3" href="/woreleaseapprovalbrowse" target="_blank">Spare part request approval</a>
                            <a class="card-link3" href="/wotransfer" target="_blank">Transfer spare parts to engineers</a>
                            <a class="card-link3" href="/wojoblist" target="_blank">Start a work order</a>
                            <a class="card-link3" href="/woreport" target="_blank">Record work order activities</a>
                            <a class="card-link3" href="/woapprovalbrowse" target="_blank">Work order completion approval</a>
                            <a class="card-link3" href="/useracceptance" target="_blank">Work order approval by service request</a>
                        </div>
                    </div>
                </div>
                <!-- Row 5 -->
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 15rem; background-color: #A9D18E; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link4" href="/booking" target="_blank">Book an asset</a>
                            <a class="card-link4" href="/whyhist" target="_blank">Record 5 Whys</a>
                            <a class="card-link4" href="/reqsp" target="_blank">Non WO spare part request</a>
                            <a class="card-link4" href="/reqspapproval" target="_blank">Non WO spare part request approval</a>
                            <a class="card-link4" href="/accutransfer" target="_blank">Non WO accumulative spare part request</a>
                            <a class="card-link4" href="/trfsp" target="_blank">Non WO sparepart transfer</a>
                            <a class="card-link4" href="/retsp" target="_blank">Spare part return to warehouse</a>
                            <a class="card-link4" href="/assetmove" target="_blank">Transfer an asset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




@section('scripts')
<script>
</script>
@endsection