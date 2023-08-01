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
        font-weight: bold;
    }

    .card-link3 {
        text-decoration: none;
        color: inherit;
        display: block;
        color: white;
        font-weight: bold;
    }
</style>
<div class="container p-1" style="background-color: white; height: 34rem;">
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="card-text text-center font-weight-bold" style="color: #5B9BD5;">SETUP</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{asset('images/robot-setup.png')}}" height="300" width="200" alt="Card image cap">
                </div>
            </div>
        </div>
        <div class="col-md-6 p-2">
            <div class="row">
                <!-- Row 3 -->
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 7rem; background-color: #7030A0; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link1" href="/engmaster" target="_blank">Register a user</a>
                            <a class="card-link1" href="/rolemaster" target="_blank">Define user's role</a>
                            <a class="card-link1" href="/enggroup" target="_blank">Group the engineers</a>
                        </div>
                    </div>
                </div>
                <!-- Row 4 -->
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 12rem; background-color: #FFC000; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link2" href="/assetsite" target="_blank">Register a Site</a>
                            <a class="card-link2" href="/assetloc" target="_blank">Register a Location</a>
                            <a class="card-link2" href="/assetmaster" target="_blank">Register an asset</a>
                            <a class="card-link2" href="/asparmaster" target="_blank">Asset hierarchy</a>
                            <a class="card-link2" href="/pmasset" target="_blank">Attach PM code to an asset</a>
                            <a class="card-link2" href="/spmmaster" target="_blank">Register a spare part</a>
                        </div>
                    </div>
                </div>
                <!-- Row 5 -->
                <div class="col-md-12">
                    <div class="card" style="border-radius: 30px; height: 11rem; background-color: #C00000; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                        <div class="card-body text-center">
                            <a class="card-link3" href="/inslist " target="_blank">Define repair or PM instruction</a>
                            <a class="card-link3" href="/splist" target="_blank">Define spare part to be used</a>
                            <a class="card-link3" href="/qcspec" target="_blank">Define quality specification</a>
                            <a class="card-link3" href="/pmcode" target="_blank">Register PM/CM Code</a>
                            <a class="card-link3" href="/appsr" target="_blank">Approval SR setting</a>
                            <a class="card-link3" href="/appwo" target="_blank">Approval WO setting</a>
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