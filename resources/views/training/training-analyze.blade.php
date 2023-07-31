@extends('layout.newlayout')

@section('content-header')
@endsection
@section('content')
<style>
    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>
<div class="container p-4" style="background-color: white; height: 33rem;">
    <div class="row p-2">
        <div class="col-md-12">
            <h1 class="card-text text-center font-weight-bold" style="color: #5B9BD5;">ANALYZE</h1 </div>
        </div>
    </div>
    <div class="row p-2">
        <div class="col-md-3">
            <a href="/engrpt" target="_blank" class="card-link">
                <div class="card" style="border-radius: 10px; height: 20rem;">
                    <img class="card-img-top" style="border-radius: 50px;" src="{{asset('images/pik1.png')}}" width="100" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">Engineer Report</h3>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/assetsch" target="_blank" class="card-link">
                <div class="card" style="border-radius: 10px; height: 20rem;">
                    <img class="card-img-top" style="border-radius: 50px;" src="{{asset('images/pik2.png')}}" width="100" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">Asset Maintenance Schedule</h3>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/rptcost" target="_blank" class="card-link">
                <div class="card" style="border-radius: 10px; height: 20rem;">
                    <img class="card-img-top" style="border-radius: 50px;" src="{{asset('images/pik3.png')}}" width="100" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">Cost Report</h3>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="/engsch" target="_blank" class="card-link">
                <div class="card" style="border-radius: 10px; height: 20rem;">
                    <img class="card-img-top" style="border-radius: 50px;" src="{{asset('images/pik4.png')}}" width="100" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">Engineer Schedule</h3>
                    </div>

                </div>
            </a>
        </div>
    </div>
</div>
@endsection




@section('scripts')
<script>
</script>
@endsection